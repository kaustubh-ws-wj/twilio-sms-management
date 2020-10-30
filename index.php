<?php
    session_start(); 
    if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
        header("location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
      Login
    </title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/now-ui-dashboard.minaa26.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets/demo/demo.css" rel="stylesheet" />
  </head>
  <body class="login-page sidebar-mini ">
    <!-- Navbar -->
    <!-- End Navbar -->
    <div class="wrapper wrapper-full-page ">
      <div class="full-page login-page section-image" filter-color="black" data-image="assets/img/bg14.jpg">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="content" style="padding: 0px;">
          <div class="container">
            <div class="col-md-4 ml-auto mr-auto">
              <form class="form" method="POST" action="do_login.php">
                <div class="card card-login card-plain">
                  <div class="card-header ">
                    <h1 class="text-center color_white">Login</h1>
                  </div>
                  <div class="card-body ">
                    <div class="input-group no-border form-control-lg">
                      <span class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="now-ui-icons users_circle-08"></i>
                        </div>
                      </span>
                      <input type="text" class="form-control" placeholder="UserName" required="" name="user_name">
                    </div>
                    <div class="input-group no-border form-control-lg">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="now-ui-icons text_caps-small"></i>
                        </div>
                      </div>
                      <input type="password" placeholder="Password" class="form-control" required="" name="password">
                    </div>
                  </div>
                  <div class="card-footer ">
                    <input type="submit" value="Login" class="btn btn-primary btn-round btn-lg btn-block mb-3">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.min.js" ></script>
    <script src="assets/js/core/popper.min.js" ></script>
    <script src="assets/js/core/bootstrap.min.js" ></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js" ></script>
    <script src="assets/js/plugins/moment.min.js"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="assets/js/plugins/bootstrap-switch.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="assets/js/plugins/sweetalert2.min.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="assets/js/plugins/jquery.validate.min.js"></script>
    <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="assets/js/plugins/bootstrap-selectpicker.js" ></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="assets/js/plugins/bootstrap-datetimepicker.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
    <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="assets/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="assets/js/plugins/nouislider.min.js" ></script>
    <!--  Google Maps Plugin    -->
    <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGat1sgDZ-3y6fFe6HD7QUziVC6jlJNog"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="buttons.github.io/buttons.js"></script>
    <!-- Chart JS -->
    <script src="assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc --><script src="assets/js/now-ui-dashboard.minaa26.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/demo/demo.js"></script>
    <!-- Sharrre libray -->
    <script src="assets/demo/jquery.sharrre.js"></script>
  </body>
</html>