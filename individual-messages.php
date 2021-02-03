<?php
    include 'config.php';
    $title = "Individual Messages";
    include 'inc/head.php';
    include 'connection.php';
    require __DIR__ . '/vendor/autoload.php';

    $query = "SELECT * FROM call_routes GROUP by `call_routes_name`";
    $result = mysqli_query($connect, $query);

    $sql = "SELECT * FROM individual_messages";
    $data = mysqli_query($connect, $sql);
    
    use Twilio\Rest\Client;
    use Twilio\Exceptions\RestException;
    $twilio = new Client(ACCOUNT_SID, AUTH_TOKEN);

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
                $page_name = "Individual Messages";
                include 'inc/nav.php';
            ?>
            <div class="content">
                <div class="show_status">
                <?php
                    if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 1) {
                ?>
                    <h6 class="text-center color_green">Message has been send successfully</h6>
                <?php
                }
                    else if (isset($_GET['status']) && empty($_GET['status']) && $_GET['status'] == 0) {
                ?>
                    <h6 class="text-center color_red">Something went Wrong</h6>
                <?php
                }
                ?>               
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Send New</button>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> All Individual Message History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-shopping">
                                        <thead class="">
                                            <th  class="text-center" >#</th>
                                            <th >Message</th>
                                            <th >Revceiver Number</th>
                                            <th >Twilio Number</th>
                                            <th >Date</th>
                                            <th >Status</th>
                                        </thead>
                                        <tbody>
                                        <?php while($im = mysqli_fetch_assoc($data)){ ?>
                                        <tr>
                                            <td></td>
                                            <td><?= $im['msg_body'] ?></td>
                                            <td><?= $im['recipient_number'] ?></td>
                                            <td><?= $im['sender_number'] ?></td>
                                            <td><?= $im['date'] ?></td>
                                            <td><?= $im['status'] ?></td>
                                        <tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Individual Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="individual-functions.php" method="POST">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient Number</label>
                        <input type="text" class="form-control" name="recipient_number" id="recipient-name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Call Route Name</label>
                        <select class="form-control route_name" name="route_name" id="route_name" required>
                            <option value="0">-- Select --</option>
                            <?php while($row = mysqli_fetch_assoc($result)){ ?>
                                <option value="<?= $row['call_routes_name'] ?>"><?= $row['call_routes_name'] ?></option>
                            <?php } ?>                                
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Sender Number</label>
                        <select class="form-control" name="sender_number" id="sender_number" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" name="message" id="message-text" required></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary float-right" name="send_msg" value="Send">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    
    <?php
      include 'inc/footer.php';
    ?>
    
    <script>
        $(document).ready(function(){
            $('.route_name').on('change', function(){
                var routeName = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'individual-functions.php',
                    data: {"routeName":routeName},
                    success: function(data) {
                        $('#sender_number').html('');
                        var datas = $.parseJSON(data);
                        $.each(datas, function(index, value) {
                            $('#sender_number').append($("<option></option>").val(value.call_routes_number).text(value.call_routes_number));
                        }); 
                    }
                })
            });
        })
    </script>
</body>
