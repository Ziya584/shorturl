<?php
	namespace Shorturl\Classes;
	class Shorter extends DB {
		public $id;
		public $full_url;
		public $short_url;

		// добавляет данные в таблицу url
		public function add(){
			$stmt = $this->conn->prepare('INSERT INTO url(`full_url`,`short_url`) VALUES (:full_url,:short_url)');
			$stmt->execute(['full_url'=>$this->full_url,'short_url'=>$this->short_url]);
		}

		// укорачивает юрл и добавляет в бд
		public function short($url){
			if (isset($url)){
				$code = "sh".$this->lastId().rand(1,100);
				$this->full_url = "\"".$url."\"";
				$this->short_url = $code;
				$this->add();
				return "?x=".$code;
			}else{
				echo "Enter your url!";
			}
		}

	}