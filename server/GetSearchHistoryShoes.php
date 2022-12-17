
<?php
include "connect.php";
$accountid=$_POST['accountid'];
$query = 'SELECT searchhistory.keyword FROM searchhistory WHERE searchhistory.accountid ='.$accountid.'';
$data = mysqli_query($conn, $query);
 $result1 = array();
while ($row = mysqli_fetch_assoc($data)) {
	 $result1[] = ($row);
}
if (!empty($result1)) {
	$arr1 = [
		'success' => true,
		'message' => "Thanh cong",
		'result1' => $result1
	];
	$json_string = json_encode($arr1);
 	$data = json_decode($json_string, true);
	foreach ($data['result1'] as $value) {
	$keyword= $value['keyword'];
	}
	$query = "SELECT shoes.*, saledetails.salesprice , sales.startday, sales.endday from shoes LEFT JOIN saledetails ON shoes.id = saledetails.id LEFT JOIN sales on sales.salesid=saledetails.salesid WHERE shoes.name like '%$keyword%' GROUP BY shoes.id";
	$data = mysqli_query($conn, $query);
	$result = array();
	while ($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
	}

	if (!empty($result)) {
		$arr = [
			'success' => true,
			'message' => "Thanh cong nek",
			'result' => $result
		];
	}else{
		$arr = [
			'success' => false,
			'message' => "khong thanh cong roi",
			'result' => $result
		];
	}


}else{
	$arr1 = [
		'success' => false,
		'message' => "khong thanh cong",
		'result' => $result
	];
	

}
print_r(json_encode($arr));
?>