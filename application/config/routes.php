<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// rutas para los usuarios
$route['api/user/login']= 'usuarios/login';
$route['api/user/get/admin'] = 'usuarios/getUserAdmin';

// rutas para las incidencias

$route['api/incidencia/getall/user']= 'incidencias/getAlluser';
$route['api/incidencia/getdetalle'] = 'incidencias/getIncidencia';
$route['api/incidencia/updatestatus'] = 'incidencias/updatestatus';
$route['api/incidencia/update'] = 'incidencias/update';
$route['api/incidencia/asing'] = 'incidencias/asignar';
$route['api/incidencia/getadmin/user'] = 'incidencias/getAlluserAdmin';

// rutas para los comentarios

$route['api/comentario/add'] = 'comentarios/add';
