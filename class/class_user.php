<?php

class User {
	private $name;
	private $ID;
	private $role;
	private $date_login;

	public function __construct($id, $login, $role) {
		$this->ID = $id;
		$this->name = $login;
		$this->role = $role;
		$this->data_login = date("Y-m-d H:i:s");
	}

	public function getName()
	{
		return $this->name;
	}

	public function getRole() {
		return $this->role;
	}

	public function getId() {
		return $this->ID;
	}

	public function getHideInput() {
		return '	<input type="hidden" name="usersID" id="usersID" value="' .$this->ID .'" />';
	}
}
?>