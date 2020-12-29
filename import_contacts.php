<?php
  $title = "Import Contacts";
  include 'inc/head.php';
  include 'connection.php';
  $query = "SELECT * FROM add_group";
  $result = mysqli_query($connect, $query);


  if (isset($_GET['group']) && !empty($_GET['group'])) {
    //$query = "SELECT * FROM numbers where numbers_group_id = {$_GET['group']}";
    $query = "SELECT * FROM contact_list where group_id = {$_GET['group']}";
  }
  else{
    $query = "SELECT * FROM contact_list";
  }
  $result_list = mysqli_query($connect, $query);
  
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
          $page_name = "Import Contacts";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
              <h6 class="text-center color_green">Something went wrong</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
              <h6 class="text-center color_red">Group Added Successfully</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
              <h6 class="text-center color_green">Data Imported Sccessfully</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 3) {
            ?>
              <h6 class="text-center color_red">File Type not supported.</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 4) {
            ?>
              <h6 class="text-center color_red">File Uploaded but file dont have any records.</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 5) {
            ?>
              <h6 class="text-center color_red">Data mapped Sccessfully.</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 6) {
            ?>
              <h6 class="text-center color_green">Fields not mapped successfully.</h6>
            <?php
              }else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 7) {
            ?>
              <h6 class="text-center color_red">List Deleted Sccessfully</h6>
            <?php
              }
            ?>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header ">
                    <h4 class="card-title">Import Contact List</h4>
                </div>
                <div class="card-body">
                  <form action="import_data.php" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                  <!-- <div class="row"> -->
                    <div class="row">
                      <div class="col-md-8">
                        
                        <!-- <div class="form-group">
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
                        </div> -->
                        <label>Choose Contact CSV File to Import</label>
                        <div class="form-group has-label form-file-upload form-file-simple">
                            <input type="text" class="form-control inputFileVisible" placeholder="Choose Your Contact File">
                            <input type="file" name="file" id="file" accept=".xls,.xlsx,.csv" required="" class="inputFileHidden" style="z-index: -1;">
                        </div>
                        <div class="form-group">
                          <!-- <button type="submit" value="Import" class="btn btn-info btn-sm">Import <i class="now-ui-icons arrows-1_cloud-upload-94"></i></button> -->
                          <a class="btn btn-neutral btn-behance btn-sm pull-right" href="excel_upload/sample_file.csv" download>Download Sample File <i class="now-ui-icons arrows-1_cloud-download-93"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                        <!-- <div class="row"> -->
                        <!-- <div class="col-md-6"> -->
                          <label>Select Contact Group</label>
                          <!-- <label>Select Contact Group</label> -->
                        <!-- </div> -->
                        <!-- <div class="col-md-6 ">
                          <button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#myModal">Add Group <i class="now-ui-icons ui-1_simple-add"></i></button>
                        </div>   -->
                        <!-- </div> -->
                        <div class="form-group">
                          <select class="form-control" name="group" required="">
                          <option value="">--Select Group--</option>
                            <?php while($row=mysqli_fetch_assoc($result)) { ?>
                              <option value="<?= $row['add_group_id']; ?>"><?= $row['add_group_name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group form-file-upload form-file-multiple">
                          <!-- <button type="submit" value="Import" class="btn btn-info btn-sm">Import <i class="now-ui-icons arrows-1_cloud-upload-94"></i></button> -->
                          <button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#myModal">Add Group <i class="now-ui-icons ui-1_simple-add"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <button type="submit" value="Import" class="btn btn-primary">Import <i class="now-ui-icons arrows-1_cloud-upload-94"></i></button>
                          <!-- <a class="btn btn-danger btn-sm pull-right" href="excel_upload/sample_file.csv" download>Download Sample File <i class="now-ui-icons arrows-1_cloud-download-93"></i></a> -->
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->
                  </form>
                </div>
              </div>
              <!-- end card -->
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header ">
                    <h4 class="card-title">Add Group</h4>
                </div>
                <div class="card-body">
                  <form action="insert_group.php" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="card-title">Enter Group Name</label>
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
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-10">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Search By Group</h4>
                    <form>
                      <div class="row">
                      <div class="col-md-4">
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
                        while($result_do = mysqli_fetch_assoc($result_list)) {
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
          
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
    <!-- Classic Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header justify-content-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="now-ui-icons ui-1_simple-remove"></i></button>
            <h6 class="title title-up">Add Group</h6>
          </div>
          <div class="modal-body">
              <form action="insert_group.php" method="post">
                <div class="col-md-6">
                  <label class="card-title">Group Name</label>
                  <div class="form-group form-file-upload form-file-simple">
                    <input type="text" class="form-control" name="group_name" required="">
                  </div>
                  <!-- <div class="form-group form-file-upload form-file-multiple">
                    <input type="submit" value="Add" class="btn btn-warning">
                  </div> -->
                </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="group_submit" class="btn btn-default" value="Submit">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--  End Modal -->
    <?php
      include 'inc/footer.php';
    ?>
    <script type="text/javascript">
      var table = $('#datatable').DataTable();
   </script>