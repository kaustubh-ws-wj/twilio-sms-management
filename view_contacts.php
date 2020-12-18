<?php
  $title = "Edit Contact";
  include 'inc/head.php';
  include 'connection.php';
  if (isset($_GET['group']) && !empty($_GET['group'])) {
    //$query = "SELECT * FROM numbers where numbers_group_id = {$_GET['group']}";
    $query = "SELECT * FROM contact_list where group_id = {$_GET['group']}";
  }
  else{
    $query = "SELECT * FROM contact_list";
  }
  $result = mysqli_query($connect, $query);
  
  $query_g = "SELECT * FROM add_group";
  $result_g = mysqli_query($connect, $query_g);
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
          $page_name = "View Contacts";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
            <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">List Deleted Sccessfully</h1>
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
            <h4 class="card-title">Search By Group</h4>
              <form>
                <div class="row">
                <div class="col-md-6">
                  <select class="form-control" name="group" required="">
                    <option value=''>Select</option>
                    <?php while($row_g=mysqli_fetch_assoc($result_g)) {  ?>
                      <option <?=(isset($_GET['group']) && !empty($_GET['group']) && $_GET['group'] == $row_g['add_group_id']) ? 'selected' : ''?> value="<?= $row_g['add_group_id']; ?>"><?= $row_g['add_group_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6 btn_up">
                  <input type="submit" value="Search" class="btn btn-info">
                </div>
                </div>
            </form>
          </div>
          <div class="card-body">
            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>List Name</th>
                  <th>Recipients</th>
                  <th>Mapping</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>List Name</th>
                  <th>Recipients</th>
                  <th>Mapping</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                <?php 
                  // echo '<pre>';
                  // print_r($row);
                  // echo '</pre>';
                  // $query_do = "SELECT list_name,list_path,recipients,mapping_status,status, id FROM contact_list";
                  // echo $query_do;
                  // $result_do = mysqli_query($connect, $query_do);
                  while($result_do = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td><?=$result_do['list_name']?></td>
                    <td><?=$result_do['recipients']?></td>
                    <td><?=$result_do['mapping_status']?></td>
                    <td><?=$result_do['status']?></td>
                    <td><a href="edit_contact.php?id=<?= $result_do['id']; ?>" class="btn btn-info"> Edit</a> <a href="delete_contact.php?id=<?= $result_do['id']; ?>" class="btn btn-danger"> Delete</a></td>
                  </tr>
                <?php } ?>
                
              </tbody>
            </table>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      <!-- end col-md-12 -->
    </div>
    <!-- end row -->
  </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
    <?php
      include 'inc/footer.php';
    ?>

    <script type="text/javascript">
      var table = $('#datatable').DataTable();
    </script>