<?php
class User
{
	public $username;
	public $email;
	private $password;
	public $type;

	function __construct($username, $password, $email)
	{
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->type = $type;
	}
}
?>