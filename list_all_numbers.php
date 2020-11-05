<?php
  include 'config.php';
  $title = "Purchased Phone Numbers";
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
                if(isset($result->incoming_phone_numbers) && !empty($result->incoming_phone_numbers))
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
                        <th >#</th>
                        <th >Region</th>
                        <th >Carrier</th>
                        <th >Number Type</th>
                        <th >Number</th>
                        <th >Monthly Rental Rate</th>
                        <!-- <th >SMS Rate</th> -->
                        <!-- <th >Voice Rate</th> -->
                        <th >Purchased On</th>
                      </thead>
                      <tbody>
                        <?php 
                            //fetch stored purchased numbers
                            $i = 1; 
                            foreach ($result->incoming_phone_numbers as $key => $value) {
                            $query = "SELECT type,region,monthly_rental FROM purchased_numbers WHERE pn_sid = '{$value->sid}'";
                            $result = mysqli_query($connect, $query);
                            $row = mysqli_fetch_assoc($result);
                        ?>
                          <tr>
                            <td>
                            </td>
                            <td><?= $i; ?></td>
                            <td><?= $row['region']; ?></td>
                            <td><?= $value->origin; ?></td>
                            <td><?= $row['type']; ?></td>
                            <td><?= $value->phone_number; ?></td>
                            <td><?= $row['monthly_rental']; ?></td>
                            <!-- <td><?= $value->phone_number; ?></td> -->
                            <!-- <td><?= $value->phone_number; ?></td> -->
                            <td><?= $value->date_created; ?></td>
                        </tr>
                        <?php
                          $i++; 
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
             else if(isset($result->incoming_phone_numbers) && empty($result->incoming_phone_numbers)){
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