<?PHP
/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */

require_once('modules/reg_qmail/reg_qmail_sugar.php');
require_once('include/SugarPHPMailer.php');  

class reg_qmail extends reg_qmail_sugar {

  function reg_qmail() {
    parent::reg_qmail_sugar();
  }

  
  
  /**
   * Insert and update logic for Queued Mail
   */
  function save($check_notify = FALSE){
    
    // Serialize and encode variables
    if( is_array($this->variables) ){
      $this->variables = base64_encode( serialize( $this->variables ) );  
    }else{
      $GLOBALS['log']->error('Regoluna Mail Queue - "Variables" must be an array');
      $this->variables = null;
    }
    
    parent::save($check_notify);
  }
  
  
  
  /**
   * Try to send queued mail.
   */
  function send() {
    global $timedate;
    
    $mail=self::getPhpMailer();

    //Set RCPT address
    $mail->AddAddress($this->recipient , '');

    //$mail->MsgHTML( $this->getEmailBody() );
    $mail->Body = $this->getEmailBody() ;
    $mail->IsHTML(true);
    $mail->Subject = $this->name;
    $mail->CharSet = "utf-8";
    $mail->prepForOutbound();
    $mail->setMailerForSystem();
    
    $sender = self::getSenderData();
    $mail->From = $sender['mail'];
    $mail->FromName = $sender['name'];

    //Send the message
    if (!$mail->Send()) {
      $GLOBALS['log']->error('Regoluna Mail Queue - Error sending e-mail: '.$mail->ErrorInfo);
      $this->in_queue = 3; // Error code
      $this->error_message = $mail->ErrorInfo;
    }else{
      $this->in_queue = 2; // Sent code
      /// @todo Test date time format in Sugar 6.x
      $this->sent_date = date( $timedate->get_date_time_format() );
      $this->error_message = '';
    }
    
    $this->save();
    
    return !$this->error;
  }

  
  
  /**
   * 
   * Constructs email content.
   *
   */
  function getEmailBody(){
    
    $body = null;
    
    // If file template
    if( $this->template_file ){    
      $templateFile = "custom/modules/reg_qmail/templates/{$this->template_file}.tpl";
      
      if( file_exists($templateFile) ) {   
        require_once('include/Sugar_Smarty.php');
        $tpl = new Sugar_Smarty();
        
        // Change Smarty Delimiters to double brace to allow easy inclusion of css styles in templates.
        $tpl->left_delimiter = '{{';
        $tpl->right_delimiter ='}}';
        
        // Replace variables inside template
        if( !is_array($this->variables) ) $this->variables = unserialize(base64_decode($this->variables));
        if(is_array($this->variables)){
          $tpl->assign('variables', $this->variables);
        }
        
        // Parse Smarty template
        $body = trim( $tpl->fetch($templateFile) );
      }

    }else{
      /// @todo Implementar el envío de emails desde plantillas de usuario
      $GLOBALS['log']->error('Regoluna Mail Queue: Custom email templates not yet implemented');
    }
    
    return $body;
    
  } // End Get Email Body
  
  
  
  /**
   * 
   * Get an array containing IDs of pending queued emails.
   *
   */
  public static function getPendingEmailList(){
    
    $list = array();
    $b = new SugarBean();
    
    $sql = "SELECT id FROM reg_qmail WHERE deleted=0 AND in_queue=1 ORDER BY date_entered ASC";
    $result = $b->db->query($sql);
    while ($row = $b->db->fetchByAssoc($result)) {
      $list[] = $row['id'];
    }
    return $list;
    
  } // End getPendingEmailList
  
  
  
  /**
   * Gets default data 
   */
  private static function getSenderData(){
    if( !self::$senderData ){
      $admin = new Administration();
      $admin->retrieveSettings();
      self::$senderData['name'] = $admin->settings['notify_fromaddress'];
      self::$senderData['mail'] = $admin->settings['notify_fromname'];
    }
    return self::$senderData;
  }
  
  private static $senderData = null;
  
  
  
  /**
   * Get one instance of PhpMailer
   */
  private static function getPhpMailer(){
    
    if( !self::$phpMailer ){
      self::$phpMailer = new SugarPHPMailer();
    }else{
      // Clean data for another use
      self::$phpMailer->ClearAllRecipients();
      self::$phpMailer->ClearCustomHeaders();
      self::$phpMailer->Body='';
      self::$phpMailer->Subject='';
      self::$phpMailer->AltBody='';
    }
    return self::$phpMailer;
  }
  
  /**
   * Try to use only one instance of PHP Mailer
   */
  private static $phpMailer = null;
  
  
  
  /**
   * 
   * Create and queue new email record without instanting a new sugarbean.
   * This method uses less memory than instantiating a new reg_qmail object.
   *
   * @param $subject
   * @param $recipient 
   * @param $template Template file name without path and extension (.tpl)
   * @param $type Tex string to filter emails in list view.
   * @param $related_type Optional. Type of related Bean
   * @param $related_id Optional. ID of related Bean.
   * @param $related_id Array of pairs Key - Value. Value will be replaced in template using {{variables.key}} as replacement pattern
   *
   */
  public static function queueMailFromFile($subject, $recipient, $template, $type='', $related_type = null, $related_id = null, $variables=null){
    
    $db = DBManagerFactory::getInstance();
    $id = create_guid();
    
    if(!$related_type || !$related_id){
      $related_type="NULL";
      $related_id="NULL";
    }else{
      $related_type="'$related_type'";
      $related_id="'$related_id'";
    }
    
    if(is_array($variables)) $variables= "'".base64_encode( serialize( $variables ) )."'";
    else $variables= 'null';
    
    $sql =  " INSERT INTO reg_qmail (id, date_entered, date_modified, name, recipient, template_file , type, parent_type, parent_id, variables)";
    $sql .= " VALUES ('$id' ,NOW(),NOW(),'$subject','$recipient','$template', '$type',$related_type, $related_id, $variables )";

    $db->query($sql);
    /// @todo Check for query errors
  }
  
  
  
  /**
   * 
   * Remove sent emails from the Queue acording to custom settings.
   * 
   */
  public static function purgeQueue(){
    global $sugar_config, $timedate;
    
    if ( $sugar_config['reg_qmail_delete'] && $sugar_config['reg_qmail_delete'] != 'never' ) {
         
      switch ($sugar_config['reg_qmail_delete']){
        case 'immediately': $threshold = 0; break;
        case 'hour': $threshold = 1; break;
        case 'day': $threshold = 24; break;
        case 'month': $threshold = 730; break;
        case 'year': $threshold = 8760; break;
        default: $threshold = null;
      }
      
      if( is_numeric($threshold) ){
        $now = $timedate->get_gmt_db_datetime();
        
        // Remove emails mark as deleted
        $conditions[] = " deleted=1 ";
        
        // Remove cancelled emails
        $conditions[] = " (in_queue = 4 AND sent_date IS NOT NULL"
                       ." AND ((unix_timestamp('$now') - unix_timestamp( date_modified )) / 3600) > $threshold ) ";
                       
        // Remove sent emails                       
        $conditions[] =" (in_queue = 2 AND sent_date IS NOT NULL "
                      ." AND ((unix_timestamp('$now') - unix_timestamp( sent_date )) / 3600) > $threshold ) ";    
        
        $where = join(' OR ' , $conditions);
        
        $sql = " DELETE FROM reg_qmail WHERE $where";
        $db = DBManagerFactory::getInstance();
        $db->query($sql);
      }
      
    }
    
  } // End Purgue Queue
  
}
?>