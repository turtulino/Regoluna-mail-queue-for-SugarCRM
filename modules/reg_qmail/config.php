<?php

/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!is_admin($current_user)) sugar_die($app_strings['ERR_NOT_ADMIN']);

global $mod_strings;

require_once 'include/Sugar_Smarty.php';
require_once 'modules/Configurator/Configurator.php';

echo get_module_title($mod_strings['LBL_REG_QMAIL_CONFIG_QUEUE'], 'Regoluna Mail Queue', false);

$configurator = new Configurator();
$admin = new Administration();

//Add hidden options to configurable options
$configurator->allow_undefined[] = 'reg_qmail_batch_size';  
$configurator->allow_undefined[] = 'reg_qmail_delete'; 
$configurator->allow_undefined[] = 'reg_qmail_max_time'; 

if (!empty($_POST['save'])) {
  $configurator->saveConfig();
  $admin->saveConfig();
  SugarApplication::redirect('index.php?module=Administration');
}

$admin->retrieveSettings();

$sugar_smarty = new Sugar_Smarty;
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('config', $configurator->config);
$sugar_smarty->assign('error', $configurator->errors);
$sugar_smarty->assign("settings", $admin->settings);
$selected = (empty($sugar_config['save_query'])) ? "all" : $sugar_config['save_query'];
$sugar_smarty->assign("cwd", getcwd());

// Logos
$sugar_smarty->assign('regoluna_logo',SugarThemeRegistry::current()->getImageURL('logo-regoluna.png') );
$sugar_smarty->assign('sponsor1',SugarThemeRegistry::current()->getImageURL('logo-nubola.png') );

// Assign dropdowns
if( !isset($sugar_config['reg_qmail_delete']) ) $sugar_config['reg_qmail_delete'] = 'day';
$sugar_smarty->assign("reg_qmail_delete_options", get_select_options_with_id($app_list_strings['reg_qmail_delete_options'],$sugar_config['reg_qmail_delete']));

// Apply template
$sugar_smarty->display('modules/reg_qmail/config.tpl');

