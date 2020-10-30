<?php
include 'inc/head.php';
include 'connection.php';

require 'vendor/autoload.php';
use Plivo\RestClient;
use Plivo\Exceptions\PlivoRestException;
  
$client = new RestClient("MAOGFLMJLKNGM0ODZMYJ", "MGQ2ZTg5ZWM5YzU5MDY3MjNiZjY0Y2EwMGFiY2M2");

try {
    $response = $client->numbers->list(
        [
        	'limit' => 100
        ]
    );
}
catch (PlivoRestException $ex) {
    print_r($ex);
}
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
                <h1 class="text-center color_green">SMS Sent Sccessfully</h1>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h1 class="text-center color_red">No recoed found in the file</h1>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Something went wrong, Please Try Again</h1>
            <?php
              }
            ?>

          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="card">
              <form action="<?=(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type') ? 'update_call_route.php' : 'save_call_route.php'?>" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Enter Call Route Name</h4>
                      <div class="form-group form-file-upload form-file-simple">
                        <input class="form-control" name="route_name" type="text" placeholder="Call Route Name" value="<?=(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type') ? $_GET['name'] : ''?>" required>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <h4 class="card-title">Select Your Numbers</h4>
                      <div class="form-group form-file-upload form-file-simple">
                        <select class="form-control getcontact" name="numbers[]" required="" multiple>
                            <?php 
                                $count = count($response->resources);
                                for($i=0; $i<$count;$i++){
                                if(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type')
                                {
                                    $query = "SELECT * FROM call_routes WHERE `call_routes_name` = '{$_GET['name']}' AND `call_routes_number` = '{$response->resources[$i]->properties['number']}'";
                                    $result = mysqli_query($connect, $query);
                                    $numbers_count = mysqli_num_rows($result);
                                }
                            ?>
                            <option <?=(isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['type']) && !empty($_GET['type']) && $_GET['edit'] = 'type' && $numbers_count == 1) ? 'selected' : ''?> value="<?= $response->resources[$i]->properties['number']; ?>"><?= $response->resources[$i]->properties['number']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
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