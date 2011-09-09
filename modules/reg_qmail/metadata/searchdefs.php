<?php
$module_name = 'reg_qmail';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'type' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'recipient' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RECIPIENT',
        'width' => '10%',
        'default' => true,
        'name' => 'recipient',
      ),
      'in_queue' => 
      array (
        'name' => 'in_queue',
        'label' => 'LBL_IN_QUEUE',
        'width' => '10%',
        'default' => true,
        'displayParams' => array(
            'size' => '4',
         ),
      ),
    ),
    'advanced_search' => 
    array (
      'type' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'recipient' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RECIPIENT',
        'width' => '10%',
        'default' => true,
        'name' => 'recipient',
      ),
      'in_queue' => 
      array (
        'name' => 'in_queue',
        'label' => 'LBL_IN_QUEUE',
        'width' => '10%',
        'default' => true,
        'displayParams' => array(
            'size' => '4',
         ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
