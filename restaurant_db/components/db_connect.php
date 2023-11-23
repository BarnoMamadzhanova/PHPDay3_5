
<?php 

$hostname = "5.189.178.173"; 
$username = "barnokhoncodefac_example"; 
$password = "123321ExamplE!"; // 
$dbname = "barnokhoncodefac_db_example"; 

// create connection, you need to be aware of the order of the parameters
$connect = new mysqli($hostname, $username, $password, $dbname);

// check connection
// if(!$connect) {
//    die( "Connection failed: " . mysqli_connect_error() );
// }