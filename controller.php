<?php
session_start();

include 'databaseadaptor.php';
//create new database object
$DB = new DatabaseAdaptor();
$username = $_POST['username'];
$email = $_POST['email'];
$password =$_POST['password'];
$password2 =$_POST['password2'];
$errors = array();
if (isset($_POST['register'])){
    $username = mysqli_real_escape_string($DB, $_POST['username']);
    $email = mysqli_real_escape_string($DB, $_POST['email']);
    $password = mysqli_real_escape_string($DB, $_POST['password']);
    $password2 = mysqli_real_escape_string($DB, $_POST['password2']);
    
    if (empty($username)) { 
        array_push($errors, "Username is required"); 
    }
    if (empty($email)) { 
        array_push($errors, "Email is required"); 
    }
    if (empty($password)) { 
        array_push($errors, "Password is required"); 
    }
    if ($password != $password2) {
        array_push($errors, "The two passwords do not match");
    }
    $user = $DB->getCredentials($username);
    if ($user){
        if ($user['username'] === $username){
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email){
            array_push($errors, "email already exists");
        }
    }
}
if (count($errors)== 0){
    $pass = md5($password); //encrypts password
    
    $DB->newUser($username,$email, $password);
    
    
   
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "Let's Play!";
  
    
}
elseif (isset($_POST['login'])){
    
    $user = $DB->getCredentials($username, $password);
    if ($user === false){
        echo "Incorrect Username and/or Password";
    }
    else{
    $validPass = password_verify($pass, $user['password']);
    if ($validPass){
        $_SESSION['id'] = $user['id'];
        $_SESSION['logged_in'] = time();
        header('location: home.php');
        exit;
    }
    else{
        echo "Incorrect Username and/or Password!";
    }
    
}

}



?>
