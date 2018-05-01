<?php

//require_once $_SERVER["DOCUMENT_ROOT"] . '/job-tracker/classes/'. 'DBHandler.php';
require_once 'DBHandler.php';

class Session {

  public $error = '';
  private $path = "http://104.236.202.204/job-tracker/";

  public function checkLogin(){

        if(isset($_POST['submit'])){

                if(trim($_POST['email']) === "" || trim($_POST['password']) === ""){
                    $this->error = "Fields can not be empty.";
      
                }
                else{
                  $email=trim($_POST['email']);
                  $password = trim($_POST['password']);

                  //if( $this->checkDB( $email, md5($password) ) ){ 
                  if( $this->checkDB( $email, $password ) ){ 

                    session_start();
                    $_SESSION['access'] = "accessGranted";

                    session_regenerate_id();
                    header('location:'. $path . 'admin/home.php');
                  }
                  else {
                    $this->error = "Incorrect username or password";
                  }

                }
        }//end if

  } 

  public function checkSession(){
    session_start();
    if($_SESSION['access'] !== "accessGranted"){      
      header('Location: '. '../index.php');
      //header('Location: '. $path . 'views/index.php');
    }

  }

  private function checkDB($email, $password){

       $pdo = new DBHandler();
       $sql = "SELECT * FROM admin";
       $records = $pdo->selectNotBinded($sql);
       $flag = false;

       if($records == 'error'){
              $this->error = "Database Error.";
              return false;
       }
       else {
          foreach ($records as $row){
              if($email == $row['email']){
                if( password_verify($password, $row['password']) ){
                  $flag = true;
                }
              }
          }
       }

      return $flag;
  }

}
