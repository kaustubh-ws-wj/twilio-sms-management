<?php 
require_once ("connection.php");
if(!empty($_POST['id'])){

	$sql    = "SELECT * from numbers WHERE numbers_id = ".$_POST['id'];
	$result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_assoc($result);

    $html = '<div class="messages-content-header">
                <div class="profile-info">
                    <div class="profile-picture">
                        <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                    </div>
                    <div class="user-info">
                        <span class="user-name">'.$row['numbers_first_name'].' '.$row['numbers_last_name'].'</span>
                        <span class="user-availability">Online</span>
                    </div>
                </div>
                <div class="user-options">
                    <ul class="global-list d-flex justify-content-between">
                        <li><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></li>
                    </ul>
                </div>    
            </div>';
    
    $html .='<div class="messages-content-body">
                <div class="tab-pane fade show active" id="user-one" role="tabpanel" aria-labelledby="user-one-tab">
                    <div class="single-message">
                        <div class="profile-picture">
                            <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                        </div>
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message self-message text-right">
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message">
                        <div class="profile-picture">
                            <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                        </div>
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message self-message text-right">
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message">
                        <div class="profile-picture">
                            <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                        </div>
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message self-message text-right">
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message">
                        <div class="profile-picture">
                            <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
                        </div>
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    <div class="single-message self-message text-right">
                        <div class="user-massage">
                            <span class="user-name">Jassia Deo</span>
                            <p><span class="color">It’s Great opportunity to work.</span></p>
                            <p><span class="color">Efficiently brand e-business intellectual capital before client-centered interfaces.</span></p>
                            <span class="m-time">8:00 am</span>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="send-message">
                <form action="#" class="lt-form">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Type Your Message">
                        <input type="button" value="Send">
                    </div>
                </form>
            </div>';

echo $html;
}?>

