<div class="sidebar" data-color="orange">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
          -->
        <div class="logo">
          <a href="#" class="simple-text logo-mini">STS</a>
          <a href="#" class="simple-text logo-normal">Simple Text Solutions</a>
          <div class="navbar-minimize">
            <!-- <button id="minimizeSidebar" class="btn btn-outline-white btn-icon btn-round">
            <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
            <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
            </button> -->
          </div>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
          <div class="user">
            <div class="photo" style="visibility:hidden;"></div>
            <div class="info">
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){ 
                    $user_details_query = "SELECT first_name,last_name FROM signup WHERE id={$_SESSION['user_id']}";
                    $user_details_exe = mysqli_query($connect,$user_details_query);
                    $user_details = mysqli_fetch_all($user_details_exe,MYSQLI_ASSOC);
                    $first_name = $user_details[0]['first_name'];
                    $last_name = $user_details[0]['last_name'];
                
                    ?>
              <a><span><?php echo $first_name.' '. $last_name ?></span></a>
              <div class="clearfix"></div>
              <?php } ?>
            </div>
          </div>
          <ul class="nav">
            <li  class="active" >
              <a href="dashboard.php">
                <i class="now-ui-icons design_palette"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li>  
                <a data-toggle="collapse" href="#mapsExamples" >
                    <i class="now-ui-icons business_badge"></i><p>Phone Management <b class="caret"></b></p>
                </a>

                <div class="collapse " id="mapsExamples">
                    <ul class="nav">
                    
                        <li >
                            <a href="search_phone_number.php">
                                <span class="sidebar-mini-icon">SPN</span>
                                <span class="sidebar-normal"> Search Phone Number </span>
                            </a>
                        </li>
                    
                        <!-- <li >
                            <a href="purchase_number.php">
                                <span class="sidebar-mini-icon">BPN</span>
                                <span class="sidebar-normal"> Buy Phone Number </span>
                            </a>
                        </li> -->
                        
                        <li >
                            <a href="list_all_numbers.php">
                                <span class="sidebar-mini-icon">PPN</span>
                                <span class="sidebar-normal"> Purchased Phone Numbers </span>
                            </a>
                        </li>
                        <li >
                            <a href="call_routes_listing.php">
                                <span class="sidebar-mini-icon">CRG</span>
                                <span class="sidebar-normal"> Call Route / Group </span>
                            </a>
                        </li>
                    
                    </ul>
                </div>
            </li>
            <li>  
                <a data-toggle="collapse" href="#supression" >
                    <i class="now-ui-icons design_vector"></i>
                    <p>Suppression<b class="caret"></b></p>
                </a>

                <div class="collapse " id="supression">
                    <ul class="nav">
                        <li>
                            <a href="add_suppression.php">
                                <span class="sidebar-mini-icon">SUP</span>
                                <span class="sidebar-normal"> Add Supression </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!--<li >-->
                <!--      <a data-toggle="collapse" href="#mapsExampless" >-->
                        
                <!--          <i class="now-ui-icons objects_globe"></i>-->
                        
                <!--          <p>-->
                <!--            Campign Management <b class="caret"></b>-->
                <!--          </p>-->
                <!--      </a>-->

                <!--      <div class="collapse " id="mapsExampless">-->
                <!--          <ul class="nav">-->
                <!--            <li >-->
                <!--                <a href="send_message.php">-->
                <!--                    <span class="sidebar-mini-icon">SM</span>-->
                <!--                    <span class="sidebar-normal"> Messages </span>-->
                <!--                </a>-->
                <!--            </li>-->
                            
                <!--        </ul>-->
                <!--    </div>-->
            <!--</li>-->              
            <li>
                <a data-toggle="collapse" href="#mapsExamplesss" >
                    <i class="now-ui-icons files_single-copy-04"></i><p>Contact Management <b class="caret"></b></p>
                </a>

                <div class="collapse " id="mapsExamplesss">
                    <ul class="nav">
                    
                        <!-- <li >
                            <a href="add_group.php">
                                <span class="sidebar-mini-icon">AG</span>
                                <span class="sidebar-normal"> Add Group </span>
                            </a>
                        </li> -->
                    
                        <li >
                            <a href="import_contacts.php">
                                <span class="sidebar-mini-icon">IC</span>
                                <span class="sidebar-normal"> Import Contacts </span>
                            </a>
                        </li>
                        
                        <!-- <li >
                            <a href="view_contacts.php">
                                <span class="sidebar-mini-icon">VC</span>
                                <span class="sidebar-normal"> View Contacts </span>
                            </a>
                        </li> -->
                    
                    </ul>
                </div>

                
            </li>
            <li>
                <a data-toggle="collapse" href="#mapsExamplessss" >
                    <i class="now-ui-icons objects_spaceship"></i>
                    <p>Campaign Management <b class="caret"></b></p>
                </a>
                <div class="collapse " id="mapsExamplessss">
                    <ul class="nav">
                    
                        <li >
                            <a href="send_message.php">
                                <span class="sidebar-mini-icon">CC</span>
                                <span class="sidebar-normal"> Create Campaign </span>
                            </a>
                        </li>
                    
                        <li >
                            <a href="view_campaign.php">
                                <span class="sidebar-mini-icon">VC</span>
                                <span class="sidebar-normal"> View Campaigns </span>
                            </a>
                        </li>
                    
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#mapsExamplesssss" >
                    
                    <i class="now-ui-icons ui-2_chat-round"></i>
                    
                    <p>
                        Messages Management <b class="caret"></b>
                    </p>
                </a>

                <div class="collapse " id="mapsExamplesssss">
                    <ul class="nav">
                    
                        <li >
                            <a href="add_folder.php">
                                <span class="sidebar-mini-icon">CF</span>
                                <span class="sidebar-normal"> Create Folder </span>
                            </a>
                        </li>
                    
                        <li >
                            <a href="messages.php">
                                <span class="sidebar-mini-icon">MSG</span>
                                <span class="sidebar-normal"> Messages </span>
                            </a>
                        </li>

                        <li >
                            <a href="individual-messages.php">
                                <span class="sidebar-mini-icon">MSG</span>
                                <span class="sidebar-normal">  Individual message </span>
                            </a>
                        </li>
                    
                    </ul>
                </div>
            </li>
          </ul>
        </div>
      </div>