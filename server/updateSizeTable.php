<?php
	include "connect.php";

	$sizeid = $_POST['sizeid'];
	$s38 = $_POST['s38'];
	$s39 = $_POST['s39'];
	$s40 = $_POST['s40'];
	$s41 = $_POST['s41'];
	$s42 = $_POST['s42'];
	$s43 = $_POST['s43'];
	$s44 = $_POST['s44'];
	$s45 = $_POST['s45'];
	$s46 = $_POST['s46'];
	$s47 = $_POST['s47'];
	$s48 = $_POST['s48'];

	$query = "UPDATE `sizetable` SET `s38`='$s38',`s39`='$s39',`s40`='$s40',`s41`='$s41',`s42`='$s42',`s43`='$s43',`s44`='$s44',`s45`='$s45',`s46`='$s46',`s47`='$s47',`s48`='$s48' WHERE `sizeid` = '$sizeid'";
	$data = mysqli_query($conn, $query);
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
	
?>