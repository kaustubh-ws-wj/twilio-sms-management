<?php
  $title = "View Campaigns";
  include 'inc/head.php';
  include 'connection.php';
  $query_campaign_count= "SELECT * FROM campaign";
  $result_campaign_count = mysqli_query($connect,$query_campaign_count);
  $group_count = mysqli_num_rows($result_campaign_count);

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
          $page_name = "View Campaigns";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
            <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">Group Deleted Sccessfully</h1>
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
                <div class="card-header">
                  <h4 class="card-title"> All Campaigns</h4>
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
                          Message
                        </th>
                        <th >
                          Group
                        </th>
                        <th >
                          Call Route/Group
                        </th>
                        <th >
                         Call Route/Group Numbers
                        </th>
                        <th >
                          Date
                        </th>
                      </thead>
                      <tbody>
                        <?php 
                          while($row=mysqli_fetch_assoc($result_campaign_count)) {
                            $query_do = "SELECT * FROM add_group where add_group_id = {$row['campaign_group']}";
                            $result_do = mysqli_query($connect, $query_do);
                            $row_do=mysqli_fetch_assoc($result_do)
                        ?>
                          <tr>
                            <td>
                            </td>
                            <td>
                              <?= $row['campaign_id']; ?>
                            </td>
                            <td>
                              <?= $row['campaign_name']; ?>
                            </td>
                            <td>
                              <?= $row['campaign_message']; ?>
                            </td>
                            <td>
                              <?= $row_do['add_group_name']; ?>
                            </td>
                            <td>
                              <?= $row['campaign_call_route']; ?>
                            </td>
                            <td>
                              <?php
                                foreach(unserialize($row['campaign_route_numbers']) as $num)
                                {
                                    echo "+".$num."<br>";
                                }
                              ?>
                            </td>
                            <td>
                              <?=date("l jS \of F Y h:i:s A",strtotime($row['createdon']))?>
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