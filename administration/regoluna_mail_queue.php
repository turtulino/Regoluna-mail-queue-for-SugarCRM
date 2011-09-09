<?php
/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */

// *******************************
// New configuration options
// REGOLUNA MAIL QUEUE
// *******************************

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Administration/UpgradeHistory.php';

$admin_option_defs = array();

// Mail Queue options
$admin_option_defs[] = array(
  'reg_qmail',
  'LBL_QMAIL_CONFIG',
  'LBL_QMAIL_CONFIG_DESC',
  './index.php?module=reg_qmail&action=config',
);

// Queued mail
$admin_option_defs[] = array(
  'reg_qmail',
  'LBL_QMAIL_QUEUE',
  'LBL_QMAIL_QUEUE_DESC',
  './index.php?module=reg_qmail&action=index',
);

/*
 * Add administration options to page
 * Supports:
 */
$US = new UpgradeHistory;

/*
 * Prepare for < 5.5
 */
$minimal = explode(".", "5.5.0");
$current = explode(".", $GLOBALS['sugar_version']);
if (!$US->is_right_version_greater($minimal, $current, true)) {
  foreach($admin_option_defs AS $key=>$val) {
    //Add $image_path
   $admin_option_defs[$key][0] = $image_path . $admin_option_defs[$key][0];
  }
}

$minimal = explode(".", "5.2.0");
$current = explode(".", $GLOBALS['sugar_version']);

// Search for mail section and add new options
foreach($admin_group_header as $index=>$config){
  if($config[0]=='LBL_EMAIL_TITLE'){
    
    if($US->is_right_version_greater($minimal, $current, true)){ // 5.2 and later
      $admin_group_header[$index][3] = array_merge($admin_group_header[$index][3],array('Regoluna'=>$admin_option_defs));
    }else{ //5.1 and earlier
      $admin_group_header[$index][3] = array_merge($admin_group_header[$index][3], $admin_option_defs );
    }
    break;
  }
}

