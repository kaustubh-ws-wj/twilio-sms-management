<?php
  $title = "Import Contacts";
  include 'inc/head.php';
  include 'connection.php';
  $query = "SELECT * FROM add_group";
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
          $page_name = "Import Contacts";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">Data Imported Sccessfully</h1>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h1 class="text-center color_red">No recoed found in the file</h1>
            <?php
              }else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Something went wrong</h1>
            <?php
              }else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 3) {
            ?>
              <h1 class="text-center color_red">File Type not supported.</h1>
            <?php
              } 
            ?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form action="import_data.php" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Select CSV</h4>
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div>
                          <span class="btn btn-rose btn-round btn-file">
                          <span class="fileinput-new">Select</span>
                          <span class="fileinput-exists">Change</span>
                          <input type="file" name="file" id="file" accept=".xls,.xlsx,.csv" required=""/>
                          </span>
                          <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <h4 class="card-title">Select Group</h4>
                      <div class="form-group form-file-upload form-file-simple">
                        <select class="form-control" name="group" required="">
                          <?php while($row=mysqli_fetch_assoc($result)) { ?>
                            <option value="<?= $row['add_group_id']; ?>"><?= $row['add_group_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group form-file-upload form-file-multiple">
                        <input type="submit" value="Import" class="btn btn-warning">
                      </div>
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