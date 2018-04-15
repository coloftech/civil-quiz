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
|	https://codeigniter.com/user_guide/general/routing.html
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

$route['admin'] = 'administration';
$route['admin/(:any)'] = 'administration/$1';
$route['admin/(:any)/(:any)'] = 'administration/$1/$2';

$route['pages'] = 'pages';
$route['pages/(:any)'] = 'pages/$1';
$route['pages/(:any)/(:any)'] = 'pages/$1/$2';

$route['post'] = 'post';
$route['post/(:any)'] = 'post/$1';
$route['post/(:any)/(:any)'] = 'post/$1/$2';

$route['settings'] = 'settings';
$route['settings/(:any)'] = 'settings/$1';
$route['settings/(:any)/(:any)'] = 'settings/$1/$2';

$route['user'] = 'user';
$route['user/(:any)'] = 'user/$1';
$route['user/(:any)/(:any)'] = 'user/$1/$2';


$route['quiz'] = 'quiz';
$route['quiz/(:any)'] = 'quiz/$1';
$route['quiz/(:any)/(:any)'] = 'quiz/$1/$2';


$route['exam'] = 'exam';
$route['exam/(:any)'] = 'exam/$1';
$route['exam/(:any)/(:any)'] = 'exam/$1/$2';

$route['timer'] = 'timer';
$route['timer/(:any)'] = 'timer/$1';
$route['timer/(:any)/(:any)'] = 'timer/$1/$2';


$route['(:any)'] = 'home/index';
$route['(:any)'] = 'home/$1';
$route['(:any)/(:any)'] = 'home/$1/$2';