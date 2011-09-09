<?php
/**
 * Copyright (c) 2011 Rodrigo Saiz Camarero [rodrigo at regoluna.com]
 * Licensed under the GPL3 license
 *
 * @package regoluna_mail_queue
 * @author Rodrigo Saiz Camarero <rodrigo@regoluna.com>
 */
require_once('modules/reg_qmail/reg_qmail.php');

$mail= new reg_qmail();
$mail->retrieve($_GET['record']);
echo $mail->getEmailBody();