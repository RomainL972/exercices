<?php
function index($eleve=NULL)
{
	if (!isset($eleve)) {
		echo "<p>Le professeur va arriver</p>";
	}
	else {
		echo "<p>Vous parlez a l'eleve ".$eleve."</p>";
	}
	head('Tchat');
	?>
		<form action="/tchat/put/" method="post">
			<p>Message</p>
			<p><textarea name="message"></textarea></p>
			<p><input type="submit" value="Envoyer"></p>
		</form>
	<?php
	$stmt = bddGetTchat();
	while ($row = $stmt->fetch_assoc()) {
		echo '<p>[' . $row['jour'] . '/' . $row['mois'] . '/' . $row['annee'] . ' ' . $row['heure'] . 'h' . $row['minute'] . 'm' . $row['seconde'] . 's] <strong>' . htmlspecialchars($row['pseudo']) . '</strong> : ' . htmlspecialchars($row['message']) . '</p>';
	}
	$stmt->close();
}

function put()
{
	$origin = '/tchat/';
	extract($_POST, EXTR_SKIP);
	if (!defined('username') or !isset($message)) {
		error(NOT_SET, $origin);
	}
	if (empty($message)) {
		error(VIDE, $origin);
	}
	bddPutTchat(username, $message);
	redirect('/tchat/');
}