<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Login
$route['login'] = 'user/view/login';
$route['sudo'] = 'admin/view/login';

//Register
$route['register'] = 'user/view/register';

//Dashboard
$route['dashboard/user'] = 'user/view/dashboard';
$route['dashboard/admin'] = 'admin/view/dashboard';
