<?php
$module_name = 'reg_qmail';
$listViewDefs [$module_name] = 
array (
  'TYPE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '15%',
    'default' => true,
  ),
  'RECIPIENT' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_RECIPIENT',
    'width' => '12%',
    'default' => true,
  ),
  'PARENT_NAME'=>array(
    'label' => 'LBL_FLEX_RELATE',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'related_fields' => array('parent_id', 'parent_type'), 
    'ACLTag' => 'PARENT',
    'link' => true, 
    'width' => '10%',
    'default' => true,
  ),
  'IN_QUEUE' => 
  array (
    //'type' => 'bool',
    'label' => 'LBL_IN_QUEUE',
    'width' => '5%',
    'default' => true,
  ),
  'SENT_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_SENT_DATE',
    'width' => '8%',
    'default' => true,
  ),
  'ERROR_MESSAGE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ERROR_MESSAGE',
    'width' => '12%',
    'default' => true,
  ),
);
?>
