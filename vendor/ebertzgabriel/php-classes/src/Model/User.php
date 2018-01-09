<?php



namespace Extras\Model;

error_reporting(E_ALL);
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


	public static function listAll() {

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users u LEFT JOIN tb_persons p USING(idperson) ORDER BY p.desperson");

	}

	public function save() {

		$sql = new Sql();

		$res = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":desperson" => $this->getdesperson(),
			":deslogin" => $this->getdeslogin(),
			":despassword" => $this->getdespassword(),
			":desemail" => $this->getdesemail(),
			":nrphone" => $this->getnrphone(),
			":inadmin" => $this->getinadmin()
		));

		$this->setData($res[0]);
	}

	public function get($iduser) {

		$sql = new Sql();

		$res = $sql->select("SELECT * FROM tb_users u LEFT JOIN tb_persons p USING(idperson) WHERE u.iduser = :iduser", array(':iduser' => $iduser));

		$this->setData($res[0]);
	}

	public function update() {
		
		$sql = new Sql();

		return $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":iduser" => $this->getiduser(),
			":desperson" => $this->getdesperson(),
			":deslogin" => $this->getdeslogin(),
			":despassword" => $this->getdespassword(),
			":desemail" => $this->getdesemail(),
			":nrphone" => $this->getnrphone(),
			":inadmin" => $this->getinadmin()
		));
	}

	public function delete() {

		$sql = new Sql();

		$sql->query("CALL sp_users_delete(:iduser)", array(':iduser' => $this->getiduser()));
	}
}

?>