<?php
include 'connection.php';

$query = "SELECT * FROM call_routes WHERE `call_routes_name` = '{$_POST['id']}'";
$result = mysqli_query($connect, $query);


if (mysqli_num_rows($result) > 0) {
	while($row=mysqli_fetch_assoc($result))
	{
      echo'<tr>';
        echo"<td><input checked type='checkbox' class='form-control' name='call_routes_id[]' value='{$row['call_routes_number']}'></td>";
        echo"<td>{$row['call_routes_name']}</td>";
        echo"<td>{$row['call_routes_number']}</td>";
        echo"<td>";
        if ($row['call_routes_status'] == 1){
            echo "Active";
        }else{
            echo "Inactive";
        }
      echo"</td>";
      echo"</tr>";
	                
	}
}
else{
	echo'<tr>';
	    echo"<td colspan='4' class='text-center'>No record found</td>";
	echo"</tr>";
}
?>