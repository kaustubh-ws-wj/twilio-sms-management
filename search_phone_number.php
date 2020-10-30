<?php
    $title = "Search Phone Number";
    include 'inc/head.php';
  
    require 'vendor/autoload.php';
    
    include 'connection.php';
    
    
    //search phone number 
      //get filter condition by contry code
        //apply filter response to filter data

    if(isset($_POST) && !empty($_POST))
    {
      
      if(isset($_POST['country_code']) && $_POST['country_code'] != ''){
        $country_code = strtoupper($_POST['country_code']);
      }
      if(isset($_POST['type_check']) && $_POST['type_check'] != ''){
        $type_check = $_POST['type_check'];
        if($type_check == 'local'){
          $url = "https://api.twilio.com/2010-04-01/Accounts/AC529db4ea06aba0a1ed7356e28d6b0dbb/AvailablePhoneNumbers/".$country_code."/Local.json";
        }else if($type_check == 'mobile'){
          $url = "https://api.twilio.com/2010-04-01/Accounts/AC529db4ea06aba0a1ed7356e28d6b0dbb/AvailablePhoneNumbers/".$country_code."/Mobile.json";
        }else{
          $url = "https://api.twilio.com/2010-04-01/Accounts/AC529db4ea06aba0a1ed7356e28d6b0dbb/AvailablePhoneNumbers/".$country_code."/Tollfree.json";
        }
      }
      $str_args ='';
      if(isset($_POST['capability_check'])){
        if(!empty($_POST['capability_check'])){
          foreach ($_POST['capability_check'] as $key => $value) {
            $str_args .= $value.'=true&';  
          }
        }
      }

      if(isset($_POST['address_check'])){
        if(!empty($_POST['address_check'])){
          foreach ($_POST['address_check'] as $key => $value) {
            $str_args .= $value.'=true&';
          }
        }
      }
      $str_args = rtrim($str_args,'&');
      


      $curl = curl_init();
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
          "Authorization: Basic QUM1MjlkYjRlYTA2YWJhMGExZWQ3MzU2ZTI4ZDZiMGRiYjo3MzlmM2Q2YmY3ODA5YjczMmEyMDNhNTFlZDM2MjVkNg==",
          "Content-Type: application/x-www-form-urlencoded"
      ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $result = json_decode($response);
      if(!empty($result)){
          if(isset($result->status)){
              echo json_encode(array('status'=>'error'));
          }else{
              
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
                          <input type="text" id="phone" class="form-control" name="country_pattern" required="">
                          <input type="hidden" id="country_code"  name="country_code">
                        </div>
                        <!-- <div class="form-group form-file-upload form-file-multiple">
                          <input type="button" id="get_country_code" value="Search" class="btn btn-warning">
                        </div> -->
                      </div>
                    </div>
                    <hr>
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
                                      <input class="form-check-input" name="capability_check[]" id="capability_voice" value="VoiceEnabled" type="checkbox">
                                      <span class="form-check-sign"></span>
                                      VOICE
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" id="capability_fax" value="FaxEnabled" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      FAX
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check ">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" value="SmsEnabled" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      SMS
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-1 col-sm-offset-1 checkbox-radios">
                              <div class="form-check ">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="capability_check[]" value="MmsEnabled" type="checkbox" >
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
                                      <input class="form-check-input" name="address_check[]" value="ExcludeLocalAddressRequired" type="checkbox" >
                                      <span class="form-check-sign"></span>
                                      Exclude local requirements
                                  </label>
                              </div>
                          </div>
                          <div class="col-sm-2 col-sm-offset-1 checkbox-radios">
                              <div class="form-check ">
                                  <label class="form-check-label">
                                      <input class="form-check-input" name="address_check[]" value="ExcludeForeignAddressRequired" type="checkbox" >
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
                if(isset($result->available_phone_numbers) && !empty($result->available_phone_numbers))
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
                          <th  class="text-center" >
                          </th>
                          <th >
                            #
                          </th>
                          <th >
                            Country
                          </th>
                          <th >
                            Number
                          </th>
                          <th >
                            Type
                          </th>
                          <th >
                            Prefix
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
                            Action
                          </th>
                        </thead>
                        <tbody>
                          <?php 
                          $count = count($result->available_phone_numbers);
                          foreach ($result->available_phone_numbers as $key => $value) {
                            # code...
                          }  
                          for($i=0; $i<$count;$i++){
                                  // echo "<pre>";
                                  // print_r($response->resources[$i]->properties);  
                                  // echo $i;
                          ?>
                            <tr>
                              <td>
                              </td>
                              <td>
                                <?= $i+1; ?>
                              </td>
                              <td>
                                <?= $value->iso_country; ?>
                              </td>
                              <td>
                                <?= $value->friendly_name; ?>
                              </td>
                              <td>
                                <?= $type_check; ?>
                              </td>
                              <td>
                                <?= $value->friendly_name;; ?>
                              </td>
                              <td>
                                <?= $value->friendly_name;; ?>
                              </td>
                              <td>
                                <?= $value->friendly_name; ?>
                              </td>
                              <td>
                                <?= $value->friendly_name; ?>
                              </td>
                              <td>
                                  <form action="buy_number.php" method="post">
                                      <!-- <input type="hidden" value="<?= $response->resources[$i]->properties['resourceUri']; ?>" name="resourceUri">
                                      <input type="hidden" value="<?= $response->resources[$i]->properties['number']; ?>" name="number">
                                      <input type="hidden" value="<?= $response->resources[$i]->properties['prefix']; ?>" name="prefix">
                                      <input type="hidden" value="<?= $response->resources[$i]->properties['region']; ?>" name="region">
                                      <input type="hidden" value="<?= $_POST["country_code"]; ?>" name="country_code"> -->
                                      <input type="button" class="btn btn-success confirm_purchase" value="Buy Now">
                                  </form>
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
    
    <script>

    $(document).ready(function(){

      var input = document.querySelector("#phone");
      var iti = window.intlTelInput(input, {
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
        // initialCountry: "auto",
        // localizedCountries: { 'de': 'Deutschland' },
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        // placeholderNumberType: "MOBILE",
        // preferredCountries: ['cn', 'jp'],
        // separateDialCode: true,
        utilsScript: "assets/js/core/utils.js",
      });

      input.addEventListener("countrychange", function(){
        var country_code  = iti.getSelectedCountryData().iso2;
        //call api for the
        $.ajax({
          url:"apis/phone_number/fetch_specific_country.php",
          data:{"country_code":country_code},
          dataType:"JSON",
          method:"POST",
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
            }
          }
        });
      });


      $(".advance_content").hide();
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
            }
          }
        });
    });


    /* $("#phone").focusout(function() {
        var country_code = $(".iti__active").attr("data-country-code");
        // var c_code = flag.split("+").pop();
        console.log(country_code);
        $("#country_code").val(country_code);

        $.ajax({
          url:"apis/phone_number/fetch_specific_country.php",
          data:{"country_code":country_code},
          dataType:"JSON",
          method:"POST",
          success:function(response){
            console.log(response);
            if(response.status == 'error'){
              alert('error');
            }else{
              if('local' in response.subresource_uris){
                //set check box for local
                console.log('local');
                $('#type_local').prop('checked', true);
              }else{
                $('#type_local').prop('checked', false);
                $('#type_local').prop('disabled', true);
                $('#type_local').parent().parent().addClass('disabled');
              }
              if('toll_free' in response.subresource_uris){
                //set check box for toll_free
                console.log('toll-free');
                $('#type_toll_free').prop('checked', true);
              }else{
                $('#type_toll_free').prop('checked', false);
                $('#type_toll_free').prop('disabled', true);
                $('#type_toll_free').parent().parent().addClass('disabled');
              }
              if('mobile' in response.subresource_uris){
                //set check box for mobile
                console.log('mobile');
                $('#type_mobile').prop('checked', true);
              }else{
                $('#type_mobile').prop('checked', false);
                $('#type_mobile').prop('disabled', true);
                $('#type_mobile').parent().parent().addClass('disabled');
              }
            }
          }
        });


    }); */
    
    $("#get_country_code").click(function() {
        var country_code = $(".iti__active").attr("data-country-code");
        // var c_code = country_code.split("+").pop();
        console.log(country_code);
        $("#country_code").val(country_code);
        
        $("#submit_search").submit();
    });
    
    $(".confirm_purchase").click(function() {
        if(confirm("Are you sure you want to proceed ?"))
        {
          $(this).closest('form').submit();
          return  false;
        }
    });
  </script>
  <?php 
    if(isset($_POST['']))
  ?>