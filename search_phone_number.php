<?php
    include 'config.php';
    $title = "Search Phone Number";
    include 'inc/head.php';
    include 'connection.php';
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);
    
    //search phone number
      //get filter condition by contry code
        //apply filter response to filter data

    if(isset($_POST) && !empty($_POST))
    {
      $price = 0;
      if(isset($_POST['country_code']) && $_POST['country_code'] != ''){
        $country_code = strtoupper($_POST['country_code']);
      }
      /* if(isset($_POST['type_check']) && $_POST['type_check'] != ''){
        $type_check = $_POST['type_check'];
        if($type_check == 'local'){
          $url = "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/AvailablePhoneNumbers/".$country_code."/Local.json";
        }else if($type_check == 'mobile'){
          $url = "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/AvailablePhoneNumbers/".$country_code."/Mobile.json";
        }else{
          $url = "https://api.twilio.com/2010-04-01/Accounts/".ACCOUNT_SID."/AvailablePhoneNumbers/".$country_code."/Tollfree.json";
        }
      } */
      $str_args ='';
      $data = array();
      if(isset($_POST['capability_check'])){
        if(!empty($_POST['capability_check'])){
          foreach ($_POST['capability_check'] as $key => $value) {
            //$str_args .= $value.'=true&';
            $data[$value] = 'true';
          }
        }
      }
      if(isset($_POST['areaCode'])){
        if(!empty($_POST['areaCode'])){
          //$str_args .='areaCode='.$_POST['areaCode'].'&'; 
          $data['areaCode'] = $_POST['areaCode'];
        }
      }
      if(isset($_POST['address_check'])){
        if(!empty($_POST['address_check'])){
          foreach ($_POST['address_check'] as $key => $value) {
            //$str_args .= $value.'=true&';
            $data[$value] = 'true';
          }
        }
      }
      //$str_args = rtrim($str_args,'&');
      
      if(isset($_POST['type_check']) && $_POST['type_check'] != ''){
        $type_check = $_POST['type_check'];
        if($type_check == 'local'){
          $response = $twilio->availablePhoneNumbers($country_code)->local->read($data, 20);

        }else if($type_check == 'mobile'){
          $response = $twilio->availablePhoneNumbers($country_code)->mobile->read($data, 20);

        }else{
          $response = $twilio->availablePhoneNumbers($country_code)->tollFree->read($data, 20);
        }
      }

      //echo $str_args;die;
      /* $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => $str_args,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".BASIC_AUTH_KEY,
            "Content-Type: application/x-www-form-urlencoded"
        ),
      )); 
      $response = curl_exec($curl);
      curl_close($curl);*/
      $result = $response;
      
      if(!empty($result)){
          if(isset($result->status)){
              echo json_encode(array('status'=>'error','response'=>$response));
          }else{

            $phone_price_json = $twilio->pricing->v1->phoneNumbers->countries($country_code)->fetch();

              //call phone number 
              /* $curl = curl_init();
              curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pricing.twilio.com/v1/PhoneNumbers/Countries/".$country_code,
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
              $phone_price_json = curl_exec($curl);
              curl_close($curl); */
              $phone_price_response = $phone_price_json->toArray();
              
              foreach ($phone_price_response['phoneNumberPrices'] as $key => $value) {
                if($value['number_type'] == 'local'){
                  $price = $value['base_price'];
                }
                if($value['number_type'] == 'toll free'){
                  $price = $value['base_price'];
                }
                if($value['number_type'] == 'mobile'){
                  $price = $value['base_price'];
                }
              }
          }
      }
    }
?>

  <body class=" sidebar-mini ">
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrapper ">
      <?php
        include 'inc/header.php';
      ?>
      <style>
        #overlay img {
            position: absolute;
            top: 60%;
            left: 20%;
        }
      </style>
      <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <?php
          $page_name = "Search Phone Number";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">Group Added Sccessfully</h1>
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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form method="post" id="submit_search" action="search_phone_number.php">
                    <div class="row">
                      <div class="col-md-6">
                        <h4 class="card-title">Search</h4>
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="text" id="phone" class="form-control" name="areaCode" required="">
                          <input type="hidden" id="country_code"  name="country_code">
                        </div>
                        <!-- <div class="form-group form-file-upload form-file-multiple">
                          <input type="button" id="get_country_code" value="Search" class="btn btn-warning">
                        </div> -->
                      </div>
                    </div>
                    <hr>
                    <div id="overlay">
                      <img src="assets/img/loading.gif" width="35px" height="35px"/>
                    </div>
                    <div class="row type_section">
                        <label class="col-sm-1 col-form-label">Type</label>
                        <!-- <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" name='type_radio' id="type_any" value="all" type="radio">
                                    <span class="form-check-sign"></span>
                                    ALL
                                </label>
                            </div>
                        </div> -->
                        <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="type_check" id="type_local" value="local" type="radio">
                                    <span class="form-check-sign"></span>
                                    LOCAL
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="type_check" id="type_mobile" value="mobile" type="radio" >
                                    <span class="form-check-sign"></span>
                                    MOBILE
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-offset-1 checkbox-radios">
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="type_check" id="type_toll_free" value="toll_free" type="radio" >
                                    <span class="form-check-sign"></span>
                                    TOLL-FREE
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-8 offset-md-1 col-form-label">Do your users expect to call a local number, a mobile number, or a toll-free number? You choose.</label>
                    </div>
                    <div class="advance_content">
                      <div class="row">
                          <label class="col-sm-1 col-form-label">Capability</label>
                          <!-- <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check form-check-radio">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capabiltiy_radio" id="capability_any" value="any" type="radio">
                                      <span class="form-check-sign"></span>
                                      ANY
                                  </label>
                              </div>
                          </div> -->
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" id="capability_voice" value="voiceEnabled" type="checkbox">
                                      <span class="form-check-sign"></span>
                                      VOICE
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" id="capability_fax" value="faxEnabled" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      FAX
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check ">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" value="smsEnabled" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      SMS
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check ">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" value="mmsEnabled" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      MMS
                                  </label>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <label class="col-md-8 offset-md-1 col-form-label">Different numbers have different communications capabilities. Select the ones your phone number needs.</label>
                      </div>
                      <div class="row address_section">
                          <label class="col-sm-1 col-form-label">Address Requirments</label>
                          <!-- <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check form-check-radio">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="address_radio" value="any" type="radio">
                                      <span class="form-check-sign"></span>
                                      ANY
                                  </label>
                              </div>
                          </div> -->
                          <!-- <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check form-check-radio">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="address_radio" value="none" type="radio">
                                      <span class="form-check-sign"></span>
                                      NONE
                                  </label>
                              </div>
                          </div> -->
                          <div class="col-sm-2 col-sm-offset-1 checkbox-radios">
                              <div class="form-check">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="address_check[]" value="excludeLocalAddressRequired" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      Exclude local requirements
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-2 col-sm-offset-1 checkbox-radios">
                              <div class="form-check ">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="address_check[]" value="excludeForeignAddressRequired" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      Exclude foreign requirements
                                  </label>
                              </div>
                          </div>           
                      </div>
                      <div class="row">
                          <label class="col-md-8 offset-md-1 col-form-label">Some local authorities require you to provide an address before purchasing a phone number.</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-1">
                        <div class="form-group form-file-upload form-file-multiple">
                          <input type="button" id="get_country_code" value="Search" class="btn btn-warning">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group form-file-upload form-file-multiple">
                          <a href="#" class="show_hide" data-content="toggle-text">Show Advanced Search</a>
                        </div>
                      </div>
                      

                    </div>
                  </form>
                </div>
              </div>
              <!-- end card -->
            </div>
          </div>
          <?php
            if(isset($result) && !empty($result))
            {
          ?>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title"> All Results</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-shopping">
                        <thead class="">
                          <th  class="text-center" ></th>
                          <th >#</th>
                          <th >Country</th>
                          <th >Number</th>
                          <th >Type</th>
                          <th >Capability</th>
                          <th >Monthly Rental Rate</th>
                          <!-- <th >SMS Rate</th> -->
                          <!-- <th >Voice Rate</th> -->
                          <th >Action</th>
                        </thead>
                        <tbody>
                          <?php 
                            $i = 1;
                            foreach ($result as $key => $value) {
                              $val = $value->toArray();
                          ?>  
                            <tr>
                              <td></td>
                              <td><?= $i; ?></td>
                              <td><?= $val['isoCountry']; ?></td>
                              <td><?= $val['friendlyName']; ?></td>
                              <td><?= $type_check; ?></td>
                              <td><?php if(isset($val['capabilities']['SMS']) == true){ echo 'SMS '; }if(isset($val['capabilities']['MMS']) == true){ echo 'MMS '; }if(isset($val['capabilities']['voice']) == true){ echo 'VOICE ';}if(isset($val['capabilities']['fax']) == true){ echo 'FAX ';} ?></td>
                              <td><?= $price; ?></td>
                              <!-- <td><?= $val->friendlyName; ?></td> -->
                              <!-- <td><?= $val->friendlyName; ?></td> -->
                              <td>
                                  <form action="buy_number.php" method="POST">
                                    <input type="hidden" value="<?= $val['phoneNumber']; ?>" name="phoneNumber">
                                    <input type="hidden" value="<?= $_POST["country_code"]; ?>" name="country_code">
                                    <input type="hidden" value="<?= $_POST["country_code"]; ?>" name="region">
                                    <input type="hidden" value="<?= $price; ?>" name="monthly_rental">
                                    <input type="hidden" value="<?= $type_check; ?>" name="type">
                                    <input type="button" class="btn btn-success confirm_purchase" value="Buy Now">
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
    <?php //if(!isset($_SERVER['REQUEST'])){ ?>
    <script>
    $(".advance_content").hide();
      var input = document.querySelector("#phone");
      var iti;
      $.ajax({
          url:"apis/phone_number/fetch_phone_no_country.php",
          dataType:"JSON",
          method:"POST",
          async:false,
          beforeSend: function () {
            $("#overlay").show();
          },
          success:function(response){
            if(response.status == 'error'){
              alert('error');
            }else{
              iti = window.intlTelInput(input, {
                // allowDropdown: false,
                // autoHideDialCode: false,
                // autoPlaceholder: "off",
                // dropdownContainer: document.body,
                // excludeCountries: ["us"],
                // formatOnDisplay: false,
                // geoIpLookup: function(callback) {
                //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                //     var countryCode = (resp && resp.country) ? resp.country : "";
                //     callback(countryCode);
                //   });
                // },
                // hiddenInput: "full_number",
                // initialCountry: "us",
                // localizedCountries: { 'de': 'Deutschland' },
                // nationalMode: false,
                onlyCountries: response,
                // placeholderNumberType: "MOBILE",
                // preferredCountries: ['cn', 'jp'],
                // separateDialCode: true,
                utilsScript: "assets/js/core/utils.js",
              });
              setInterval(function () {
                $("#overlay").hide();
              }, 800);
            }
          }
      });
    $(document).ready(function(){
      
      input.addEventListener("countrychange", function(){
        var country_code  = iti.getSelectedCountryData().iso2;
        //call api for the
        $.ajax({
          url:"apis/phone_number/fetch_specific_country.php",
          data:{"country_code":country_code},
          dataType:"JSON",
          method:"POST",
          beforeSend: function () {
            $("#overlay").show();
          },
          success:function(response){
            console.log(response);
            if(response.status == 'error'){
              alert('error');
            }else{
              if('local' in response.subresource_uris){
                //set check box for local
                console.log('local');
                $('#type_local').prop('checked', true);
                $('#type_local').prop('disabled', false);
                $('#type_local').parent().parent().removeClass('disabled');
              }else{
                $('#type_local').prop('checked', false);
                $('#type_local').prop('disabled', true);
                $('#type_local').parent().parent().addClass('disabled');
              }
              if('toll_free' in response.subresource_uris){
                //set check box for toll_free
                console.log('toll-free');
                $('#type_toll_free').prop('checked', true);
                $('#type_toll_free').prop('disabled', false);
                $('#type_toll_free').parent().parent().removeClass('disabled');
              }else{
                $('#type_toll_free').prop('checked', false);
                $('#type_toll_free').prop('disabled', true);
                $('#type_toll_free').parent().parent().addClass('disabled');
              }
              if('mobile' in response.subresource_uris){
                //set check box for mobile
                console.log('mobile');
                $('#type_mobile').prop('checked', true);
                $('#type_mobile').prop('disabled', false);
                $('#type_mobile').parent().parent().removeClass('disabled');
              }else{
                $('#type_mobile').prop('checked', false);
                $('#type_mobile').prop('disabled', true);
                $('#type_mobile').parent().parent().addClass('disabled');
              }
              setInterval(function () {
                $("#overlay").hide();
              }, 4500);
            }
          }
        });
      });
      $(".show_hide").on("click", function () {
        var txt = $(".advance_content").is(':visible') ? 'Show Advanced Search' : 'Hide Advanced Search';
        $(".show_hide").text(txt);
        $('.advance_content').slideToggle(200);
      });

      var country_code = $(".iti__active").attr("data-country-code");
      //call api for the
      $.ajax({
        url:"apis/phone_number/fetch_specific_country.php",
        data:{"country_code":country_code},
        dataType:"JSON",
        method:"POST",
        beforeSend: function () {
          $("#overlay").show();
        },
        success:function(response){
          console.log(response);
          if(response.status == 'error'){
            alert('error');
          }else{
            if('local' in response.subresource_uris){
              //set check box for local
              console.log('local');
              $('#type_local').prop('checked', true);
              $('#type_local').prop('disabled', false);
              $('#type_local').parent().parent().removeClass('disabled');
            }else{
              $('#type_local').prop('checked', false);
              $('#type_local').prop('disabled', true);
              $('#type_local').parent().parent().addClass('disabled');
            }
            if('toll_free' in response.subresource_uris){
              //set check box for toll_free
              console.log('toll-free');
              $('#type_toll_free').prop('checked', true);
              $('#type_toll_free').prop('disabled', false);
              $('#type_toll_free').parent().parent().removeClass('disabled');
            }else{
              $('#type_toll_free').prop('checked', false);
              $('#type_toll_free').prop('disabled', true);
              $('#type_toll_free').parent().parent().addClass('disabled');
            }
            if('mobile' in response.subresource_uris){
              //set check box for mobile
              console.log('mobile');
              $('#type_mobile').prop('checked', true);
              $('#type_mobile').prop('disabled', false);
              $('#type_mobile').parent().parent().removeClass('disabled');
            }else{
              $('#type_mobile').prop('checked', false);
              $('#type_mobile').prop('disabled', true);
              $('#type_mobile').parent().parent().addClass('disabled');
            }
            setInterval(function () {
                $("#overlay").hide();
            }, 4500);
          }
        }
      });
    });

    $("#get_country_code").click(function() {
        var country_code = $(".iti__active").attr("data-country-code");
        console.log(country_code);
        $("#country_code").val(country_code);
        $("#submit_search").submit();
    });
    
    $(".confirm_purchase").click(function() {
        if(confirm("Are you sure you want to proceed ?"))
        {
          $(this).closest('form').submit();
          return false;
        }
    });
  </script>
  <?php //} ?>
  <?php 
    if(isset($_POST['country_code']) && $_POST['country_code'] != ''){
  ?>
  <script>
      var set_country = '<?php echo @$_POST['country_code']; ?>';
      iti.setCountry(set_country);
  </script>
  <?php    
    }
  ?>
  <?php 
    if(isset($_POST['Contains']) && $_POST['Contains'] != ''){
  ?>
  <script>
      var set_number = '<?php echo @$_POST['Contains']; ?>';
      iti.setNumber(set_number);
  </script>
  <?php    
    }
  ?>