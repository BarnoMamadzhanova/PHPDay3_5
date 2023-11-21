

<?php

    session_start(); // creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.

    if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
        header("Location: ../index.php");
    }

    require_once '../components/db_connect.php';
    require_once 'navbar.php';
    require_once '../components/clean.php';

    $error = false;
    $alert = "";

    $fname = $lname = $email = "" ; 
    $fnameError = $lnameError = $emailError = $passError = ""; 

    if(isset ($_POST["register"])){
        $fname = cleanData($_POST["fname"]);
        $lname = cleanData($_POST[ "lname"]);
        $email = cleanData($_POST["email"]);
        $password = cleanData($_POST[ "password"]);
        
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
 
         // simple validation for the "email"
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ // if the provided text is not a format of an email, error will be true
            $error = true ;
            $emailError = "Please enter a valid email address" ;
        } else  {
             // if email is already exists in the database, error will be true
            $query = "SELECT `email` FROM `users` WHERE `email`='$email'" ;
            $result = mysqli_query($connect, $query);
             if (mysqli_num_rows($result) != 0 ){
                $error = true ;
                $emailError = "Provided Email is already in use" ;
            }
        }
 
         // simple validation for the "password"
         if  ( empty ($password)) {
            $error = true ;
            $passError = "Password can't be empty!" ;
        } elseif  (strlen($password) < 8 ) {
            $error = true ;
            $passError = "Password must have at least 6 characters." ;
        }
 
         if (!$error){ // if there is no error with any input, data will be inserted to the database
             // hashing the password before inserting it to the database
            $password = hash( "sha256" , $password);
 
            $sql = "INSERT INTO `users`(`first_name`, `last_name`, `password`, `email`) VALUES ('$fname','$lname', '$password', '$email')" ;
            
            $result = mysqli_query($connect, $sql);
 
             if ($result){
                $alert = "<div class='alert alert-success'>
                <p>New account has been created!</p>
            </div>" ;
            } else  {
                $alert = "<div class='alert alert-danger'>
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
    <h2 class="mt-5">Register</h2>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3 mt-3" >
                    <label for="fname" class="form-label">First name </label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?= $fname ?>" >
                    <span class="text-danger"><?= $fnameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name </label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?= $lname ?>" >
                    <span class="text-danger"><?= $lnameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>" >
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</ label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span c lass="text-danger"><?= $passError ?></span>
                </div>
                <button name="register" type="submit" class="btn btn-primary" >Create account </button>
             
                <span>you have an account already? <a href="login.php">sign in here </a></span>
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