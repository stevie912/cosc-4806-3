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
          $_SESSION['auth'] = true;
          $statement = $db->prepare("INSERT INTO logins (username, password, time, result) VALUES (?, ?, ?, ?)");
          $statement->execute([$username, $password, date("Y-m-d H:i:s"), $_SESSION['auth']]);
          header("Location: /home");
          die;
        } else {
          if (!isset($_SESSION['failed_attempts'])) {
            $_SESSION['failed_attempts'] = 1;
          } else {
            $_SESSION['failed_attempts'] += 1;
          }
          $statement = $db->prepare("INSERT INTO logins (username, password, time, result) VALUES (?, ?, ?, ?)");
          $statement->execute([$username, $password, date("Y-m-d H:i:s"), $_SESSION['auth']]);
          header("Location: /login");

        }
      }
    }

   public function createUser($username, $password, $password2) {

     //check if passwords entered match
     if ($password != $password2) {
       $_SESSION['pass_mismatch'] = true;
       header("Location: /create");
     } 

     //check password is at least 8 characters long, lower and upper case, and contains a number
     $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
     if (!preg_match($pattern, $password)) {
       $_SESSION['pass_insecure'] = true;
       header("Location: /create");
     }

     $db = db_connect();
     $username = strtolower($username);
     //check if user already exists
     $statement = $db->prepare("SELECT * FROM users WHERE username = ?");  
     $statement->execute([$username]);
     if ($statement->rowCount() > 0) {
       $_SESSION['user_exists'] = true; 
       header("Location: /create");
     }

     else {  //create new user
       $password = password_hash($password, PASSWORD_DEFAULT); 
       $statement = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
       $statement->execute([$username, $password]);
       echo "User created successfully";  
       echo "<br><a href='/login'>Click here to login</a>";
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

