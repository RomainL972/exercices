<?php
require_once 'objects.php';
session_start();
if (file_exists('private/localhost.php')) {
	require_once 'localhost.php';
}
require_once 'constant.php';
require_once 'bdd.php';

if(isset($_SESSION['user'])){
	foreach ((array)$_SESSION['user'] as $key => $value) {
		define($key, $value);
	}
	// extract((array)$_SESSION['user']);
}

function head($title)
{
	?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="style.css">
        <title><?php echo $title;?></title>
    </head>
    <body>

    </body>
</html>
	<?php
}

function redirect($to)
{
	header('Location:'.$to);
}

function error($error, $redirect=NULL)
{
	if(is_null($redirect))
		die($error);
	else{
		$_SESSION['msg'] = $error;
		redirect($redirect);
	}
}