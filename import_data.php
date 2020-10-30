<?php
include 'connection.php';
include 'PHPExcel-1.8/Classes/PHPExcel.php';

$image = $_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'],"excel_upload/".$image))
{
    if (isset($_POST) && !empty($_POST)) {
        $file = $_FILES['file']['tmp_name'];
        $inputFileName = "excel_upload/".$image;
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        // $allDataInSheett = unset($allDataInSheet[1]);
        // echo "<pre>";
        // print_r($allDataInSheet);
        // print_r(count($allDataInSheet));
        // exit();
        if (count($allDataInSheet) > 1) {
            foreach ($allDataInSheet as $key => $value) {
                if ($key != 1) {
                    $query = "INSERT INTO numbers(numbers_first_name,numbers_last_name,numbers_address,numbers_phone_number,numbers_phone_type,numbers_group_id,numbers_status) VALUES ('{$value['A']}','{$value['B']}','{$value['C']}','{$value['D']}','{$value['E']}','{$_POST['group']}','1')";
                    // echo "<pre>";
                    // print_r($query);
                    // exit();
                        mysqli_query($connect, $query);
                }
            }
            header("Refresh:0; url=import_contacts.php?status=1");
        }
        else{
            header("Refresh:0; url=import_contacts.php?status=2");
        }
    }
    else{
            header("Refresh:0; url=import_contacts.php?status=0");
    }
}
else
{
 header("Refresh:0; url=import_contacts.php?status=0");
}
?>