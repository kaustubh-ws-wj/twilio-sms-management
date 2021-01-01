<?php
    include 'connection.php';
    $suppression_string = str_replace('+','++',$_POST['suppression_numbers']);
    $numbers_array = explode('+',$suppression_string);
    foreach($numbers_array as $key => $value){
        $suppression_number = str_replace(' ','',$value);
        if($value != ''){
            $query = "INSERT INTO suppression(suppression) VALUES ('+{$suppression_number}')";
            $ins = mysqli_query($connect, $query);
            if ($ins == 1) {
                header("Refresh:0; url=add_suppression.php?status=1");
            }
            else{
                header("Refresh:0; url=add_suppression.php?status=0");
            }
        }
    }
	
?>