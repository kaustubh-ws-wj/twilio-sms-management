<?php
  $title = "Create Campaign";
  include 'inc/head.php';
  include 'connection.php';
  require 'vendor/autoload.php';
  use Plivo\RestClient;
  use Plivo\Exceptions\PlivoRestException;
  
  
  $query = "SELECT * FROM add_group";
  $result = mysqli_query($connect, $query);
  
  $query_routes = "SELECT * FROM call_routes GROUP by `call_routes_name`";
  $result_routes = mysqli_query($connect, $query_routes);
  
  
  
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
          $page_name = "Create Campaign";
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
                <h1 class="text-center color_red">Please Select Call Group Contacts</h1>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Something went wrong</h1>
            <?php
              }
            ?>

          </div>
          <form action="SendSMS.php" method="post">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                          <h4 class="card-title">Enter Campaign Name</h4>
                          <div class="form-group form-file-upload form-file-simple">
                            <input name="campaign_name" class="form-control" placeholder="Enter Campaign Name" required="">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <h4 class="card-title">Select Group</h4>
                          <div class="form-group form-file-upload form-file-simple">
                            <select class="form-control gettotalcontacts" name="group" required="">
                                <option value="" disabled="" selected="">Select</option>
                              <?php while($row=mysqli_fetch_assoc($result)) {  ?>
                                <option value="<?= $row['add_group_id']; ?>"><?= $row['add_group_name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="col-md-12">
                          <h4 class="card-title">Select Call Route/Group</h4>
                          <div class="form-group form-file-upload form-file-simple">
                            <select class="form-control getroutes" name="route" required="">
                                <option value="" disabled="" selected="">Select</option>
                              <?php while($row_routes=mysqli_fetch_assoc($result_routes)) {  ?>
                                <option value="<?= $row_routes['call_routes_name']; ?>"><?= $row_routes['call_routes_name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <h4 class="card-title">Enter Text Message</h4>
                          <div class="form-group form-file-upload form-file-simple">
                            <textarea rows="4" name="message" class="form-control" placeholder="Write!" required=""></textarea>
                          </div>
                        </div>
                      
                      
                    </div>
                  </div>
                </div>
              </div>
              <!-- end card -->
            </div>
            <div class="col-md-12">
              <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Call Route Name</th>
                      <th>Number</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>Call Route Name</th>
                      <th>Number</th>
                      <th>Status</th>
                    </tr>
                  </tfoot>
                  <tbody id="response">
                  </tbody>
                </table>
              <div class="form-group form-file-upload form-file-multiple">
                <input type="submit" value="Send SMS" class="btn btn-warning pull-right mainbtn">
              </div>
              </div>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
<?php
  include 'inc/footer.php';
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#datatable').hide();
    $('.mainbtn').hide();

    $(".getroutes").change(function(){
        var id = $(".getroutes option:selected").val();
        $.ajax({
            type: "POST",
            url: "get_numbers.php",
            data: { id : id } 
        }).done(function(data){
            $('#datatable').show();
            $('.mainbtn').show();
            // var table = $('#datatable').DataTable();
            $("#response").empty();
            $("#response").html(data);
        });
    });
});
</script>