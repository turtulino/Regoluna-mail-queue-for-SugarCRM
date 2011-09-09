<?php
/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings, $app_strings, $sugar_config, $current_user;

if(ACLController::checkAccess('reg_qmail', 'view', true)) {
    $module_menu[]=Array(
      "index.php?module=reg_qmail&action=index", 
      $mod_strings["LBL_SHOW_QUEUE"],  
      'reg_qmail'
    );
}

if(ACLController::checkAccess('reg_qmail', 'edit', true)) {
    $module_menu[]=Array(
      "index.php?module=reg_qmail&action=config", 
      $mod_strings["LBL_MENU_CONFIG"],  
      'reg_qmail'
    );
}

?>