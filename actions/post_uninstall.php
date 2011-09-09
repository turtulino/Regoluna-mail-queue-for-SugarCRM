<?php

/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */

if(!defined('sugarEntry'))define('sugarEntry', true);


// Remove custom Jobs from Scheduler
if( file_exists('custom/modules/Schedulers/_AddJobsHere.php') ) {
  $file = file_get_contents('custom/modules/Schedulers/_AddJobsHere.php');
  $file = str_replace("require('modules/reg_qmail/SchedulerJob.php');",'',$file);
  file_put_contents ( 'custom/modules/Schedulers/_AddJobsHere.php' , $file );
}

// Delete scheduled Jobs
$b = new SugarBean();
$sql = "UPDATE schedulers SET status='Inactive', deleted=1 WHERE job='function::regolunaSendQueuedMails' ";
$b->db->query($sql);
  
