<?php
include 'config.php';
$title = 'Call Route Group';
include 'inc/head.php';
include 'connection.php';
require 'vendor/autoload.php';


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/IncomingPhoneNumbers.json",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Basic ".BASIC_AUTH_KEY
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $result = json_decode($response);
    
?>

  <body class=" sidebar-mini ">
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrapper ">
      <?php
        include 'inc/header.php';
      ?>
      <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <?php
          $page_name = "Send SMS";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h6 class="text-center color_green">SMS Sent Sccessfully</h6>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h6 class="text-center color_red">No recoed found in the file</h6>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h6 class="text-center color_red">Something went wrong, Please Try Again</h6>
            <?php
              }
            ?>

          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header ">
                  <h4 class="card-title">Create Call Route Group</h4>
                </div>
                <form action="<?=(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type') ? 'update_call_route.php' : 'save_call_route.php'?>" method="post">
                  <div class="card-body" style="height: 86vh;">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="card-title">Enter Call Route Name</label>
                        <div class="form-group form-file-upload form-file-simple">
                          <input class="form-control" name="route_name" type="text" placeholder="Call Route Name" value="<?=(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type') ? $_GET['name'] : ''?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label class="card-title">Select Your Numbers</label>
                        <div class="form-group form-file-upload form-file-simple" >
                          <div class="subject-info-box-1">
                            <select multiple="multiple" id='lstBox1' name="numbers[]" class="form-control" required="">
                              <?php 
                                $call_route_numbers_query = "SELECT * FROM call_routes WHERE `call_routes_name` = '{$_GET['name']}'";
                                $call_route_numbers_build = mysqli_query($connect, $call_route_numbers_query);
                                while($call_route_numbers_row = mysqli_fetch_assoc($call_route_numbers_build)){
                              ?>
                                <option value="<?php echo $call_route_numbers_row['call_routes_number']; ?>" selected><?php echo $call_route_numbers_row['call_routes_number']; ?></option>
                              <?php 
                                }
                              ?>
                            </select>
                          </div>
                          <div class="subject-info-arrows text-center">
                            <input type='button' id='btnAllRight' value='>>' class="btn btn-default" /><br />
                            <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
                            <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
                            <input type='button' id='btnAllLeft' value='<<' class="btn btn-default" />
                          </div>
                          <div class="subject-info-box-2">
                            <select multiple="multiple" id='lstBox2' class="form-control">
                              <?php foreach ($result->incoming_phone_numbers as $key => $value) { 
                                $call_route_numbers_query = "SELECT * FROM call_routes WHERE `call_routes_number` =".str_replace("+","",$value->phone_number);
                                $call_route_numbers_build = mysqli_query($connect, $call_route_numbers_query);
                                $numbers_count = mysqli_num_rows($call_route_numbers_build);
                                  if($numbers_count == 0){
                              ?>
                                <option value="<?php echo $value->phone_number; ?>"><?php echo $value->phone_number; ?></option>
                              <?php 
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="row">
                      <div class="col-md-6">
                        <label class="card-title">Select Your Numbers</label>
                        <div class="form-group form-file-upload form-file-simple" >
                          <select class="form-control getcontact" name="numberss[]" required="" multiple style="height:360px;">
                              <?php 
                                  //$count = count($response->resources);
                                  foreach ($result->incoming_phone_numbers as $key => $value) {
                                  
                                  if(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'edit')
                                  {
                                      // $query = "SELECT * FROM call_routes WHERE `call_routes_name` = '{$_GET['name']}' AND `call_routes_number` =".str_replace("+","",$value->phone_number);
                                      $query = "SELECT * FROM call_routes WHERE `call_routes_name` = '{$_GET['name']}' AND `call_routes_number` =".str_replace("+","",$value->phone_number);
                                      $result = mysqli_query($connect, $query);
                                      $numbers_count = mysqli_num_rows($result);

                                      if($numbers_count == 0){
                                        ?>
                                              <option value="<?= $value->phone_number; ?>"><?= $value->phone_number; ?></option>
                                        <?php
                                      }
                                  }
                              ?>
                              
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div> -->
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Default Folder</label><br>
                            <select id="folder" name="default_folder" class="form-control" required>
                                <option value="">Select Default Folder</option>
                                <?php 
                                    $sql_folder = "SELECT * FROM folder";
                                    $result_folder = mysqli_query($connect, $sql_folder);
                                    while($row_folder = mysqli_fetch_assoc($result_folder)){
                                    $selected = '';
                                    if(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'edit')
                                    {
                                        $folder_id_query = "SELECT * FROM call_routes WHERE `call_routes_name` = '{$_GET['name']}'";
                                        $folder_id_exe = mysqli_query($connect,$folder_id_query);
                                        $folder_id_result = mysqli_fetch_all($folder_id_exe,MYSQLI_ASSOC);
                                        $folder_id = $folder_id_result[0]['folder_id'];
                                        if($row_folder['folder_id'] == $folder_id){
                                          $selected = "selected";
                                        }
                                    }

                                ?>
                                <option value="<?= $row_folder['folder_id'] ?>" <?php echo $selected; ?>><?= $row_folder['folder_name'] ?></option>
                                <?php }?>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="submit" class="btn btn-info" value="<?=(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type') ? 'Update' : 'Save'?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end card -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
<?php
  include 'inc/footer.php';
?>