

<?php

    session_start();

    if((!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) || isset($_SESSION["user"])){
        header("Location: ../index.php");
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/upload.php';
    

    if(isset($_GET["id"]) && !empty($_GET["id"])){
        $id = $_GET["id"]; // to take the value from the parameter "id" in the url 
        $sql = "SELECT * FROM `products` WHERE `dishID` = $id"; // finding the product 
        $result = mysqli_query($connect, $sql);

        $row = mysqli_fetch_assoc($result);  // fetching the data 
        if($row["image"] !== "default.jpg"){ // if the picture is not product.png (the detault picture) we will delete the picture
            unlink("../assets/$row[image]");
        }

        $sql1 = "DELETE FROM `products` WHERE `dishID` = $id";
        mysqli_query($connect, $sql1);

        header("Location: product_dashboard.php");
    } 
    else {
        echo "Error";
        header("Location: ../index.php");
    }
    
    mysqli_close($connect);
    
        
?>