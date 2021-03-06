<?php
  ini_set('max_execution_time', 6000);
  include 'config.php';
  $title = "Create Campaign";
  include 'inc/head.php';
  include 'connection.php';
  require 'vendor/autoload.php';
  
  $query = "SELECT * FROM add_group";
  $result = mysqli_query($connect, $query);
  
  $query_routes = "SELECT * FROM call_routes GROUP by `call_routes_name`";
  $result_routes = mysqli_query($connect, $query_routes);
  
  //fetch list names
  $contact_list_query = "SELECT * FROM contact_list";
  $result_list_query = mysqli_query($connect,$contact_list_query);

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
  $list_result = json_decode($response);
  
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
                <h6 class="text-center color_green">SMS Sent Successfully</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h6 class="text-center color_red">Please Select Call Group Contacts</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h6 class="text-center color_red">Something went wrong</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 3) {
            ?>
              <h6 class="text-center color_red">Fileds not mapped yet for this this list.</h6>
            <?php 
              } else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 4) {
            ?>
              <h6 class="text-center color_red">CSV file dont have any numbers.</h6>
            <?php 
              }
             ?>

          </div>
        <form action="SendSMS.php" method="post">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header text-center">
                  <h4 class="card-title">Create Campaign</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 ml-auto mr-auto">
                        <div class="col-md-12">
                          <label class="card-title">Enter Campaign Name</label>
                          <div class="form-group form-file-upload form-file-simple">
                            <input name="campaign_name" class="form-control" placeholder="Enter Campaign Name" id="campaign_name" required>
                          </div>
                        </div>
                        <!-- <div class="col-md-12">
                          <h4 class="card-title">Select Group</h4>
                          <div class="form-group form-file-upload form-file-simple">
                            <select class="form-control gettotalcontacts" name="group" required="">
                                <option value="" disabled="" selected="">Select</option>
                              <?php while($row=mysqli_fetch_assoc($result)) {  ?>
                                <option value="<?= $row['add_group_id']; ?>"><?= $row['add_group_name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div> -->
                        <div class="col-md-12">
                          <label class="card-title">Select List</label>
                          <div class="form-group form-file-upload form-file-simple">
                            <select class="form-control gettotalcontacts" name="contact_list" id="contact_list" required="">
                                <option value="" selected="">Select</option>
                              <?php while($contact_list_row=mysqli_fetch_assoc($result_list_query)) {  ?>
                                <option value="<?= $contact_list_row['id']; ?>" data-filepath="<?= $contact_list_row['list_path']; ?>"><?= $contact_list_row['list_name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                    
                        <div class="col-md-12">
                          <label class="card-title">Select Call Route/Group</label>
                          <div class="form-group form-file-upload form-file-simple">
                            <select class="form-control getroutes" name="route" id="route_group" required="">
                                <option value="" disabled="" selected="">Select</option>
                              <?php while($row_routes=mysqli_fetch_assoc($result_routes)) {  ?>
                                <option value="<?= $row_routes['call_routes_name']; ?>"><?= $row_routes['call_routes_name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="card-title">Enter Text Message</label>
                          <div class="form-group ">
                            <textarea rows="4" id="text_message" name="message" class="form-control" placeholder="Write!" onkeyup="countChar(this)" required=""></textarea>
                            <small id="message-text" class="form-text text-muted text-warning"> <span id="current-count">160</span> remaining out of 160</small>
                          </div>
                          <div class="card-body col-buttons" id="col-buttons">
                            
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
                  <tbody id="response"></tbody>
                </table>
                <div id="confirmBox">
                    <div class="message"><h1>Are you sure?</h1></div>
                    <div class="conformbtn"><span class="button yes">Yes</span>
                    <span class="button no">No</span></div>
                </div>
              <div class="form-group form-file-upload form-file-multiple">
                <input type="submit" value="Send Campaign" class="btn btn-warning pull-right mainbtn">
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
            data: { id : id }, 
        }).done(function(data){
            $('#datatable').show();
            $('.mainbtn').show();
            // var table = $('#datatable').DataTable();
            $("#response").empty();
            $("#response").html(data);
        });
    });

    $(".gettotalcontacts").change(function(e){
      var path = $(".gettotalcontacts option:selected").data('filepath');
      $.ajax({
        url:'get_file_cols.php',
        method:'POST',
        data:{"filepath":path},
        success:function(response){
          var button_html = '';
          button_html = '<a href="#" data-col="#spin#" class="btn btn-info btn-sm">Spin</a>';
          var obj =JSON.parse(response);
          if(obj.status){
            var button_obj = obj.buttons;
            $.each(button_obj,function(i){
              button_html += '<a href="#" data-col="#'+button_obj[i]+'#" class="btn btn-info btn-sm">'+button_obj[i]+'</a>';
            });
            $('.col-buttons').html(button_html);
          }
        }
      });
    });
});

    $('#col-buttons').on('click','a',function(){
      var col = $(this).data('col');
      var pre_string = $('#text_message').val() + col;
      $("#text_message").val(pre_string);
    });

    function countChar(val) {
      var len = val.value.length;
      if (len >= 160) {
        $('.text-warning').text('you have exceeded 160 charcters limit'); 
      } else {
        $('#current-count').text(160 - len);
      }
    };

    function doConfirm(msg, yesFn, noFn) {
        var confirmBox = $("#confirmBox");
        confirmBox.find(".message").html(msg);
        confirmBox.find(".yes,.no").unbind().click(function () {
            confirmBox.hide();
        });
        confirmBox.find(".yes").click(yesFn);
        confirmBox.find(".no").click(noFn);
        confirmBox.show();
    }

    $(function () {
        $("form").submit(function (e) {
            e.preventDefault();
            var form = this;
            var campaign_name = $('#campaign_name').val();
            var contact_list = $('#contact_list option:selected').text();
            var route_group = $('#route_group').val();
            var text_message = $('#text_message').val();
            var details = `Campaign Name - ${campaign_name}, <br>
                           Contact List - ${contact_list}, <br>
                           Route Group - ${route_group}, <br>
                           Text - ${text_message}, <br>`;
            doConfirm(details, function yes() {
                form.submit();
            }, function no() {
                // do nothing
            });
        });
    });

</script>
