<?php
	namespace Shorturl\Classes;
	class DB{
		protected static $_inst = null;
		protected $pdo = null;
		private $_host = HOST;
		private $_dbname = DBNAME;
		private $_user = USER;
		private $_password = PASSWORD;
		private $_charset = CHARSET;
		private $_error;

		// конструктор для подключения к БД
		public function __construct()
		{
			$dsn = "mysql:host=".$this->_host.";dbname=".$this->_dbname.";charset=".$this->_charset;
			try{
				$this->conn = new \PDO($dsn,$this->_user, $this->_password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
			}catch (\PDOException $e){
				$this->conn = null;
				$this->_error = $e->getMessage();
			}
		}

		//Отправляет запрос
		public function sendQueryWithOutParams($sql){
			try {
				$conn = $this->conn;
				$query = $conn->prepare($sql);
				$query->execute();
				$res = $query->fetchAll(\PDO::FETCH_ASSOC);
				return $res;
			}catch (\PDOException $e){
				return FALSE;
			}
		}

		//создаёт таблицу в бд
		function createTable($tablename,$columns){
			$sql ="CREATE TABLE `shorturl`.`$tablename` ( $columns ) ENGINE = InnoDB";
			$conn = $this->conn;
			$check = $this->sendQueryWithOutParams("CHECK TABLE $tablename FAST QUICK");
			if($check[0]['Msg_type']=='Error'){
				$query = $conn->prepare($sql);
				$query->execute();
			}else{
				echo $check[0]['Msg_type']."   ";
				echo " $tablename Already Exist";
			};
		}

		// возвращает url по коду
		public function findByCode($code){
			if(!isset($code)){
				return;
			}
			$conn = $this->conn;
			$query = $conn->prepare("Select full_url From url where short_url=:short_url");
			$query->bindParam(':short_url', $code, \PDO::PARAM_STR);
			$query->execute();
			$res = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $res[0]['full_url'];
		}

		//возвращает последний айди из таблицы url
		function lastId(){
			$conn= $this->conn;
			$query = $conn->prepare("SELECT id FROM url ORDER BY id DESC LIMIT 1");
			$query->execute();
			$res = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $res[0]['id'];
		}


		// получаем ошибку подключения
		public function getError(){
			return $this->_error;
		}
	}