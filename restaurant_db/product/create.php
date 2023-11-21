

<?php

    session_start();

    if((!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) || isset($_SESSION["user"])){
        header("Location: ../index.php");
    }
    

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/upload.php';

    $alert = "";

    $options = "";

    $sql = "SELECT * FROM `suppliers`";
    $result = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $options .= "<option value='$row[supplierId]'>$row[sup_name]</option>";
    }

        if(isset ($_POST["create"])){
            $name = $_POST["name"];
            $price = $_POST[ "price"];
            $description = $_POST[ "description"];
            $supplier = $_POST["supplier"] != 0 ? $_POST["supplier"] : NULL;
            $image = fileUpload($_FILES["image"], "product");
    
            $sql = "INSERT INTO `products`(`name`, `price`, `description`, `image`, `fk_supplierId`) VALUES ('$name',$price, '$description', '$image[0]', $supplier)";
            if(mysqli_query($connect, $sql)){
                $alert = "<div class='alert alert-success' role='alert'>
                New record has been created, {$image[1]}
            </div>";
            header("refresh: 3; url= product_dashboard.php");
            }else {
                $alert = "<div class='alert alert-danger' role='alert'>
                error found, {$image[1]}
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
    
    <h2 class="myForm">Create a new product </h2>
       <form method="POST" enctype= "multipart/form-data">
           <div class="mb-3 mt-3">
               <label for="name" class= "form-label">Name</label>
               <input  type="text" class="form-control" id="name" aria-describedby="name" name="name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control"  id="price"  aria-describedby="price"  name="price">
            </div>
            <div class="mb-3 mt-3">
               <label for="description" class= "form-label">Description</label>
               <input  type="text" class="form-control" id="description" aria-describedby="description" name="description">
            </div>
            <div class="mb-3 mt-3">
                <label for="supplier" class="form-label">Supplier</label>
                <select name="supplier" class="form-control" id="supplier">
                    <option value="0">Choose supplier</option>
                    <?= $options; ?>
                </select>
            </div>
           <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type = "file" class="form-control" id="image" aria-describedby="image"   name="image">
            </div>
            <button name="create" type="submit" class="btn btn-warning text-secondary">Create product</button>
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