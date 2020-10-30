<?php
  $title = "Add Group";
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
                <h1 class="text-center color_green">Group Added Sccessfully</h1>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Something went Wrong</h1>
            <?php
              }
            ?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form action="insert_group.php" method="post">
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Enter Group Name</h4>
                      <div class="form-group form-file-upload form-file-simple">
                        <input type="text" class="form-control" name="group_name" required="">
                      </div>
                      <div class="form-group form-file-upload form-file-multiple">
                        <input type="submit" value="Add" class="btn btn-warning">
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