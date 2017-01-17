<?php
function bddConnect()
{
	$url = parse_url(getenv('CLEARDB_DATABASE_URL'));
	$mysqli = new mysqli($url["host"], $url["user"], $url["pass"], substr($url["path"], 1));
	if ($mysqli->connect_errno) {
		error("Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
	}
	return $mysqli;
}

function bddGetUser($username, $password=NULL)
{
	$mysqli = bddConnect();
	if (is_null($password)) {
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?") or error("Echec de la preparation : (".$mysqli->errno.") ".$mysqli->error);
		$stmt->bind_param('ss', $username, $username) or error("Echec lors de l'ajout des parametres : (" . $mysqli->errno . ") " . $mysqli->error);
	}
	else {
		$stmt = $mysqli->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND password=?") or error("Echec de la preparation : (".$mysqli->errno.") ".$mysqli->error);
		$stmt->bind_param('sss', $username, $username, $password) or error("Echec lors de l'ajout des parametres : (" . $mysqli->errno . ") " . $mysqli->error);
	}
	$stmt->execute();
	$res = $stmt->get_result();
	if (!$res->num_rows) {
		return 0;
	}
	$row = $res->fetch_assoc();
	// die(print_r(compact(explode(' ', 'username password mysqli stmt row res'))));
	$mysqli->close();
	$stmt->close();
	$res->close();

	return $row;
}

function bddPutUser($username, $password, $email)
{
	$mysqli = bddConnect();
	$stmt = $mysqli->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)") or error("Echec de la preparation : (".$mysqli->errno.") ".$mysqli->error);
	$stmt->bind_param('sss', $username, $password, $email) or error("Echec lors de l'ajout des parametres : (" . $mysqli->errno . ") " . $mysqli->error);
	$stmt->execute();
	$mysqli->close();
	$stmt->close();
}

function bddGetTchat()
{
	$mysqli = bddConnect();
	$stmt = $mysqli->query('SELECT pseudo, message, DAY(`date`) AS jour, MONTH(`date`) AS mois, YEAR(`date`) AS annee, HOUR(`date`) AS heure, MINUTE(`date`) AS minute, SECOND(`date`) AS seconde FROM tchat ORDER BY `date` DESC LIMIT 10') or error($mysqli->error);
	$mysqli->close();
	return $stmt;
}

function bddPutTchat($pseudo, $message)
{
	$mysqli = bddConnect();
	$stmt = $mysqli->prepare('INSERT INTO tchat(pseudo, message, `date`) VALUES(?, ?, NOW())') or error("Echec : ".$mysqli->error);
	$stmt->bind_param('ss', $pseudo, $message);
	$stmt->execute();
	$mysqli->close();
	$stmt->close();
}