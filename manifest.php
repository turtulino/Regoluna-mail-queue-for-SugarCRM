<?php
/*********************************************************************************
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 ********************************************************************************/

$manifest = array(
  'acceptable_sugar_versions' => array(

  ),
  'acceptable_sugar_flavors'  => array(
    'CE', 'PRO', 'ENT'
  ),
  'readme'                    => '',
  'key'                       => 'reg',
  'author'                    => 'Rodrigo Saiz Camarero (rodrigo@regoluna.com)',
  'description'               => 'Allows other modules to create and queue mails. Periodically sends them using the scheduler',
  'icon'                      => '',
  'is_uninstallable'          => true,
  'name'                      => 'Regoluna Mail Queue',
  'published_date'            => '2011-06-09',
  'type'                      => 'module',
  'version'                   => '0.1',
  'remove_tables'             => 'prompt',
);

$installdefs = array(
  'id'            => 'regoluna_mail_queue',
  'beans'         => array(
    0 => array(
      'module' => 'reg_qmail',
      'class'  => 'reg_qmail',
      'path'   => 'modules/reg_qmail/reg_qmail.php',
      'tab'    => false,
    ),
  ),
  
  'layoutdefs'    => array(
  ),
  
  'relationships' => array(
  ),
  
  'image_dir'     => '<basepath>/icons',
  
  'copy'          => array(
    // New Beans
    array( 'from' => '<basepath>/modules/reg_qmail', 'to'   => 'modules/reg_qmail' ),
    
    // New field for email preview on DetailView
    array( 'from' => '<basepath>/include/SugarFields/Fields/RegolunaMailPreview', 
           'to'   => 'include/SugarFields/Fields/RegolunaMailPreview' ),
  ),
  
  'language'      => array(
    array( 'from' => '<basepath>/language/application_en_us.lang.php', 'to_module' => 'application', 'language'  => 'en_us' ),
    array( 'from' => '<basepath>/language/application_es_es.lang.php', 'to_module' => 'application', 'language'  => 'es_es' ),
    
    // Config section
    array ( 'from' => '<basepath>/language/administration_es_es.lang.php', 'to_module' => 'Administration', 'language' => 'es_es' ),
    array ( 'from' => '<basepath>/language/administration_en_us.lang.php', 'to_module' => 'Administration', 'language' => 'en_us' ),
    
    // Schedulers
    array ( 'from' => '<basepath>/language/schedulers_es_es.lang.php', 'to_module' => 'Schedulers', 'language' => 'es_es' ),
    array ( 'from' => '<basepath>/language/schedulers_en_us.lang.php', 'to_module' => 'Schedulers', 'language' => 'en_us' ),    
  ),
  
  // Administration section
  'administration' => array(
    array( 'from' => '<basepath>/administration/regoluna_mail_queue.php' ),
  ),
  
  // Install and Uninstall scripts
  'post_execute'=>array( '<basepath>/actions/post_execute.php' ),
  'post_uninstall'=>array('<basepath>/actions/post_uninstall.php' ),
  
);
