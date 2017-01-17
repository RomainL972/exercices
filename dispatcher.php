<?php
require_once "private/main.php";

$query_args		= explode('/', substr($_SERVER['REDIRECT_URL'], 1));
$controller 	= empty($query_args[0]) ? 'default' : urldecode($query_args[0]);
$action			= empty($query_args[1]) ? 'index' : urldecode($query_args[1]);

// die(print_r(compact(explode(' ', 'controller action query_args a'))));
if (!is_readable("controllers/${controller}.php"))
	error(NOT_FOUND);

require_once "controllers/${controller}.php";

if(!function_exists($action))
	error(NOT_FOUND);
// die(print_r(compact(explode(' ', 'query_args'))));
$param = array();
if(!empty($query_args[2])) {
	for ($i = 0; $i < count($query_args) - 2; $i++) { 
		$param[$i] = $query_args[$i + 2];
	}
}
// die(print_r(compact(explode(' ', 'query_args param'))));
call_user_func_array($action, $param);
?>