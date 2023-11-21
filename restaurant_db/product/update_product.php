

<?php

    session_start();

    if((!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) || isset($_SESSION["user"])){
        header("Location: ../index.php");
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/upload.php';

    $options = "";
    $alert= "";

    if(isset($_GET["id"]) && !empty($_GET["id"])){
        $id = $_GET["id"]; 
        $sql = "SELECT * FROM `products` WHERE `dishID` = $id";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);

        $sql1 = "SELECT * FROM `suppliers`";
        $result1 = mysqli_query($connect, $sql1);
        while($row_sup = mysqli_fetch_assoc($result1)){
            if($row["fk_supplierId"] == $row_sup["supplierId"]){
                $options .= "<option selected value='$row_sup[supplierId]'>$row_sup[sup_name]</option>";
            }
            else{
                $options .= "<option value='$row_sup[supplierId]'>$row_sup[sup_name]</option>";
            }
        }
    }
    

    if(isset ($_POST["update"])){
        $name = $_POST["name"];
        $price = $_POST["price"];
        $description = $_POST["description"];
        $supplier = $_POST["supplier"] != 0 ? $_POST["supplier"] : "NULL";
        $image = fileUpload($_FILES["image"], "product");

        if($_FILES["image"]["error"] == 0){
            if($row["image"] != "default.jpg"){
                unlink("../assets/$row[image]"); 
            }
            $sql = "UPDATE `products` SET `name` = '$name', `price` = $price, `description` = '$description', `fk_supplierId` = $supplier, `image` = '$image[0]' WHERE `dishID` = $id";
        }else {
            $sql = "UPDATE `products` SET `name` = '$name', `price` = $price, `description` = '$description', `fk_supplierId` = $supplier WHERE `dishID` = $id";
        }
      
        if(mysqli_query($connect, $sql)){
            $alert = "<div class='alert alert-success' role='alert'>
            Product has been updated, {$image[1]}
          </div>";
          header("refresh: 3; url= product_dashboard.php");
        }else {
            $alert = "<div class='alert alert-danger' role='alert'>
            Something went wrong, {$image[1]}
          </div>";
        }
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
<!------------------------------------- Main Section ------------------------------------------------------------>
<!-- ********************************************************************************************************* -->

<div class="container mt-5">
    
    <h2 class="myForm">Update a product </h2>
       <form method="POST" enctype= "multipart/form-data">
           <div class="mb-3 mt-3">
               <label for="name" class= "form-label">Name</label>
               <input  type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $row["name"]??"" ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control"  id="price"  aria-describedby="price"  name="price" value="<?= $row["price"]??"" ?>">
            </div>
            <div class="mb-3 mt-3">
               <label for="description" class= "form-label">Description</label>
               <input  type="text" class="form-control" id="description" aria-describedby="description" name="description" value="<?= $row["description"]??"" ?>">
            </div>
            <div class="mb-3 mt-3">
                <select name="supplier" class="form-control">
                    <option value="0">Choose supplier</option>
                    <?= $options; ?>
                </select>
            </div>
           <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type = "file" class="form-control" id="image" aria-describedby="image"   name="image">
            </div>
            <button name="update" type="submit" class="btn btn-warning text-secondary">Update product</button>
            <a href="product_dashboard.php" class="btn btn-secondary text-warning">Back to home page</a>
        </form>

        <div class="alert">

            <?php echo $alert ?>

        </div>


</div>


<!-- ********************************************************************************************************* -->
<!------------------------------------- Footer ------------------------------------------------------------------>
<!-- ********************************************************************************************************* -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>