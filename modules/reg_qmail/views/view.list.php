<?php
require_once('include/MVC/View/views/view.list.php');

class reg_qmailViewList extends ViewList{
  
  function preDisplay(){
    parent::preDisplay();
    $this->lv->export = false;
    $this->lv->quickViewLinks = false;
  }  
  
}