

<?php

    session_start(); 

    require_once 'components/db_connect.php';
    require_once 'components/navbar.php';    

    if(isset($_SESSION["user"])) {
        $sql1 = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
        $result1 = mysqli_query($connect, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
    }

    $sql = "SELECT * FROM `products` p LEFT JOIN `suppliers` s ON p.fk_supplierID = s.supplierId";
    $result = mysqli_query($connect, $sql);

    $cards = "" ;

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
           $cards .= "<div>
               <div class='card myCard'>
                   <img src='{$row["image"]}' class='card-img-top myCardImg' alt='{$row["name"]}'>
                   <div class='card-body'>
                   <h5 class='card-title'>{$row["name"]}</h5>
                   <p class='card-text'>Price: {$row["price"]}&euro;</p>
                   <p class='card-text'>Supplier: $row[sup_name]</p>
                   <a href='product/details.php?id={$row["dishID"]}' class='btn btn-secondary'><span class='myBtn'>Show more</span></a>
               </div>
           </div>
         </div>" ;
       }
    } else  {
       $cards = "<p>No results found</p>" ;
    };

    mysqli_close($connect);
?>


<!-- Day 3 | Challenge
We will create a Restaurant Database (you can create it directly in php MyAdmin).

The database should contain one table called dishes with columns dishID, image (URL link), 
name, price and meal description. If there are any columns that you think could compliment your project feel free to expand. 

You should be able to:

Display all meals. This page will show name, image and a "Show details" link for all meals in the database.
Each meal will be linked to a details page specific for that meal (try to pass the id using GET request). 
From that id, show all the details to the specific meal included on your database. -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
 
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
        <?php if(!empty($row1)) { ?>
        <h4 class="text-secondary my-5">Welcome, <?= $row1[ "first_name"] . " " . $row1[ "last_name"] ?></h4>
        <?php } ?>
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