<?php

/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */

if(!defined('sugarEntry'))define('sugarEntry', true);


  // Create custom Schedulers file
  if( file_exists('custom/modules/Schedulers/_AddJobsHere.php') ) {
    $file = file_get_contents('custom/modules/Schedulers/_AddJobsHere.php');
  }else{
    $file = "<?php\n";
  }
  
  // Remove end tag.
  $file = str_replace('?>','',$file);
  
  // Add new include
  $file .= "\nrequire('modules/reg_qmail/SchedulerJob.php');";
  
  // Write custom file
  if( !file_exists('custom/modules/Schedulers') ) mkdir('custom/modules/Schedulers',0777,true);
  file_put_contents ( 'custom/modules/Schedulers/_AddJobsHere.php' , $file );
  
  // Register one inactive Scheduler
  require_once('modules/Schedulers/Scheduler.php');
  $s = new Scheduler();
  $s->date_time_start="01/01/2000 12:00:00";
  $s->name = 'Send queued mails every hour (Regoluna Mail Queue)';
  $s->job = 'function::regolunaSendQueuedMails';
  $s->job_interval = '0::1::*::*::*';
  $s->status = 'Inactive';
  $s->catch_up = 0;
  $s->save();
  
  
  // Corrects _AddJobsHere main file for versions prior to 5.5
  require_once 'modules/Administration/UpgradeHistory.php';
  $US = new UpgradeHistory;
  $minimal = explode(".", "5.5.0");
  $current = explode(".", $GLOBALS['sugar_version']);
  if (!$US->is_right_version_greater($minimal, $current, true)) {
    
    $file = file_get_contents('modules/Schedulers/_AddJobsHere.php');
    // Remove end tag.
    $file = str_replace('?>','',$file);
    if( !strpos( $file , "'custom/modules/Schedulers/_AddJobsHere.php'" ) ){
      $file .= "if (file_exists('custom/modules/Schedulers/_AddJobsHere.php')) { \n";
      $file .= "  require('custom/modules/Schedulers/_AddJobsHere.php'); \n";
      $file .= "} \n";
      
      file_put_contents ( 'modules/Schedulers/_AddJobsHere.php' , $file );
    }
    
  }
