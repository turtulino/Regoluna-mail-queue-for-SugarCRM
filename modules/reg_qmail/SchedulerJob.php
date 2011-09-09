<?php
/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */


/**
 * Add new Job to Scheduler
 */
$job_strings[]="regolunaSendQueuedMails";



/**
 * 
 * Sends queued emails.
 *
 */
function regolunaSendQueuedMails() {
  require_once('modules/reg_qmail/reg_qmail.php');
  global $sugar_config;
  $start = microtime(true);
  
  $GLOBALS['log']->info('----->Scheduler fired job of type regolunaSendQueuedMails()');
  
  // Prepare break conditions
  if( is_numeric($sugar_config['reg_qmail_batch_size']) && $sugar_config['reg_qmail_batch_size']>0 ){
    $countLimit = $sugar_config['reg_qmail_batch_size'];
  }else{
    $countLimit = -1;
  }
  
  if( is_numeric($sugar_config['reg_qmail_max_time']) && $sugar_config['reg_qmail_max_time']>0 ){
    $timeLimit = $sugar_config['reg_qmail_max_time'];
    // adjust max execution time (max time + 30sec)
    ini_set("max_execution_time", max($sugar_config['reg_qmail_max_time'], $timeLimit + 30));
  }else{
    $timeLimit = -1;
    // Increase the max_execution_time since this step can take awhile
    ini_set("max_execution_time", max($sugar_config['reg_qmail_max_time'], 3600));
  }
  
  // Do the Job
  $mail = new reg_qmail();
  $pending = reg_qmail::getPendingEmailList();
  $count = 0;
  
  foreach($pending as $mailId){
    $mail->retrieve($mailId);
    $mail->send();
    
    // Break conditions
    $count++;
    if( $countLimit>0 && $count>=$countLimit ) {    
      break;
    }
    if( $timeLimit>0 ){
      $time = microtime(true) - $start;
      if($time>=$timeLimit ) {
        $GLOBALS['log']->info('Regoluna Mail Queue - Batch process stopped. Time limit exceeded: ');
        break;
      }
    }
    // @todo limitar en función de la memoria consumida.
  }
  
  // Clean the registry
  reg_qmail::purgeQueue();
  
  return true;
}