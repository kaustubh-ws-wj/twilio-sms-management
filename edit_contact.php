<?php
  $title = "Edit Contact";
  include 'inc/head.php';
  include 'connection.php';
  include 'PHPExcel-1.8/Classes/PHPExcel.php';
  if (isset($_GET['id']) && !empty($_GET['id'])) { 
    $query = "SELECT * FROM contact_list WHERE id = ".$_GET['id'];
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    
    $description = $row['description'];
    $phone_field = $row['phone'];
    $first_name_field = $row['first_name'];
    $last_name_field = $row['last_name'];
    $email_field = $row['email'];
    $address_field = $row['address'];

    // Read Excel File Columns Name Start
    $inputFileName = $row['list_path'];
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        $message = ('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

    $cellIterator = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    // $rows = $objPHPExcel->getActiveSheet()->getRowIterator(1)->current();
    // $cellIterator = $rows->getCellIterator();
    // $cellIterator->setIterateOnlyExistingCells(false);
    $data;

    foreach($cellIterator as $key => $cell) {
      if($key == 1){
        $data = $cell;
      }
    }
  }
  

// Read Excel File Columns Name End
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
          $page_name = "Edit Contact".' " '.$row['list_name'].' " ';
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="show_status">
            <?php
              if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
            ?>
                <h1 class="text-center color_green">Data mapped Sccessfully.</h1>
            <?php
              }
              else if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 2) {
            ?>
                <h1 class="text-center color_red">Something went wrong.</h1>
            <?php
              }
              else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
            ?>
                <h1 class="text-center color_red">Fields not mapped successfully.</h1>
            <?php
              }
            ?>

          </div>
<!------------------------------------------bhagyashree---------------------------------------------- -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form action="mapping_fields.php" method="post" name="mapping_csv" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <label class="">File name</label>
                          <input type="hidden" class="form-control" name="list_id" value="<?= $_GET['id']; ?>">
                          <input type="text" class="form-control" name="file_name" value="<?= $row['list_name']; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group form-file-upload form-file-simple">
                          <label class="">Receipants</label>
                          <input type="text" class="form-control" name="receipents" value="<?= $row['recipients'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label class="">Description</label>
                        <textarea rows="6" title="Data List Description" placeholder="Data List Description" name="description" class="form-control"><?php echo $description; ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <h4 class="card-title">Field Mapping</h4>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="text" class="form-control" required="" name="phone_field" value="Phone" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <select class="form-control" name="phone_field_value" required="">
                              <option value="--NONE--" selected>--NONE--</option>
                              <?php foreach($data as $key => $val){ ?>
                                  <option value="<?= $key ?>" <?php if($key == $phone_field){ echo 'selected'; } ?>><?= $val; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="text" class="form-control" required="" name="first_name_filed" value="First_name" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <select class="form-control" name="first_name_field_value" required="">
                            <option value="--NONE--" selected>--NONE--</option>
                            <?php foreach($data as $key => $val){ ?>
                                <option value="<?= $key ?>" <?php if($key == $first_name_field){ echo 'selected'; } ?>><?= $val; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="text" class="form-control" required="" name="last_name_filed" value="Last_name" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <select class="form-control" name="last_name_field_value" required="">
                            <option value="--NONE--" selected>--NONE--</option>
                            <?php foreach($data as $key => $val){ ?>
                                <option value="<?= $key ?>" <?php if($key == $last_name_field){ echo 'selected'; } ?>><?= $val; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="text" class="form-control" required="" name="email_field" value="Email" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <select class="form-control" name="email_field_value" required="">
                            <option value="--NONE--" selected>--NONE--</option>
                            <?php foreach($data as $key => $val){ ?>
                                <option value="<?= $key ?>" <?php if($key == $email_field){ echo 'selected'; } ?>><?= $val; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <input type="text" class="form-control" required="" name="address_field" value="Address" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-file-upload form-file-simple">
                          <select class="form-control" name="address_field_value" required="">
                            <option value="--NONE--" selected>--NONE--</option>
                            <?php foreach($data as $key => $val){ ?>
                                <option value="<?= $key ?>" <?php if($key == $address_field){ echo 'selected'; } ?>><?= $val; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-1">
                        <div class="form-group form-file-upload form-file-multiple">
                          <input type="submit" value="Save changes" class="btn btn-warning">
                        </div>
                      </div>
                      <div class="col-6 col-md-1">
                        <div class="form-group form-file-upload form-file-multiple">
                          <a href="import_contacts.php" class="btn btn-dark">back</a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- end card -->
            </div>
          </div>
          <!------ /bhagyashree ----------->
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <!--   Core JS Files   -->
    <?php
      include 'inc/footer.php';
    ?>