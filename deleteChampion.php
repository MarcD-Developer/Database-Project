<?php
  session_start();
   
   if (!isset($_SESSION['username']))
   {
   	header('Location: userPage.php');
   }
   else
   {
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}

if (isset($_POST["champToDelete"]))
{

$ID = $_POST["champToDelete"];



$compiled = oci_parse($conn, "DELETE FROM CHAMPIONS
	                     	  WHERE ID = $ID");

oci_execute($compiled);
oci_commit($conn);
header('Location: userPage.php');
oci_close($conn);
}
else {
	oci_close($conn);
	die("Not correct input!");
}
}
?>
