<?php
function index()
{
	head('CubeCity, Bienvenue dans la ville des Cubes !');
	if(!defined('username')){
		redirect('/login');
	}
	echo "Bonjour ".username;
}