


<?php

    session_start(); // creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.

    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ../index.php");
        die();
    }


    if(isset($_SESSION["adm"])){
        $id = $_GET["id"]??$_SESSION["adm"];
    } else {
        $id = $_SESSION["user"];
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/clean.php';

    $error = false;
    $fname = $lname = $email = "" ; 
    $alert= "";
    $fnameError = $lnameError = $emailError = $passError = ""; 

    $sql = "SELECT * FROM `users` WHERE `id` = $id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $backBtn = "../index.php";

    if( isset($_SESSION["adm"])){
        $backBtn = "dashboard.php";
    }
 

    if(isset ($_POST["update"])){
        $fname = cleanData($_POST["fname"]);
        $lname = cleanData($_POST[ "lname"]);
        $email = cleanData($_POST["email"]);
        
         // simple validation for the "first name"
         if(empty($fname)){
            $error = true;
            $fnameError = "Please, enter your first name";
        } elseif(strlen($fname) < 3){
            $error = true;
            $fnameError = "Name must have at least 3 characters." ;
        } elseif(!preg_match( "/^[a-zA-Z\s]+$/" , $fname)){
            $error = true;
            $fnameError = "Name must contain only letters and spaces." ;
        }
 
         // simple validation for the "last name"
         if ( empty ($lname)){
            $error = true ;
            $lnameError = "Please, enter your last name" ;
        } elseif (strlen($lname) < 3 ){
            $error = true ;
            $lnameError = "Last name must have at least 3 characters." ;
        } elseif (!preg_match( "/^[a-zA-Z\s]+$/" , $lname)){
            $error = true ;
            $lnameError = "Last name must contain only letters and spaces." ;
        }

            // simple validation for the "email" only if it's modified
        if ($email != $row['email']) { // Check if the email is different from the current one in the database
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $emailError = "Please enter a valid email address";
            } else {
                // if email is already exists in the database, error will be true
                $query = "SELECT `email` FROM `users` WHERE `email`='$email'";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) != 0) {
                    $error = true;
                    $emailError = "Provided Email is already in use";
                }
            }
        }

        // Update the user information only if there are no errors and if the email is modified or different
        if (!$error) {
            $sql = "UPDATE `users` SET `first_name`='$fname',`last_name`='$lname',`email`='$email' WHERE `id`= $id";

            $result = mysqli_query($connect, $sql);

            if ($result) {
                $alert = "<div class='alert alert-success'>
                    <p>Account has been updated!</p>
                </div>";
            } else {
                $alert = "<div class='alert alert-danger'>
                    <p>Something went wrong...</p>
                </div>";
            }
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

<div class="container my-5">
    <div class="form my-5 ">
    <h2 class="mt-5 header">Update profile</h2>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3 mt-3" >
                    <label for="fname" class="form-label">First name </label>
                    <input type="text" class="form-control" id="fname" name="fname" 
                    placeholder="First name" value="<?= $row["first_name"]??""; ?>">
                    <span class="text-danger"><?= $fnameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name </label>
                    <input type="text" class="form-control" id="lname" name="lname" 
                    placeholder="Last name" value="<?= $row["last_name"]??""; ?>">
                    <span class="text-danger"><?= $lnameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address </label>
                    <input type="email" class="form-control" id="email" name="email" 
                    placeholder="Email address" value="<?= $row["email"]??""; ?>">
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <button name="update" type="submit" class="btn btn-outline-warning" >Update</button>
                <a href="<?= $backBtn ?>" class="btn btn-secondary">Back</a>
             
            </form>
    </div>

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