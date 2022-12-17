<?php
 include "connect.php";

$keyword = $_POST['keyword'];
$accountid= $_POST['accountid'];

// check data

$query = "SELECT * FROM `searchhistory` WHERE searchhistory.accountid = '$accountid'";
$data = mysqli_query($conn, $query);
$numrow = mysqli_num_rows($data);

if($numrow >  0) {
	$query2 = 'UPDATE `searchhistory` SET `keyword` = "'.$keyword.'" WHERE `searchhistory`.`accountid` = "'.$accountid.'"';

	$data = mysqli_query($conn, $query2);
	if ($data == true) {
		$arr = [
			'success' => true,
			'message'=> "cap nhat thanh cong nek",
			'result'=> []
		];
	}else{
		$arr = [
			'success' => false,
			'message' => " khong thanh cong",
			'result'=> []
		];
	}	
 }
 else{
	//INSERT INTO `searchhistory` (`accountid`, `keyword`) VALUES ('1', 'nike');
	$query1 = 'INSERT INTO `searchhistory`(`accountid`, `keyword`) VALUES ("'.$accountid.'","'.$keyword.'")';
	//$query = 'INSERT INTO `account`(`accountid`, `username`, `password`, `rolesid`) VALUES (null,"'.$user.'","'.$pass.'",3)';

	$data = mysqli_query($conn, $query1);
	if ($data == true) {
		$arr = [
			'success' => true,
			'message'=> "them thanh cong ",
			'result'=> []
		];
	}else{
		$arr = [
			'success' => false,
			'message' => " khong thanh cong",
			'result'=> []
		];
	}	
}

//insert


print_r(json_encode($arr));




// $query = 'SELECT * FROM shoes WHERE shoes.brandid IN(SELECT brand.brandid from brand  WHERE brand.brandid=1)';
// // $query = "SELECT * FROM `shoes` WHERE shoes.new= true";
// $data = mysqli_query($conn, $query);
// $result = array();
// while ($row = mysqli_fetch_assoc($data)) {
// 	 $result[] = ($row);
// }
// // print_r($result);
// if (!empty($result)) {
// 	$arr = [
// 		'success' => true,
// 		'message' => "Thanh cong",
// 		'result' => $result
// 	];
// }else{
// 	$arr = [
// 		'success' => false,
// 		'message' => "khong thanh cong",
// 		'result' => $result
// 	];
// }

// print_r(json_encode($arr));

 
?>