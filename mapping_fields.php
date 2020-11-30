<?php 
    include 'config.php';
    include 'connection.php';

    if(isset($_POST) && !empty($_POST))
    {   
        $id = $_POST['list_id'];
        $phone = $_POST['phone_field_value'];
        $email = $_POST['email_field_value'];
        $address = $_POST['address_field_value'];
        $first_name = $_POST['first_name_field_value'];
        $last_name = $_POST['last_name_field_value'];
        $description = $_POST['description'];

        //check mapped values are right or not
        $error=array();
        if($phone == '--NONE--'){
            $error[] = 'phone';
        }if($email == '--NONE--'){
            $error[] = 'email';
        }if($first_name == '--NONE--'){
            $error[]= 'first_name';
        }if($address == '--NONE--'){
            $error[] = 'address';
        }if($last_name == '--NONE--'){
            $error[] = 'last_name';
        }
        
        if(count($error) == 5){
            $mapping_query = "UPDATE contact_list SET description='$description',phone='$phone',first_name='$first_name',last_name='$last_name',email='$email',address='$address',mapping_status='Need to map' WHERE id=$id";
            if(mysqli_query($connect,$mapping_query)){
                header("Refresh:0; url=edit_contact.php?id=".$id."&status=0");
            }else{
                header("Refresh:0; url=edit_contact.php?id=".$id."&status=2"); //some went wrong
            }
        }else{
            $mapping_query = "UPDATE contact_list SET description='$description',phone='$phone',first_name='$first_name',last_name='$last_name',email='$email',address='$address',mapping_status='Ready' WHERE id=$id";
            if(mysqli_query($connect,$mapping_query)){
                header("Refresh:0; url=edit_contact.php?id=".$id."&status=1"); //success
            }else{
                header("Refresh:0; url=edit_contact.php?id=".$id."&status=2"); //some went wrong
            }
        }
    }   
