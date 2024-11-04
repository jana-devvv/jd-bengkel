<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = '';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['auth/login'] = 'Auth/login';
$route['auth/forgot-password'] = 'Auth/forgot_password';
$route['auth/reset-password/(:any)'] = 'Auth/reset_password/$1';
$route['auth/logout'] = 'Auth/logout';

// Management
$route['management/item'] = 'management/Item/index';
$route['management/item/pdf/(:any)'] = 'management/Item/pdf/$1';
$route['management/service'] = 'management/Service/index';
$route['management/customer'] = 'management/Customer/index';
$route['management/user'] = 'management/User/index';

// Transaction
$route['transaction/sale'] = 'transaction/TransactionSale/index';
$route['transaction/sale/(:any)'] = 'transaction/TransactionSale/$1';
$route['transaction/sale/pdf/(:num)'] = 'transaction/TransactionSale/pdf/$1';
$route['transaction/sale/excel/(:num)'] = 'transaction/TransactionSale/excel/$1';
$route['transaction/sale/edit/(:num)'] = 'transaction/TransactionSale/edit/$1';
$route['transaction/sale/destroy/(:num)'] = 'transaction/TransactionSale/destroy/$1';

// Report
$route['report/sale'] = 'report/ReportSale/index';
$route['report/sale/(:any)'] = 'report/ReportSale/$1';
$route['report/sale/pdf/(:any)'] = 'report/ReportSale/pdf/$1';
$route['report/sale/excel/(:any)'] = 'report/ReportSale/excel/$1';