
<?php 

$hostname = "localhost"; 
$username = "root"; 
$password = ""; // 
$dbname = "restaurant"; 

// create connection, you need to be aware of the order of the parameters
$connect = new mysqli($hostname, $username, $password, $dbname);

// check connection
// if(!$connect) {
//    die( "Connection failed: " . mysqli_connect_error() );
// }