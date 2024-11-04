<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = [
    'class' => 'ReportHook',
    'function' => 'generate_report',
    'filename' => 'ReportHook.php',
    'filepath' => 'hooks'
];