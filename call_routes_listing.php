<?php
  $title = "Call Route / Group ";
  include 'inc/head.php';
  include 'connection.php';
  $query = "SELECT * FROM call_routes GROUP by `call_routes_name`";
  $result = mysqli_query($connect, $query);
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
          $page_name = "Call Route / Group ";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h6 class="text-center color_green">Call Routes Added Successfully</h6>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h6 class="text-center color_green">Call Routes Deleted Successfully</h6>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h6 class="text-center color_red">Something went wrong</h6>
            <?php
              }
            ?>

          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Call Route Name</th>
                      <th>Count</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Call Route Name</th>
                      <th>Count</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php while($row=mysqli_fetch_assoc($result)) {
                          $query_get_numbers_count= "SELECT * FROM call_routes where `call_routes_name` = '{$row['call_routes_name']}'";
                          $result_get_numbers_count = mysqli_query($connect,$query_get_numbers_count);
                          $numbers_count = mysqli_num_rows($result_get_numbers_count);
                      ?>
                        <tr>
                            <td><?= $row['call_routes_name']; ?></td>
                            <td><?= $numbers_count; ?></td>
                            <td><?= ($row['call_routes_status'] == 1) ? 'Active' : 'Inactive' ?></td>
                            <td><a href="call_routes_groups.php?type=edit&name=<?= $row['call_routes_name']; ?>" class="btn btn-info">Edit</a> <a href="delete_call_routes_groups.php?name=<?= $row['call_routes_name']; ?>" class="btn btn-info">Delete</a></td>
                        </tr>
                      <?php } ?>
                  </tbody>
                </table>
              <div class="form-group form-file-upload form-file-multiple">
                <a class="btn btn-info pull-left mainbtn color_white" href="call_routes_groups.php">New Call Route</a>
              </div>
              </div>
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