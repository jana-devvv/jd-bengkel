<?php

$config['protocol'] = 'mail';
$config['smtp_host'] = getenv('SMTP_HOST');
$config['smtp_user'] = getenv('SMTP_USER');
$config['smtp_pass'] = getenv('SMTP_PASS');
$config['smtp_port'] = getenv('SMTP_PORT');
$config['smtp_crypto'] = 'tls';
$config['mailtype'] = 'html';