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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['api'] = 'Home/api';
$route['validate'] = 'Home/validate';
$route['register_validation'] = 'Home/register_validation';
$route['login_validation'] = 'Home/login_validation';
$route['verify_otp'] = 'Home/verify_otp';
$route['dashboard'] = 'Home/dashboard';
$route['logout'] = 'Home/logout';
$route['dashboard/(:num)'] = 'Home/dashboard/$1';
$route['generate_short_url'] = 'Home/generate_short_url';
$route['change_status'] = 'Home/change_status';
$route['u/(:num)'] = 'Home/u/$1';
$route['search'] = 'Home/search'; 
$route['change_password'] = 'Home/change_password'; 
$route['forgot_password'] = 'Home/forgot_password'; 
$route['forgot_password_verify_otp'] = 'Home/forgot_password_verify_otp';
$route['get_minimum_id'] = 'Home/get_minimum_id'; 
