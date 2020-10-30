<?php
$title = "Purchased Phone Numbers";
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
          $page_name = "Purchased Phone Numbers";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">Number Sccessfully Purchased</h1>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Nothing Found</h1>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h1 class="text-center color_red">Unable to purchase this number</h1>
            <?php
              }
            ?>
          </div>
            <?php
                if(isset($response->resources[0]->properties) && !empty($response->resources[0]->properties))
                {
            ?>
            <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> All Purchased Numbers</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-shopping">
                      <thead class="">
                        <th  class="text-center" >
                        </th>
                        <th >
                          #
                        </th>
                        <th >
                          Region
                        </th>
                        <th >
                          Carrier
                        </th>
                        <th >
                          Number Type
                        </th>
                        <th >
                          Number
                        </th>
                        <th >
                          Monthly Rental Rate
                        </th>
                        <th >
                          SMS Rate
                        </th>
                        <th >
                          Voice Rate
                        </th>
                        <th >
                          Purchased On
                        </th>
                      </thead>
                      <tbody>
                        <?php 
                            $count = count($response->resources);
                            for($i=0; $i<$count;$i++){
                        ?>
                          <tr>
                            <td>
                            </td>
                            <td>
                              <?= $i+1; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['region']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['carrier']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['numberType']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['number']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['monthlyRentalRate']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['smsRate']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['voiceRate']; ?>
                            </td>
                            <td>
                              <?= $response->resources[$i]->properties['addedOn']; ?>
                            </td>
                        </tr>
                        <?php
                         }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
             }
             else if(isset($response->resources[0]->properties) && empty($response->resources[0]->properties)){
         ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-center"> Nothng Found!</h4>
                        </div>
                    </div>
                </div>
            </div>
         <?php
             }
            ?>
          
          
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
    <?php
      include 'inc/footer.php';
    ?>