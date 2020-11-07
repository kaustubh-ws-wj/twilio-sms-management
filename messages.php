<link href="assets/css/conversation.css" rel="stylesheet" />
<?php
    $title = "Messages";
    include 'inc/head.php';
    require 'vendor/autoload.php';
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
          $page_name = "Messages";
          include 'inc/nav.php';
        ?>
        <!-- End Navbar -->
        <div class="content">
          <div class="tl-section">
            <div class="tl-dashboard bg-color">
                <div class="container-fluid p-0">
                     <div class="main">
                        <div class="messages bg-white row">
                            <div class="messages-sidebar col-md-5 col-lg-3 p-0">
                                <div class="messages-sidebar-header d-flex justify-content-between">
                                    <div class="profile-picture">
                                        <img src="assets/img/sample_p.jpg" alt="Profile Picture">
                                    </div>
                                    <div class="search-box">
                                        <form action="#" class="search-form">
                                            <input type="search" class="search-field" placeholder="Search">
                                            <input type="submit" class="search-submit" value="Search">
                                        </form>
                                    </div>
                                </div>
                                <div class="messages-sidebar-body">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                       <!-- Dynamic user list Start-->
                                       <div id="overlay"><div>
                                        <img src="assets/img/loading.gif" width="35px" height="35px"/></div></div>
                                        <div class="page-content">
                                            <div id="pagination-result">
                                                <input type="hidden" name="rowcount" id="rowcount" />
                                            </div>
                                        </div>
                                       <!-- Dynamic user list End-->
                                    </div>
                                </div>
                            </div><!-- messages-sidebar -->

                            <div class="messages-content col-md-7 col-lg-9 p-0">
                                <span id="resultHtml"></span>
                            </div>                            
                        </div><!-- messages -->
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
<script>
    function getresult(url) {
        $.ajax({
            url: url,
            type: "GET",
            data: {
                rowcount: $("#rowcount").val(),
                "pagination_setting": "prev-next"
            },
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (data) {
                $("#pagination-result").html(data);
                setInterval(function () {
                    $("#overlay").hide();
                }, 500);
            },
            error: function () {}
        });
    }

    function changePagination(option) {
        if (option != "") {
            getresult("getresult.php");
        }
    }
    getresult("getresult.php");
</script>
<script>
    function getMessages(id,con_sid,part_sid) {
        $(".nav-link").removeClass("active");
        $(this).addClass("active");  
        
        var profileHeader = '';
        var messageBody = '';
        var conversation_sid = con_sid;
        var participant_sid = part_sid;
        

        $.ajax({
            url: "getapidata.php",
            type: "POST",
            data: {"id": id,'conversation_sid':conversation_sid,'participant_sid':participant_sid},
            beforeSend: function() {
                $("#overlay").show();
            },
            success: function(data) {
                $("#resultHtml").html(data);
                setInterval(function() {
                    $("#overlay").hide();
                }, 500);
            },
            error: function() {}
        });
    }
    // Send Message to selected list
    function sendMessage(conversation_sid,identity) {
        alert();
        var body = $("#body").val();
        if(body == ''){
            alert('No Message body');
        }
        $.ajax({
            type: 'POST',
            url:  'create_conv_message.php',
            data: {"conversation_sid":conversation_sid,"identity":identity,"body":body},
            success: function (data) {
                alert(data);
                $('a.nav-link active').trigger("click");
            }
        });
    }
    $('form#send').on('focus',function(){
        alert();
    });
</script>