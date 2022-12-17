<?php
include "connect.php";
$query = 'SELECT brandid FROM brand';
$data = mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($data)) {
	$x[]=($row);
}
foreach ($x as $key => $value) {
	$query = 'SELECT brandid,brandname,(SELECT COUNT(id) FROM shoes WHERE shoes.brandid = '.$value["brandid"].') AS count FROM brand WHERE brandid = '.$value["brandid"].'';
		$data = mysqli_query($conn, $query);
		$result = array();
		while ($row = mysqli_fetch_assoc($data)) {
		 	$a[] = ($row);
		}
		$result=$a;
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