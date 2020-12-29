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
                <h6 class="text-center color_green">Group Deleted Sccessfully</h6>
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
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> All Groups</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-shopping">
                      <thead class="">
                        <th  class="text-center" >
                        </th>
                        <th >
                          ID
                        </th>
                        <th >
                          Name
                        </th>
                        <th >
                          Total Contact
                        </th>
                        <th >
                          Action
                        </th>
                      </thead>
                      <tbody>
                        <?php 
                          while($row=mysqli_fetch_assoc($result_get_group_count)) {
                            $query_do = "SELECT * FROM numbers where numbers_group_id = {$row['add_group_id']}";
                            $result_do = mysqli_query($connect, $query_do);
                            $result_do = mysqli_num_rows($result_do);
                        ?>
                          <tr>
                            <td>
                            </td>
                            <td>
                              <?= $row['add_group_id']; ?>
                            </td>
                            <td>
                              <?= $row['add_group_name']; ?>
                            </td>
                            <td>
                              <?=$result_do?>
                            </td>
                            <td>
                              <a href="view_contacts.php?group=<?= $row['add_group_id']; ?>" class="btn btn-info"> View</a>
                              <a href="delete_group.php?group=<?= $row['add_group_id']; ?>" class="btn btn-info"> Delete</a>
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
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> Purchased Number</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-shopping">
                      <thead class="">
                        <th  class="text-center" ></th>
                        <th >ID</th>
                        <th >Number</th>
                        <th >Contry Contact</th>
                        <th >Status</th>
                      </thead>
                      <tbody>
                        <?php 
                          while($row=mysqli_fetch_assoc($result_get_group_count)) {
                            $query_do = "SELECT * FROM numbers where numbers_group_id = {$row['add_group_id']}";
                            $result_do = mysqli_query($connect, $query_do);
                            $result_do = mysqli_num_rows($result_do);
                        ?>
                          <tr>
                            <td></td>
                            <td><?= $row['add_group_id']; ?></td>
                            <td><?= $row['add_group_name']; ?></td>
                            <td><?=$result_do?></td>
                            <td>
                              <a href="view_contacts.php?group=<?= $row['add_group_id']; ?>" class="btn btn-info"> View</a>
                              <a href="delete_group.php?group=<?= $row['add_group_id']; ?>" class="btn btn-info"> Delete</a>
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
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <?php
      include 'inc/footer.php';
    ?>