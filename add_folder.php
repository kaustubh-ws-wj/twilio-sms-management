<?php
  $title = "Add Folder";
  include 'inc/head.php';
  include 'connection.php';
  $query_get_group_count= "SELECT * FROM folder";
  $result_get_group_count = mysqli_query($connect,$query_get_group_count);
  $group_count = mysqli_num_rows($result_get_group_count);
  
  if(isset($_GET['fid']) && $_GET['fid'] != ''){
    $query_get_one_folder = "SELECT * FROM folder where folder_id = {$_GET['fid']}";
    $result_get_one_folder = mysqli_query($connect,$query_get_one_folder);
    $result_get_one_folder = mysqli_fetch_array($result_get_one_folder);
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
          $page_name = "Add Folder";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">Folder Added Sccessfully</h1>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Something went Wrong</h1>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 3) {
            ?>
                <h1 class="text-center color_green">Folder Deleted Sccessfully</h1>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 4) {
            ?>
                <h1 class="text-center color_green">Folder Updated Sccessfully</h1>
            <?php
              }
            ?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <?php
                    if(isset($_GET['fid']) && !empty($_GET['fid'])){
                ?>  
                    <form action="update_folder.php" method="post">
                <?php
                    }
                    else{
                ?>
                    <form action="insert_folder.php" method="post">
                <?php
                    }
                  ?>    
                  
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Enter Folder Name</h4>
                      <div class="form-group form-file-upload form-file-simple">
                        <input type="text" class="form-control" name="folder_name" value="<?=@$result_get_one_folder['folder_name']?>" required="">
                        <input type="hidden" class="form-control" name="folder_id" value="<?=@$result_get_one_folder['folder_id']?>">
                      </div>
                      <div class="form-group form-file-upload form-file-multiple">
                        <input type="submit" value="Submit" class="btn btn-warning">
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
          <?php
            if(!isset($_GET['fid']) && empty($_GET['fid']))
            {
          ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> All Folders</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-shopping">
                      <thead class="">
                        <th  class="text-center" ></th>
                        <th >ID</th>
                        <th >Name</th>
                        <th >Action</th>
                      </thead>
                      <tbody>
                      <?php 
                        while($row=mysqli_fetch_assoc($result_get_group_count)) {
                      ?>
                          <tr>
                            <td></td>
                            <td><?= $row['folder_id']; ?></td>
                            <td><?= $row['folder_name']; ?></td>
                            <td><a href="add_folder.php?fid=<?= $row['folder_id']; ?>" class="btn btn-info"> Edit</a> <a href="delete_folder.php?fid=<?= $row['folder_id']; ?>" class="btn btn-info"> Delete</a></td>
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
            ?>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
    <?php
      include 'inc/footer.php';
    ?>