

<?php


    function fileUpload($image, $source = "users"){

        if($image["error"] == 4){ // checking if a file has been selected, it will return 0 if you choose a file, and 4 if you didn't
            // if(isset($_SESSION["user"])){
            //     $imageName = "assets/avatar.png";
            //     if($source === "product"){
            //         $imageName = "assets/default.jpg";
            //     }
            // }
            $imageName = "../assets/avatar.png"; // the file name will be product.png (default picture for a product)
            if($source === "product"){
                $imageName = "../assets/default.jpg";
            }
            $message = "No picture has been chosen, but you can upload an image later :)";
        }else{
            $checkIfImage = getimagesize($image["tmp_name"]); // checking if you selected an image, return false if you didn't select an image
            $message = $checkIfImage ? "Ok" : "Not an image";
        }

        if($message == "Ok"){
            $ext = strtolower(pathinfo($image["name"],PATHINFO_EXTENSION)); // taking the extension data from the image
            $imageName = uniqid(""). "." . $ext; // changing the name of the picture to random string and numbers
            if($source == "product"){
                $destination = "../assets/{$pictureName}"; // where the file will be saved
            }
            // $destination = "../assets/{$imageName}"; 
            move_uploaded_file($image["tmp_name"], $destination); // moving the file to the pictures folder
        }

        return [$imageName, $message]; // returning the name of the picture and the message
    }

?>