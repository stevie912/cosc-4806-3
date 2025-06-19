<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {
        
    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function authenticate($username, $password)   {
        /*
         * if username and password good then
         * $this->auth = true;
         */
		$username = strtolower($username);

      $db = db_connect();
      //check user is in database
      $statement = $db->prepare("SELECT * FROM users WHERE username = ?");
      $statement->execute([$username]);

      if ($statement->rowCount() == 0) {  //user not found
        $_SESSION['no_user'] = true;
        header("Location: /login");

      }

      else {
        //get hashed password from database
        $statement = $db->prepare("SELECT password FROM users WHERE username = :username");
        $statement->bindParam(':username', $username);
        $statement->execute();
        $statement->bindColumn('password', $valid_password);
        $$valid_password = $statement->fetch(PDO::FETCH_BOUND);

        //check if password is correct
        if (password_verify($password, $valid_password)) {
          $_SESSION['authenticated'] = true;
          header("Location: /home");
        } else {
          if (!isset($_SESSION['failed_attempts'])) {
            $_SESSION['failed_attempts'] = 1;
          } else {
            $_SESSION['failed_attempts'] += 1;
          }

          header("Location: /login");

        }
      }
    }
}
      
		// $db = db_connect();
  //       $statement = $db->prepare("select * from users WHERE username = :name;");
  //       $statement->bindValue(':name', $username);
  //       $statement->execute();
  //       $rows = $statement->fetch(PDO::FETCH_ASSOC);
		
		// if (password_verify($password, $rows['password'])) {
		// 	$_SESSION['auth'] = 1;
		// 	$_SESSION['username'] = ucwords($username);
		// 	unset($_SESSION['failedAuth']);
		// 	header('Location: /home');
		// 	die;
		// } else {
		// 	if(isset($_SESSION['failedAuth'])) {
		// 		$_SESSION['failedAuth'] ++; //increment
		// 	} else {
		// 		$_SESSION['failedAuth'] = 1;
		// 	}
		// 	header('Location: /login');
		// 	die;
		// }

