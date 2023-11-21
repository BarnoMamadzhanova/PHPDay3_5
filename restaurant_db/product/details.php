<?php

    session_start();

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/upload.php';
    

    if(isset($_GET["id"]) && !empty($_GET["id"])){
        $sql = "SELECT * FROM `products` WHERE `dishID` = $_GET[id]"  ;
        $result = mysqli_query($connect, $sql);

        $cards = "";
        $backBtn = "../index.php";
        if( isset($_SESSION["adm"])){
            $backBtn = "product_dashboard.php";
        }

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $cards .="<div>
            <div class='card mb-3 myCardDet'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                    <img src='{$row["image"]}' class='img-fluid rounded-start' alt='{$row["name"]}'>
                    </div>
                    <div class='col-md-8 bg-dark-subtle opacity-100'>
                    <div class='card-body'>
                        <h3 class='card-title my-4 detTitle'>{$row["name"]}</h3>
                        <h6 class='card-text detText'>{$row["description"]}.</h6>
                        <h6 class='card-text detText'>{$row["price"]} &euro;</h6>
                        <a href='$backBtn' class='btn btn-secondary mt-3'><span class='myBtnDet'>Back</span></a>
                    </div>
                    </div>
                </div>
            </div>
        </div>";
        }
         else  {
        $cards = "<p>No results found</p>" ;
        }
    };

    mysqli_close($connect);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
 
    <title>Restaurant</title>
</head>
<body>

<!-- ********************************************************************************************************* -->
<!------------------------------------- Navbar ------------------------------------------------------------------>
<!-- ********************************************************************************************************* -->

<div class="nav">

   <?php echo $navbar ?>

</div>
    
<!-- ********************************************************************************************************* -->
<!------------------------------------- Cards ------------------------------------------------------------------>
<!-- ********************************************************************************************************* -->

<div class="container mt-5">
       
        <h1 class="header">Our specialities</h1>
        <div class="myCards1">
            <?php echo $cards ?>
        </div>
</div>

<!-- ********************************************************************************************************* -->
<!------------------------------------- Footer ------------------------------------------------------------------>
<!-- ********************************************************************************************************* -->
  




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>