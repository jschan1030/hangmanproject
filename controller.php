<?php
include 'databaseadaptor.php';
$DBA = new DatabaseAdaptor();
$username = $_POST['username'];
$password = $_POST['password'];
if (! empty($_POST)) {
    if (isset($username) && isset($password)) {
        $user = $DBA->getCredentials($username);
        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['user_id'] = $user->ID;
        }
        else{
            echo("Error user/pass does not exist");
        }
    }
}
else {
    echo("Error user/pass does not exist");
}
?>
