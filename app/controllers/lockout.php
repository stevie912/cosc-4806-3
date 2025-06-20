<?php

class Lockout extends Controller {

    public function index() {		
      $this->view('lockout/index');
      // sleep(6);
      // echo "times up!";
      // header('Location: ../login');
      // exit; 
      
    }
}
  ?>