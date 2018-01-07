<?php

namespace Extras\Model;

use \Extras\DB\Sql;
use \Extras\Model;

class User extends Model{

	const SESSION = "User";

	public static function login($login, $password) {

		$sql = new Sql();

		$res = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));

		if (count($res) ===0) {

			throw new \Exception("Usuário inexistente ou inválido");
			
		}

		$data = $res[0];

		if (password_verify($password, $data['despassword']) === true) {

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {

			throw new \Exception("Usuário inexistente ou inválido");
			
		}
	}


	public static function verifyLogin($inadmin = true) {

		if (!isset($_SESSION[User::SESSION]) || 
			!$_SESSION[User::SESSION] || 
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 ||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin) 
		{

			header("Location: /admin/login");
			exit();
		}
	}


	public static function logout() {

		$_SESSION[User::SESSION] = null;

	}
}

?>