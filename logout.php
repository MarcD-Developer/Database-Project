<?php

	session_start();	
  if ($_SESSION['username']) { // check that session 
   // check for form submit
        session_destroy(); // destroy the session to logout
        header('Location: index.html'); // redirect back to login page
    
} 
else {
	header('Location: index.html');
}
?>