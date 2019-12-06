<?php

include 'databaseadaptor.php';
//create new database object
$DBA = new DatabaseAdaptor();

$state = $_POST ['var'];
$username = $_POST ['username'];
$password = $_POST ['password'];
$email = $_POST ['emal'];
//Accounts
    //logging in
function checkCredentials($username, $password){
    //will return true or false if the given credentials are in the accounts table in hangman database
    $matches = $DBA->getCredentials($username, $password);
    if (empty($matches)) {
        return false;
    }
    else {
        return true;
    }
}
    //new user registration
function newUser($username, $password) {
    //adds a new user to the accounts table in hangman database
    $DBA->newCredentials($username, $password, $email);
}
//Log In

//Register

//Game
?>
