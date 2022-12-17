<?php
	include "connect.php";
	$token = $_POST['token'];
	$orderid = $_POST["orderid"];
	$query = 'UPDATE `order` SET `statusid`=2,`payment`=1,`momo`= "'.$token.'" WHERE orderid = '.$orderid.'';
	$data = mysqli_query($conn, $query);
	$query1 = 'SELECT o.bookingdate AS bookingdate,orderdetails.* FROM `order` o LEFT JOIN orderdetails ON orderdetails.orderid = o.orderid WHERE o.orderid = '.$orderid.' ';
		$data1 = mysqli_query($conn, $query1);
		while ($row = mysqli_fetch_assoc($data1)) {
             $a[] = ($row);
         }
         foreach ($a as $key => $value) {
         	$time=strtotime($value["bookingdate"]);
			$month=date("n",$time);
			$year=date("Y",$time);
         	$truyvan2='SELECT COUNT(*) AS DEM FROM `monthlyrevenuedetails` WHERE year = '.$year.' AND month = '.$month.' AND id = '.$value["id"].'';
                $data2=mysqli_query($conn,$truyvan2);
                while ($row = mysqli_fetch_assoc($data2)) {
                     $x = ($row);
                 }
                 if($x["DEM"]!=0){
                    $truyvan3='UPDATE `monthlyrevenuedetails` SET `sellnumber`=`sellnumber`+'.$value["quantity"].',`turnover`=`turnover`+'.$value["price"].'*'.$value["quantity"].' WHERE year = '.$year.' AND month = '.$month.' AND id = '.$value["id"].'';
                    $data3=mysqli_query($conn,$truyvan3);
                    $truyvan4='UPDATE `monthlyrevenue` SET `sellnumber`=`sellnumber`+'.$value["quantity"].',`turnover`=`turnover`+ '.$value["price"].'*'.$value["quantity"].' WHERE `year`='.$year.' AND `month`='.$month.'';
                    $data4=mysqli_query($conn,$truyvan4);
                    
                 }
                 else{
                        $truyvan4='INSERT INTO `monthlyrevenuedetails`(`id`, `year`, `month`, `sellnumber`, `turnover`) VALUES ('.$value["id"].','.$year.','.$month.','.$value["quantity"].','.$value["price"].'*'.$value["quantity"].')';
                        $data4=mysqli_query($conn,$truyvan4);
                 }
         }
	if ($data1 == true) {
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