<?php
include_once("class_user.php");
include_once("class_db.php");

class Login {
    private static $Instance = false;
    public static function getInstance()
    {
        if( self::$Instance == false )
        {
            self::$Instance = new Login();
        }
        return self::$Instance;
    }
   private function __construct() {}

	public function login ($login, $password)
	{
			$result =	DB::getInstance()->query("select * FROM users WHERE name = '" .$login ."' and  password = '" .$password ."'");
			while($row = mysql_fetch_array($result)) {
				return new User($row['usersID'], $login, $row['role']);
			}
 /*			if ($login == "zielony" && $password == "zielony") {
					return new User($login, 2);
			} else if ($login == "admin" && $password == "admin")
			{
				return new User($login, 1);
			} else
*/
			return false;

	}

	public function logout() {
		return false;
	}
}
?>