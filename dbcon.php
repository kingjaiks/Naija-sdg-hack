
<?php

// database connection

class dataBase {

	private $server ;
	private $user ;
	private $password ;
	private $database ;

	protected function connect(){
		$this->server = 'localhost';
		$this->user = 'root';
		$this->password = '';
		$this->database = 'ptoject_ten';

		$conn = new mysqli($this->server, $this->user, $this->password, $this->database);
		if($conn){
			return $conn;
		} else {
			die();
			exit();
			echo 'Database not connected';
		}
	}
}

// $w = new dataBase;
// $w->connect();