


<?php
   session_start(); // creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.

    if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
        header("Location: ../index.php");
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/clean.php';
    $alert = "";

   $error = false;  // by default, a varialbe $error is false, means there is no error in our form

   $email = "" ; // define variables and set them to empty string
   $emailError = $passError = ""; // define variables that will hold error messages later, for now empty string


   if(isset ($_POST["login"])){
        $email = cleanData($_POST["email"]);
        $password = cleanData($_POST[ "password"]);

        // simple validation for the "date of birth"
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // if the provided text is not a format of an email, error will be true
           $error = true ;
           $emailError = "Please enter a valid email address" ;
       }

        // simple validation for the "password"
        if (empty ($password)) {
           $error = true ;
           $passError = "Password can't be empty!";
       }

        if(!$error){ // if there is no error with any input, data will be inserted to the database
            // hashing the password before inserting it to the database
           $password = hash( "sha256", $password);

           $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'";

           $result = mysqli_query($connect, $sql);

           $row = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result) === 1){ // if there is only one result after query running
                if ($row["status"] === "adm" ){ // if the status in the database of that user is admin
                   $_SESSION["adm"] = $row["id"]; // here a new session will be created with the name adm and it will save the user id
                   header( "Location: ../product/product_dashboard.php" ); // admins will be redirected to dashboard.php page
               } else  {
                   $_SESSION["user"] = $row["id"]; // here a new session will be created with the name user and it will save the user id
                   header( "Location: ../index.php" ); // users will be redirected to index.php page
               }
           } else  {
                $alert =  "<div class='alert alert-danger'>
                       <p>Something went wrong, please try again later ...</p>
                     </div>" ;
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
    <div class="form my-5 register">
            <h2 class="my-4">Login page</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>" >
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</ label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="text-danger"><?= $passError ?></span>
                </div>
                <button name="login" type="submit" class="btn btn-primary" >Login</button>
             
                <span>you don't have an account? <a href="register.php">register here </a></span>
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