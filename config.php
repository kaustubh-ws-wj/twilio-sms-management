<?php
require_once ("connection.php");
/* define('ACCOUNT_SID','AC18169d8641841ef4e518d859393c8054');
define('AUTH_TOKEN','bb49c894e412f63b74a8738936ff7b5a');
$username = 'AC18169d8641841ef4e518d859393c8054';
$auth_token = 'bb49c894e412f63b74a8738936ff7b5a';
define('BASIC_AUTH_KEY',base64_encode(ACCOUNT_SID.":".AUTH_TOKEN));
*/
//define('ACCOUNT_SID','AC18169d8641841ef4e518d859393c8054');
//define('AUTH_TOKEN','739f3d6bf7809b732a203a51ed3625d6');
//define('BASIC_AUTH_KEY','QUM1MjlkYjRlYTA2YWJhMGExZWQ3MzU2ZTI4ZDZiMGRiYjo3MzlmM2Q2YmY3ODA5YjczMmEyMDNhNTFlZDM2MjVkNg==');

// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
$authquery = "SELECT authid from authid where id = 1 Limit 1";
$authres = mysqli_query($connect, $authquery);
$autharray = mysqli_fetch_all($authres,MYSQLI_ASSOC);
$authid = $autharray[0]['authid'];

define('ACCOUNT_SID','AC529db4ea06aba0a1ed7356e28d6b0dbb');
define('AUTH_TOKEN',$authid);
$username = 'AC529db4ea06aba0a1ed7356e28d6b0dbb';
$auth_token = $authid;
define('BASIC_AUTH_KEY',base64_encode(ACCOUNT_SID.":".AUTH_TOKEN));
