<?php
function index()
{
	?>
	<h1>Connexion</h1>
	<form action="/login/get" method="post">
		<p><input type="text" name="username" placeholder="Pseudo"></p>
		<p><input type="password" name="password" placeholder="Mot de passe"></p>
		<p><input type="submit" value="Se connecter"></p>
	</form>
	<p><a href="/login/register">Creer un compte</a></p>
	<?php
}

function register()
{
	?>
	<h1>Inscription</h1>
	<form action="/login/put" method="post">
		<p><input type="email" name="email" placeholder="Adresse e-mail"></p>
		<p><input type="text" name="username" placeholder="Pseudo"></p>
		<p><input type="password" name="password1" placeholder="Mot de passe"></p>
		<p><input type="password" name="password2" placeholder="Repeter le mot de passe"></p>
		<p><input type="submit" value="Creer le compte"></p>
	</form>
	<?php
}

function get()
{
	$origin = '/login';
	extract($_POST, EXTR_SKIP);
	if(!isset($username) or !isset($password))
		error(NOT_SET, $origin);
	if (empty($username) or empty($password))
		error(VIDE, $origin);
	$username = strtolower($username);
	$password = hash_hmac(ALGO, $password, HASH);
	$user = bddGetUser($username, $password);
	if(!$user){
		error(INCORRECT, $origin);
	}
	extract($user);
	$_SESSION['user'] = new User($username, $password, $email, $type);
	redirect('/');
}

function put()
{
	$origin = '/login/register';
	extract($_POST, EXTR_SKIP);
	if(!isset($username) or !isset($email) or !isset($password1) or !isset($password2) or !isset($genre) or !isset($age) or $genre < 1 or $genre > 3 or $age < 7 or $age > 61)
		error(NOT_SET, $origin);
	if(empty($username) or empty($email) or empty($password1) or empty($password2) or empty($genre) or empty($age))
		error(VIDE, $origin);
	if($password1 != $password2)
		error(NOT_SAME, $origin);
	if(strlen($username) > 50 or strlen($email) > 50 or strlen($password1) > 100 or strlen($password2) > 100)
		error(TOO_MUCH, $origin);
	if(bddGetUser($username))
		error(USER_TAKEN, $origin);
	$password = hash_hmac(ALGO, $password1, HASH);
	$key = random_int(10000, 99999);
	bddPutUser($username, $password, $email);
	error(CHECK_MAIL, '/login');
}