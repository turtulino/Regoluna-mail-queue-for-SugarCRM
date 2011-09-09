<?php
$module_name = 'reg_qmail';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' =>  array ( /*'EDIT', 'DUPLICATE',*/ 'DELETE'),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'recipient',
            'label' => 'LBL_RECIPIENT',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'in_queue',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_FLEX_RELATE',
          ),
        ),
        3 => 
        array (
          0 => array (
            'name' => 'error',
            'label' => 'LBL_ERROR_MSG',
          ),
          1 =>null,
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'template_file',
            'comment' => 'Full preview of the processed email template',
            'label' => 'LBL_PREVIEW',
            'type' => 'RegolunaMailPreview',
          ),
        ),
      ),
    ),
  ),
);
?>
