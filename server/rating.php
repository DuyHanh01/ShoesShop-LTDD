<?php
	include "connect.php";

	$idshoes = $_POST['id'];
	$accid = $_POST['accountid'];
	$rates = $_POST['rate'];
	// $idshoes = 5;
	// $accid = 8;
	// $rates = 3.5;
	$query = 'SELECT * FROM rating WHERE id = '.$idshoes.' AND accountid ='.$accid.'';
	$data = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($data)) {
			$m = ($row);
		}
	if(!empty($m)) {
	    $query = 'UPDATE `rating` set rate = '.$rates.' WHERE id = '.$idshoes.' AND accountid = '.$accid.'';
	    $data = mysqli_query($conn, $query);
	    $query1 ='SELECT round(SUM(rate)/count(rate),1) AS rate FROM `rating`  WHERE id = '.$idshoes.'';
		$data1 = mysqli_query($conn, $query1);
		while ($row = mysqli_fetch_assoc($data1)) {
			$x = ($row);
		}
		$y = substr($x["rate"], 2);
		echo $y;
		if($y==5){
			$y = $x["rate"];
		}
		else if($y<5){
			$y = round($x["rate"],0);
		}
		else{
			$y = ceil($x["rate"]);
		}
		echo $y;
		$query2='UPDATE `shoes` SET rate ='.$y.' WHERE id = '.$idshoes.'';
		$data2 = mysqli_query($conn, $query2);
		if ($data == true) {
			$arr = [
				'success' => true,
				'message'=> "thanh cong",
			];
		}else{
			$arr = [
				'success' => false,
				'message' => " khong thanh cong",

			];
		}
		print_r(json_encode($arr));
	}else{
		$query = "INSERT INTO `rating`(`id`, `accountid`, `rate`) VALUES ('$idshoes','$accid','$rates')";
		$data = mysqli_query($conn, $query);
		$query1 ='SELECT AVG(rate) AS rate FROM `rating` WHERE id = '.$idshoes.'';
		$data1 = mysqli_query($conn, $query1);
		while ($row = mysqli_fetch_assoc($data1)) {
			$x = ($row);
		}
		$y = substr($x["rate"], 1);
		if($y==5){
			$y = $x["rate"];
		}
		else if($y<5){
			$y = round($x["rate"],0);
		}
		else{
			$y = ceil($x["rate"]);
		}
		$query2='UPDATE `shoes` SET rate = '.$y.' WHERE id = '.$idshoes.'';
		$data2 = mysqli_query($conn, $query2);
		if ($data == true) {
			$arr = [
				'success' => true,
				'message'=> "thanh cong",
			];
		}else{
			$arr = [
				'success' => false,
				'message' => " khong thanh cong",

			];
		}
		print_r(json_encode($arr));
	}
?>