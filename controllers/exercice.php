<?php
function get($num)
{
	extract($_POST);
	head('Exercice '.$num);
	switch ($num) {
		case 1:
			if(!isset($answer)){
			?>
		<p>Exercice 1</p>
		<form action="/exercice/get/1" method="post">
			<p>1+1=<input type="number" name="answer"></p>
			<p><input type="submit" value="Envoyer"></p>
		</form>
			<?php }
			else {
				if ($answer == '2') {
					redirect('/exercice/get/2');
				}
				else {
					redirect('/tchat');
				}
			}
			break;
		case 2:
			if(!isset($answer)){
			?>
		<p>Exercice 2</p>
		<form action="/exercice/get/2" method="post">
			<p>2+2=<input type="number" name="answer"></p>
			<p><input type="submit" value="Envoyer"></p>
		</form>
			<?php }
			else {
				if ($answer == '4') {
					redirect('/exercice/get/3');
				}
				else {
					redirect('/tchat');
				}
			}
			break;
	}
}