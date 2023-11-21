

<?php
    session_start();

    if(!isset($_SESSION["user"]) && !isset($_SESSION[ "adm"])){ 
        header("Location: login.php"); 
     }

    if(!isset($_SESSION["adm"])){
        header("Location: ../index.php");
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    
    $sql = "SELECT * FROM `users` WHERE `id` = {$_SESSION["adm"]}"; // selecting logged-in user details from the session user

    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);

    // admin can see all users and edit users

    $sqlUsers = "SELECT * FROM `users` WHERE `status` != 'adm'";
    $resultUsers = mysqli_query($connect, $sqlUsers);

    $layout = "";

    if(mysqli_num_rows($resultUsers) > 0){
        while($userRow = mysqli_fetch_assoc($resultUsers)){
            $layout .= "<div>
            <div class='card myCard1'>
                <img src='../assets/avatar.png' class='card-img-top myCardImg1' alt='...'>
                <div class='card-body'>
                <h5 class='card-title'>{$userRow["first_name"]} {$userRow["last_name"]}</h5>
                <p class='card-text'>{$userRow["email"]}</p>
                <a href='update.php?id={$userRow["id"]}' class='btn btn-outline-warning'>Update</a>
                <a href='../index.php' class='btn btn-secondary'>Back</a>
            </div>
        </div>
        </div>" ;
        }
    }else  {
        $layout .= "No results found!" ;
    }

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

<div class="container mt-5 mb-5">

        <?php if(!empty($row)) { ?>
        <h4 class="text-secondary header">Welcome, <?= $row["first_name"] . " " . $row["last_name"] ?></h4>
        <?php } ?>

        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1 g-4">
            <?= $layout ?>
        </div>
</div>


<!-- ********************************************************************************************************* -->
<!------------------------------------- Footer ------------------------------------------------------------------>
<!-- ********************************************************************************************************* -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>