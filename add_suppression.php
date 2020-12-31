<?php
  $title = "Add Suppression";
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
          $page_name = "Add Group";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h6 class="text-center color_green">Number Suppression Added Sccessfully</h6>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h6 class="text-center color_red">Something went Wrong</h6>
            <?php
              }
            ?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header ">
                    <h4 class="card-title">Add Suppression</h4>
                </div>
                <div class="card-body">
                  <form action="insert_suppression.php" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="card-title">Enter the Numbers one per line</label>
                        <div class="form-group form-file-upload form-file-simple">
                          <textarea class="form-control" rows="100" name="suppression_numbers" required=""></textarea>
                        </div>
                        <div class="form-group form-file-upload form-file-multiple">
                          <input type="submit" value="Suppress" class="btn btn-warning">
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