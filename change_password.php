<?php
   $title = "Change Password";
   include 'inc/head.php';
   include 'connection.php';
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
                           
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header">
											<h5 class="title">Change Password</h5> </div>
										<div class="card-body">
                                     
											<form method="POST" action="do_changepassword.php">
                                            <div class="col-md-3">
                                            <?php
                                                if (isset($_SESSION["message"]) && !empty($_SESSION["message"]) && $_SESSION["message"] == 'success') {
                                                ?>
                                                    <h6 class="text-success">Password Changed Successfully...</h6>
                                                    <?php
                                                
                                                    }elseif(isset($_SESSION["message"]) && !empty($_SESSION["message"]) && $_SESSION["message"] == 'errornotmatch'){ ?>
                                                    <h6 class="text-danger">Current password does not matched...</h6>
                                                    <?php  }elseif(isset($_SESSION["message"]) && !empty($_SESSION["message"]) && $_SESSION["message"] == 'errornotmatchcnf'){ ?>
                                                        <h6 class="text-danger">Confirm password does not matched with new password...</h6>
                                                    <?php }
                                                    unset($_SESSION['message']);
                                                    ?>
                                                </div>
												<div class="col-md-3">
													<label>Current Password</label>
													<div class="form-group">
														<input type="password" class="form-control" name="current_password" placeholder="Current Password" required> </div>
												</div>
												<div class="col-md-3">
													<label>New Password</label>
													<div class="form-group">
														<input type="password" class="form-control" name="new_password" placeholder="New Password" required> </div>
												</div>
												<div class="col-md-3">
													<label>Confirm Password</label>
													<div class="form-group">
														<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required> </div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<button type="Submit" class="btn btn-fill btn-primary">Save</button>
														<a type="Submit" class="btn btn-fill btn-default" href="dashboard.php">Cancel</a>
													</div>
												</div>
											</form>
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
			<script type="text/javascript">
			var table = $('#datatable').DataTable();
			</script>