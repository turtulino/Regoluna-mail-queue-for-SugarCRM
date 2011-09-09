<?php
/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */
class reg_qmailController extends SugarController{
  
  function action_EditView(){
    // Replace Edit View with Detail View
    $this->view = 'detail';
  }
  
}