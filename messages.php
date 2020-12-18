<?php
    $title = "Messages";
    include 'inc/head.php';
    include 'connection.php';
    include 'config.php';
    require __DIR__ . '/vendor/autoload.php';
    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    use Twilio\TwiML\MessagingResponse;

    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);
    //load conversation
    /* try{
        $conversations = $twilio->conversations->v1->conversations->read(20);
    }catch(RestException $ex){
        header("Refresh:0; url=dashboard.php?error=".$ex->getMessage());
    } */
   
    $folder_query = "SELECT * FROM folder";
    $folder_query_result = mysqli_query($connect,$folder_query);

?>

  <body class=" sidebar-mini ">
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrapper ">
      <?php
        include 'inc/header.php';
      ?>
      <link href="assets/css/conversation.css" rel="stylesheet" />
      <link href="assets/css/conversationmenu.css" rel="stylesheet" />
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
                            <div class="side-navi col-12 col-sm-12 col-md-2 collapse show d-md-flex bg-dark pt-2 pl-0 p-0" id="sidebar" style="height:80vh;">
                                <ul class="nav flex-column flex-nowrap overflow-hidden">
                                    <!-- <li class="nav-item nav-item-arrow">
                                        <a class="nav-link text-truncate" href="#"><i class="fa fa-inbox fa-lg"></i> <span class="d-none d-sm-inline">Messages</span></a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link nav-item-arrow collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-folder fa-lg"></i> <span class="d-none d-sm-inline">Folders</span></a>
                                        <div class="collapsed sub_menu" id="submenu1" aria-expanded="false">
                                            <ul class="flex-column pl-2 nav folder_list">
                                                <li class="nav-item" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                    <a class="nav-link collapsed py-1 folder" data-num="0" data-name="Inbox" data-toggle="collapse" ><i class="fa fa-address-card" aria-hidden="true"></i><span>Inbox</span></a>
                                                </li>
                                                <?php while($folders = mysqli_fetch_assoc($folder_query_result)){ ?>
                                                <li class="nav-item" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                    <a class="nav-link collapsed py-1 folder" data-num="<?php echo $folders['folder_id']; ?>" data-name="<?php echo $folders['folder_name']; ?>" data-toggle="collapse" ><i class="fa fa-caret-right" aria-hidden="true"></i><span><?php echo $folders['folder_name'];?></span></a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="messages-sidebar col-md-3 col-lg-3 p-0">
                                <div class="messages-sidebar-header d-flex justify-content-between">
                                    <!-- <div class="profile-picture">
                                        <img src="assets/img/sample_p.jpg" alt="Profile Picture">
                                    </div> -->
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
                                        <div id="overlay" style="display:none;">
                                            <img src="assets/img/loading.gif" width="35px" height="35px"/>
                                        </div>
                                        <div class="page-content" id="conversation_list">
                                            <!-- <div id="pagination-result">
                                                <input type="hidden" name="rowcount" id="rowcount" />
                                            </div> -->

                                            <?php 
                                                /* if(!empty($conversations)){
                                                    foreach($conversations as $key => $value){  
                                                        $conversation_array = $value->toArray();
                                                        $conv_sid = $conversation_array['sid'];
                                                        $participant = $twilio->conversations->v1->conversations($conv_sid)->participants->read();
                                                        $from = $participant[0]->messagingBinding['address'];
                                                        $proxy_address = $participant[0]->messagingBinding['proxy_address'];
                                                        $txt_time = $participant[0]->dateUpdated->format('Y-m-d H:i');
                                                        $messages = $twilio->conversations->v1->conversations($conv_sid)->messages->read(1);
                                                        $last_msg = $messages[0]->body; */
                                            ?>
                                                        <!-- <a class="nav-link ui-widget-content" draggable="true" ondragstart="drag(event)" id="user-tab_<?php //echo $key; ?>" converstaionsid="<?php //echo $conv_sid;?>" data-toggle="pill" href="#" role="tab" aria-controls="user" onClick="getMessages('<?php //echo $conv_sid;?>','<?php //echo $proxy_address; ?>','<?php //echo $from; ?>')" aria-selected="true" >
                                                            <span class="d-flex">
                                                                <span class="message-highlight">
                                                                    <span class="user-name"><?php //echo $from; ?></span>
                                                                    <span class="last-m"><?php //echo $last_msg; ?></span>
                                                                </span>
                                                            </span>
                                                            <span class="m-time"><?php //echo $txt_time; ?></span>
                                                        </a> -->
                                            <?php
                                                    /* }
                                                }else{ */ 
                                            ?>
                                                        <!-- <a class="nav-link" data-toggle="pill" href="#" role="tab" aria-controls="user" aria-selected="true">
                                                            <span class="d-flex">
                                                                <span class="message-highlight">
                                                                    <span class="user-name">No Contacts Found</span> 
                                                                </span>
                                                            </span>
                                                        </a> -->
                                            <?php
                                                /* }  */
                                            ?>
                                            
                                        </div>
                                       <!-- Dynamic user list End-->
                                    </div>
                                </div>
                            </div><!-- messages-sidebar -->

                            <div class="messages-content col-md-7 col-lg-7 p-0">
                                <div id="overlay_m" style="display:none;">
                                    <img src="assets/img/loading.gif" width="35px" height="35px"/>
                                </div>
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
    
    $('.folder').on('click',function(){
        var folder = $(this).data('num');
        var folder_name = $(this).data('name');
        var list = "";
        $('.folder_list').css('pointer-events','none');
        //call conversation
        $.ajax({
            url: "conversation_listing.php",
            type:"POST",
            //dataType:'json',
            data:{'folder_name':folder_name},
            beforeSend: function () {
                $("#overlay").show();
            },
            success:function(response){
                var obj = JSON.parse(response);
                var obj_list = JSON.parse(obj.list);
                if(obj_list.length > 0){
                    $.each(obj_list,function(i){
                        list += "<a class='nav-link ui-widget-content' draggable='true' ondragstart='drag(event)' id='user-tab_"+i+"' converstaionsid='"+obj_list[i].conv_sid+"' data-toggle='pill' href='#' role='tab' aria-controls='user' onClick='getMessages(\""+obj_list[i].conv_sid+"\",\""+obj_list[i].proxy_address+"\",\""+obj_list[i].from+"\")' aria-selected='true' >"
                                +"<span class='d-flex'>"
                                    +"<span class='message-highlight'>"
                                        +"<span class='user-name'>"+obj_list[i].from+"</span>"
                                        +"<span class='last-m'>"+obj_list[i].last_msg+"</span>"
                                    +"</span>"
                                +"</span>"
                                +"<span class='m-time'>"+obj_list[i].txt_time+"</span>"
                            +"</a>";
                    });
                }else{
                        list = "<a class='nav-link' data-toggle='pill' href='#' role='tab' aria-controls='user' aria-selected='true'>"
                                +"<span class='d-flex'>"
                                    +"<span class='message-highlight'>"
                                        +"<span class='user-name'>No Contacts Found</span>"
                                    +"</span>"
                                +"</span>";
                }
                $('#conversation_list').html();
                $('#conversation_list').html(list);
                
            },complete:function(response){
                    $("#overlay").hide();
                    $('.folder_list').css('pointer-events','');
            }
        });
    });


    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("converstaionsid", ev.srcElement.attributes.converstaionsid.nodeValue);
        ev.dataTransfer.setData("text", ev.target.id);
        // console.log(ev.srcElement.attributes.converstaionsid.nodeValue);
    }

    function drop(ev) {
        ev.preventDefault();
        var conv_sid = ev.dataTransfer.getData("converstaionsid");
        var id = ev.dataTransfer.getData("text");
        var folder = ev.srcElement.innerText;
        $('#'+id).css('display','none');
        // do conversation updates
        $.ajax({
            url:'update_conv.php',
            type:'POST',
            data:{'conv_sid':conv_sid,'folder':folder},
            dataType:'JSON',
            success:function(response){
                // alert(response);
            }
        });
    }

    /* function getresult(url) {
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
                //$("#pagination-result").html(data);
                setInterval(function () {
                    $("#overlay").hide();
                }, 500);
            },
            error: function () {}
        });
    } */

    /* function changePagination(option) {
        if (option != "") {
            getresult("getresult.php");
        }
    } */
    //getresult("getresult.php");
</script>
<script>
    function getMessages(conv_sid,proxy_address,from_number) {
        $(".nav-link").removeClass("active");
        $(this).addClass("active");  
        
        var profileHeader = '';
        var messageBody = '';
        
        $.ajax({
            url: "getapidata.php",
            type: "POST",
            data: {'conversation_sid':conv_sid,'twilio_number':proxy_address,'from_number':from_number},
            beforeSend: function() {
                $("#overlay_m").show();
            },
            success: function(data) {
                $("#resultHtml").html(data);
            },
            error: function() {},
            complete:function(response){
                $("#overlay_m").hide();
            }
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
