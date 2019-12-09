<?php

include 'databaseadaptor.php';
//create new database object
$DBA = new DatabaseAdaptor();

$state = $_POST ['var'];
$username = $_POST ['username'];
$password = $_POST ['password'];
$user_id = $_POST ['id'];
$email = $_POST ['email'];
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

//Log In
function logIn($username, $password) {
    if (checkCredentials == true) {
        echo 'golden';
    }
    else {
        echo 'incorrect credentials';
    }
}
//Register
    //new user registration
function newUser($username, $password, $email) {
    //adds a new user to the accounts table in hangman database
    $table = "accounts";
    $category = "username";
    $matches = $DBA->checkUniqueness($table, $category, $username);
    if (empty($matches)) {
        $DBA->newCredentials($username, $password, $email);
        echo "new user information added successfuly";
    }
    else {
        echo "new user information NOT added successfully";
    }
}

function changeInfo() {

}

//Game

function addtoWords_Phrases($difficulty, $entry, $type,$hint_entry, $id) {
    $table = "words_phrases";
    $category = "entry";
    $matches = $DBA->checkUniqueness($table, $category, $entry);
    if (empty($matches)) {
        $DBA->addWordPhrase($difficulty, $type, $entry, $hint_entry, $id); 
        echo "new word/phrase accepted";
    }
    else {
        echo "new word/phrase NOT accepted";
    }
    $DBA->addWordPhrase();//FINISH THIS
}


?>
