<?php

  


$server = "localhost";
$user = "root"; // default user root
$pass = ""; //default password null
$db = "registerdatabase"; //database name

 //connecting to database
$con = mysqli_connect($server,$user,$pass,$db);

if(! $con ) {
  die('Could not connect: ' . mysql_error());
}
// else{

//   echo "<script>alert('connection has been established');</script>";
// }

?>