<?php
   $title = "User Profile";
   include 'inc/head.php';
   include 'connection.php';
   if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
      $query = "SELECT * FROM signup where id = {$_SESSION['user_id']}";
   }
   $result = mysqli_query($connect, $query);
   $row = mysqli_fetch_assoc($result);
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
         <!-- End Navbarr -->
         <div class="content">
            <div class="show_status">
              
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card card-user">
                     <div class="card-header">
                        <!--<div class="image">
                           <img src="../../assets/img/bg5.jpg" alt="...">
                           </div>--> 
                        <!-- <div class="author col-md-6">
                           <a href="#">
                           <img class="avatar border-gray" src="../../assets/img/mike.jpg" alt="...">
                           </div> -->
                        <h5 class="title">User Profile</h5>
                        </a>
                        <p><?= $row['first_name']." ".$row['last_name']; ?></p>
                        <p class="descriptionr">
                            <?= $row['email']; ?>
                        </p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Update Auth</button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">
                        <h5 class="title">User Profile</h5>
                     </div>
                     <div class="card-body">
                        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                        <?php
                            if (isset($_SESSION["message"]) && !empty($_SESSION["message"]) && $_SESSION["message"] == 'success') {
                            ?>
                        <h6 class="text-success">Profile Updated Successfully...</h6>
                        <?php
                            unset($_SESSION['message']);
                            }
                            ?>
                           <div class="row">
                              <div class="col-md-4 pr-1">
                                 <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name"  placeholder="First Name" value="<?= $row['first_name'] ?>" required>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 pr-1">
                                 <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name"  value="<?= $row['last_name'] ?>" required>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $row['email'] ?>" required>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Notification Email</label>
                                    <input type="email" class="form-control" name="notification_email" placeholder="Notification Email" value="<?= $row['notification_email'] ?>" required>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleInputPhone">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_number" value="<?= $row['phone_number'] ?>" required>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Default Folder</label><br>
                                    <select id="folder" name="default_folder" class="form-control" required>
                                        <option value="">Select Default Folder</option>
                                        <?php 
                                            $sql_folder = "SELECT * FROM folder";
                                            $result_folder = mysqli_query($connect, $sql_folder);
                                            while($row_folder = mysqli_fetch_assoc($result_folder)){
                                        ?>
                                        <option <?= ($row['default_folder'] == $row_folder['folder_id'] ) ? 'selected':''; ?> value="<?= $row_folder['folder_id'] ?>"><?= $row_folder['folder_name'] ?></option>
                                        <?php }?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <!-- <input  type="checkbox" id="check1" name="check1" <?= ($row['is_send'] == 1) ? 'checked':''; ?> >
                                    <label for="check1">Use enter to send new message when using messenger</label> -->
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="is_send" name="is_send" <?= ($row['is_send'] == 1) ? 'checked':''; ?>>
                                            <span class="form-check-sign"></span>
                                            Use enter to send new message when using messenger
                                        </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <button type="Submit" class="btn btn-fill btn-primary">Save</button>
                                    <a type="Submit" class="btn btn-fill btn-default" href="dashboard.php">Cancel</a>
                                 </div>
                              </div>
                           </div>
                     </div>
                     <!-- Anu -->
                     </form>
                  </div>
               </div>
            </div>
            <!-- end row -->
         </div>
      </div>
   </div>
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Update Auth Token</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form action="individual-functions.php" method="post">
               <div class="modal-body">
                  <input type="text" name="authid" id="authid">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
               </div>
            </form>
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