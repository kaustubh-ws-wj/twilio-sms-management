<?php
require_once ("connection.php");
require_once ("pagination.class.php");
$perPage = new PerPage();

$sql = "SELECT * from numbers ORDER BY numbers_id DESC";
$paginationlink = "getresult.php?page=";
$pagination_setting = $_GET["pagination_setting"];

$page = 1;
if (!empty($_GET["page"]))
{
    $page = $_GET["page"];
}

$start = ($page - 1) * $perPage->perpage;
if ($start < 0) $start = 0;

$query = $sql . " limit " . $start . "," . $perPage->perpage;
$numbers = runQuery($query);

if (empty($_GET["rowcount"]))
{
    $_GET["rowcount"] = numRows($sql);
}

if ($pagination_setting == "prev-next")
{
    $perpageresult = $perPage->getPrevNext($_GET["rowcount"], $paginationlink, $pagination_setting);
}
else
{
    $perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink, $pagination_setting);
}

$output = '';
$i = 1;
foreach ($numbers as $k => $v)
{ ?>
<input type="hidden" id="rowcount" name="rowcount" value="<?=$_GET['rowcount'] ?>" />
<a class="nav-link" id="user-<?=$numbers[$k]['numbers_id'] ?>-tab" data-toggle="pill" href="#user-<?=$numbers[$k]['numbers_id'] ?>" role="tab" aria-controls="user-<?=$numbers[$k]['numbers_id'] ?>" aria-selected="true" onClick="getMessages(<?= $numbers[$k]['numbers_id'] ?>);">
    <span class="d-flex">
        <span class="profile-picture">
            <img src="assets/img/sample_p.jpg" alt="Profile Picture">    
        </span>
        <span class="message-highlight">
            <span class="user-name"><?=$numbers[$k]['numbers_first_name'] . ' ' . $numbers[$k]['numbers_last_name'] ?></span>
            <span class="last-m"><?= $numbers[$k]['numbers_phone_number'] ?></span>
        </span>
    </span>
    <span class="m-time">4:52 pm</span>
</a>
<?php $i++;
}
if (!empty($perpageresult))
{
    $output .= '<div id="pagination">' . $perpageresult . '</div>';
}
print $output;

// GET DATA FROM DB functions START
function runQuery($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result))
    {
        $resultset[] = $row;
    }
    if (!empty($resultset)) return $resultset;
}

function numRows($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    $rowcount = mysqli_num_rows($result);
    return $rowcount;
}
// GET DATA FROM DB functions END
?>
