

<?php
   session_start();

    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){ // if the session user and the session adm have no value
        header("Location: ../users/login.php"); // redirect the user to the home page
    }
    
    if(isset($_SESSION["user"])){ // if a session "user" is exist and have a value
        header("Location: ../index.php"); // redirect the user to the user page
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    

    $sql = "SELECT * FROM products";

    $result = mysqli_query($connect, $sql);

    $cards = "";

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $cards .= "<div>
               <div class='card myCard'>
                   <img src='{$row["image"]}' class='card-img-top myCardImg' alt='{$row["name"]}'>
                   <div class='card-body'>
                   <h5 class='card-title'>{$row["name"]}</h5>
                   <p class='card-text'>{$row["price"]} &euro;</p>
                   <a href='details.php?id={$row["dishID"]}' class='btn btn-secondary'><span class='myBtn'>Show more</span></a>
                   <a href='update_product.php?id={$row["dishID"]}' class='btn btn-warning text-danger'><span>Update</span></a>
                   <a href='delete.php?id={$row["dishID"]}' class='btn btn-danger'><span>Delete</span></a>
               </div>
           </div>
         </div>" ;
        }
    }else {
        $cards = "<p>No results found</p>";
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

        <h2 class="header">Our specialities</h2>
    
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1 g-4">
            <?= $cards ?>
        </div>
</div>


<!-- ********************************************************************************************************* -->
<!------------------------------------- Footer ------------------------------------------------------------------>
<!-- ********************************************************************************************************* -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>