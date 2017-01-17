<?php
function index()
{
	head('Exercices');
	if(!defined('username')){
		redirect('/login');
	}
	echo "Bonjour ".username;
}