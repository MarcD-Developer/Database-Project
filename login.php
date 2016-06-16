<?php 
session_start(); // must go right at the top of the page - to track login

$logins = array('dilinilams' => 'V00610105'); // your username and password

//if(isset($_POST['submit'])) { // check for form submit
    $user = $_POST["username"]; 
    $pass = $_POST["password"]; 
    if (isset($logins[$user]) && ($logins[$user] == $pass)) { // check login and compare credentials
        $_SESSION['username'] = $user; // set the session
        header('Location: userPage.php'); // redirect to protected page
        }

    else 
    {
        die("Incorrect User and Pass");
    } 
 //   }

  /*  if ($_SESSION['username']) { // check that session 
    if (isset($_POST['Logout'])) { // check for form submit
        session_destroy(); // destroy the session to logout
        header('Location: index.php'); // redirect back to login page
    }
} */


?>