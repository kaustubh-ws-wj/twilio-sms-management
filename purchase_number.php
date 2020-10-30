<?php
    $title = "Buy Phone Number";
    include 'inc/head.php';
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
          $page_name = "Buy Phone Number";
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
                  <form method="post" action="buy_number.php">
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Buy Number</h4>
                      <div class="form-group form-file-upload form-file-simple">
                        <input type="text" class="form-control number_text" required="" name="number">
                      </div>
                      <div class="form-group form-file-upload form-file-multiple">
                        <input type="button" value="Search" class="btn btn-warning confirm_purchase">
                      </div>
                    </div>
                    <div class="col-md-6">
                      
                    </div>
                  </div>
                  </form>
                </div>
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
    
    <script>
        $(".confirm_purchase").click(function() {
            if($(".number_text").val() != "")
            {
                if(confirm("Are you sure you want to proceed ?"))
                {
                  $(this).closest('form').submit();
                  return  false;
                }   
            }
            else{
                alert("Enter phone number");
            }
        });
    </script>