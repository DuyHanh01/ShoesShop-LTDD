<?php
	include "connect.php";
	$name = $_POST['name'];
	$brandid = $_POST['brandid'];
	$id = $_POST['id'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$dateupdate = date_create()->format('Y-m-d H:i:s');
	$newsp = $_POST['new'];
	$images = $_POST['images'];
	$exist = $_POST['exist'];
	$arr = array();
	$query = 'UPDATE `shoes` SET `name`="'.$name.'",`dateupdate`="'.$dateupdate.'",`price`='.$price.',`images`="'.$images.'",`shoesnew`='.$newsp.',`categoryid`=1,`description`="'.$description.'",`brandid`='.$brandid.', `active`= '.$exist.' WHERE `id`='.$id.'';
	$data = mysqli_query($conn, $query);
	$query1 = 'SELECT ss.id, percent FROM `sales` s, `shoes` ss, `saledetails` sss WHERE s.salesid =sss.salesid AND ss.id = sss.id AND ss.id = '.$id.'';
		$data1 = mysqli_query($conn, $query1);
		while ($row = mysqli_fetch_assoc($data1)) {
             $m = ($row);
         }
         if(!empty($m)){
         	$query2 = 'UPDATE `saledetails` SET `salesprice`='.$price.' - '.$m["percent"].'*'.$price.'/100.0 WHERE id = '.$id.'';
    		$data2 = mysqli_query($conn, $query2);
    		if ($data2==true) {
			$arr = [
					'success' => true,
					'message' => "thanh cong"
				];
			}else{
				$arr = [
					'success' => false,
					'message' => "khong thanh cong"
				];
			}
         }
         else{
	         $arr = [
				'success' => true,
				'message'=> "thanh cong"
			];
         }
         print_r(json_encode($arr));
?>