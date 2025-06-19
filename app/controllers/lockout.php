<?php

class Lockout extends Controller {

    public function index() {		
      $this->view('lockout/index');
      sleep(60);
      echo "times up!";
        die;
      // header('Location: /login');
      
    }
}
  ?>