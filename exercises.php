<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Day3</title>
</head>
<body>


<!-- *************************************************************************************************************************
************************************************************************************************************************* -->

<!-- Exercise 1

Create a for loop which will print your name 50 times on the screen. Do the same with while and do while loop.  -->

<!-- <?php
       $name = "";
       for( $i= 0; $i<50; $i++)
       {
        echo $name .="<p>Barno</p>";
       }
?> -->

<!-- <?php
       $name_while = "";
       $i = 0;
       while ($i < 50)
       {
           $i++;
           echo $name_while .="<p>Barno</p>";
       }
        
?> -->

<!-- <?php
       $name_do_while = "";
       $i = 0;
       do 
       {
           $i++; 
           echo $name_do_while .="<p>Barno</p>";
       } while ($i < 50);   
?> -->

<!-- *************************************************************************************************************************
************************************************************************************************************************* -->


<!-- Exercise 2
Define a numeric array with 10 elements. Use a foreach loop to output the value of every array's element. -->

<!-- <?php

    $array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        foreach($array as $value)
       {
            echo "Value is $value <br/>";
       }

?> -->

<!-- *************************************************************************************************************************
************************************************************************************************************************* -->

<!-- Exercise 3

Create a function that will have a parameter. The argument given to that parameter should be an array. The function should 
return the highest value from the array. Try to create an array with at least 10 numbers created randomly. You may want to 
take a look at the rand() function from PHP. -->


<!-- <?php

$array_number = [];

    $i = 0;
    do {
        $i++; 
        $array_number[] = rand(0, 100); 
    } while ($i < 10);

print_r($array_number); 

function determineMax($array_number) {
    return max($array_number);
}

$max_number = determineMax($array_number);
echo "<p>$max_number</p>";

?> -->

<!-- *************************************************************************************************************************
************************************************************************************************************************* -->
<!-- 
Exercise 4

Create a PHP program that iterates the integers from 1 to 100. For multiples of three print "Back-End" instead of the 
number and for the multiples of five print "Front-End". For numbers that are multiples of both three and five print 
"Full-Stack". -->
    
<!-- <?php

for($i= 1; $i<100; $i++) {
    if($i % 3 == 0 && $i % 5 ==0){
        echo "<p>Full-Stack</p>";
    } elseif($i % 5 ==0) {
        echo "<p>Front-End</p>";
    } elseif($i % 3 ==0) {
        echo "<p>Back-End</p>";
    }
     echo "<p>$i</p>";
}

?> -->


</body>
</html>