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
if(isset($_POST["champToEdit"]) && isset($_POST["rpEdit"]) && isset($_POST["typeEdit"]))
{
$chmp = $_POST["champToEdit"];
$RPprice = $_POST["rpEdit"];
$choseT = $_POST["typeEdit"];

$sql = 'UPDATE CHAMPIONS
    	SET CHAMPCOST = :rp, CHAMPTYPE = :type
   		 WHERE ID = :ID';

$compiled = oci_parse($conn, $sql);

oci_bind_by_name($compiled, ':ID', $chmp);
oci_bind_by_name($compiled, ':type', $choseT);
oci_bind_by_name($compiled, ':rp', $RPprice);

oci_execute($compiled);
oci_commit($conn);
header('Location: userPage.php');
oci_close($conn);
}
else {
	die("Incorrect Input!");
}
}
?>