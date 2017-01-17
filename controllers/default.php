<?php
function index()
{
	head('Exercices');
	if(!defined('username')){
		redirect('/login');
	}
	redirect('/exercice/get/1');
}