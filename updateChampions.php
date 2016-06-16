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

if(isset($_POST["champName"]) && isset($_POST["RPcost"]) && isset($_POST["chosenType"]))
{

$chmp = $_POST["champName"];
$RPprice = $_POST["RPcost"];
$choseT = $_POST["chosenType"];

$sql = 'INSERT INTO CHAMPIONS (CHAMPNAME, CHAMPTYPE, CHAMPCOST)
		VALUES(:name, :type, :rp)';

$compiled = oci_parse($conn, $sql);

oci_bind_by_name($compiled, ':name', $chmp);
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