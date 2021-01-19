<?php
  include 'config.php';
  $title = "Purchased Phone Numbers";
  include 'inc/head.php';
  include 'connection.php';
  require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);
    

  if(isset($_POST) && isset($_POST['pn_sid']) && $_POST['pn_sid'] != ''){
    $pn_sid = $_POST['pn_sid'];
    $phone_number = $_POST['phone_number'];
    try{
      $twilio->incomingPhoneNumbers($pn_sid)->delete();

      // Change status from `purchased_numbers` 
      $query = "UPDATE purchased_numbers SET status='realised' WHERE pn_sid={$pn_sid}";
      $result = mysqli_query($connect, $query);

      // Delete a number from `call_routes` 
      $query = "DELETE FROM call_routes WHERE phone_number={$phone_number}";
      $result = mysqli_query($connect, $query);

      header("Refresh:0; url=list_all_numbers.php?status=3");
      
    }catch(RestException $ex){
      header("Refresh:0; url=list_all_numbers.php?status=4");
    }
    
  }
  


  $incomingPhoneNumbers = $twilio->incomingPhoneNumbers->read([], 20); 
    /* $curl = curl_init();

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

    curl_close($curl); */
    $result = $incomingPhoneNumbers;
    // echo '<pre>';print_r($result);die;
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
              <h6 class="text-center color_green">Number Purchased Successfully</h6>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
              <h6 class="text-center color_red">Nothing Found</h6>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
              <h6 class="text-center color_red">Unable to purchase this number</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 3) {
            ?>
              <h6 class="text-center color_green">Number Released Successfully!!</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 4) {
            ?>
              <h6 class="text-center color_red">Something Went Wrong !!</h6>
            <?php
              }
            ?>
          </div>
            <?php
                if(isset($result) && !empty($result) && !isset($result->code))
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
                        <th >Action</th>
                      </thead>
                      <tbody>
                        <?php 
                            //fetch stored purchased numbers
                            $i = 1;
                            foreach ($result as $key => $value) {
                            $query = "SELECT phone_number,type,region,monthly_rental FROM purchased_numbers WHERE pn_sid = '{$value->sid}' AND status='in-use'";
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
                            <td><?= $value->phoneNumber; ?></td>
                            <td>$<?= $row['monthly_rental']; ?></td>
                            <td><?= $value->dateCreated->format('Y-m-d H:i:s'); ?></td>
                            <td>
                              <form method="POST">
                                <input type="hidden" name="pn_sid" value="<?= $value->sid; ?>">
                                <input type="hidden" name="phone_number" value="<?= $row['phone_number']; ?>">
                                <input type="submit" class="btn btn-warning" id="release-number" value="Release">
                              </form>
                            </td>
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
             else if(isset($result) && empty($result)){
          ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-center"> Nothing Found!</h4>
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
    
