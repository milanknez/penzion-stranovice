<?php
// Protected configuration file for SMTP Mailer plugin
if (!defined('ROOT_DIR') && !defined('ADMIN_PATH')) { exit('Access Denied'); }
return array (
  'host' => 'smtp.seznam.cz',
  'port' => '587',
  'encryption' => 'tls',
  'username' => 'noreply@fidamedia.cz',
  'password' => 'As24fa8fas8dx1',
  'from_email' => 'noreply@fidamedia.cz',
  'from_name' => 'Automat, Web',
);
