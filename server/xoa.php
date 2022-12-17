<?php
include "Connect.php";
$id = $_POST['id'];
 $query = "DELETE FROM `shoes` WHERE id= '$id'";

$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	 $result[] = ($row);
}
// print_r($result);
if (!empty($result)) {
	$arr = [
		'success' => true,
		'message' => "Xóa thành công",
		'result' => $result
	];
}else{
	$arr = [
		'success' => false,
		'message' => "Xóa không thành công",
		'result' => $result
	];
}

print_r(json_encode($arr));
?>