<?php
  $title = "Dashboard";
  include 'inc/head.php';
  include 'connection.php';
  $query_get_group_count= "SELECT * FROM add_group";
  $result_get_group_count = mysqli_query($connect,$query_get_group_count);
  $group_count = mysqli_num_rows($result_get_group_count);

  $query_get_numbers_count= "SELECT * FROM numbers";
  $result_get_numbers_count = mysqli_query($connect,$query_get_numbers_count);
  $numbers_count = mysqli_num_rows($result_get_numbers_count);

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
          $page_name = "Dashboard";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
            <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h6 class="text-center color_green">Group Deleted successfully</h6>
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
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="statistics">
                        <div class="info">
                          <div class="icon icon-info">
                            <i class="now-ui-icons users_single-02"></i>
                          </div>
                          <h3 class="info-title"><?=$numbers_count?></h3>
                          <h6 class="stats-title">Contacts</h6>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="statistics">
                        <div class="info">
                          <div class="icon icon-danger">
                            <i class="now-ui-icons objects_support-17"></i>
                          </div>
                          <h3 class="info-title"><?=$group_count?></h3>
                          <h6 class="stats-title">Groups</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            
          </div>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <?php
      include 'inc/footer.php';
    ?>