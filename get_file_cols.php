<?php 
include 'PHPExcel-1.8/Classes/PHPExcel.php';
if(isset($_POST['filepath'])){
    if($_POST['filepath'] != ''){
        $inputFileType = PHPExcel_IOFactory::identify($_POST['filepath']);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($_POST['filepath']);
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        echo json_encode(array('buttons'=>$allDataInSheet[1],'status'=>true)); 
    }else{
        echo json_encode(array('messsage'=>'File path value Null','status'=>false));
    }
}else{
    echo json_encode(array('messsage'=>'Request value Null','status'=>false));
}