<?php
include "connect.php";
$sender = $_POST['sender'];
$result = array();
$query = 'SELECT MAX(mesid) as mesid,name, `sender`, `receiver` FROM `message` LEFT JOIN account ON accountid = sender WHERE receiver = '.$sender.' GROUP BY sender UNION SELECT MAX(mesid) as mesid,name, `sender`, `receiver` FROM `message` LEFT JOIN account ON accountid = receiver WHERE sender = '.$sender.' GROUP BY receiver ORDER BY mesid DESC';
$data = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($data)) {
	$query1 = 'SELECT `content`, `timestamp` FROM `message` WHERE mesid = '.$row["mesid"].'';
	$data1 = mysqli_query($conn, $query1);
	while ($row1 = mysqli_fetch_assoc($data1)) {
	 $a["content"] = ($row1["content"]);
	 $a["timestamp"] = ($row1["timestamp"]);
	}
	$row["content"] = $a["content"];
	$row["timestamp"] = $a["timestamp"];
	$result[] = ($row);
}
if (!empty($result)) {
	$arr = [
		'success' => true,
		'message' => "Thanh cong",
		'result' => $result
	];
}else{
	$arr = [
		'success' => false,
		'message' => "khong thanh cong",
		'result' => $result
	];
}
print_r(json_encode($arr));
?>