<?php 

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    include 'config.php';
    require_once ("connection.php");
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;

    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

    function date_compare($a, $b){
        $t1 = strtotime($a['txt_time']);
        $t2 = strtotime($b['txt_time']);
        return $t2 - $t1;
    }  

    $folder_name = $_POST['folder_name'];
    $list = [];
    $sql = "SELECT * FROM conversations where folder = '$folder_name'";
    $con_arry = mysqli_query($connect,$sql);

    while($conv = mysqli_fetch_assoc($con_arry)){ 
        $list[] = array('conv_sid'=>$conv['ConversationSid'],'from'=>$conv['MessagingBinding_Address'],'proxy_address'=>$conv['MessagingBinding_ProxyAddress'],'txt_time'=>$conv['DateCreated'],'last_msg'=>$conv['lastMsg']);
    }

    $status = 'found';
    usort($list, 'date_compare');
    echo json_encode(array('status'=> $status,'list'=> json_encode($list)));

?>