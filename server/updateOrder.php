<?php
include "connect.php";

$orderid = $_POST['orderid'];
$statusname = $_POST["statusname"];
$statusid = 1;
if ($statusname == "Đã duyệt") {
	$statusid = 2;
}
if ($statusname == "Đang giao") {
	$statusid = 3;
}
if($statusname == "Giao thành công"){
	$statusid = 4;
}
if ($statusname == "Đã hủy") {
	$statusid = 5;
}
$query = 'UPDATE `order` SET statusid = '.$statusid.' WHERE `orderid` = '.$orderid.'';
$data = mysqli_query($conn, $query);

$query1 = 'SELECT `statusid`,`momo` FROM `order` WHERE orderid = '.$orderid.' ';
$data1 = mysqli_query($conn, $query1);
while ($row = mysqli_fetch_assoc($data1)) {
             $x = ($row);
         }
if(!empty($x)&&$x["momo"]==null){
	if($x["statusid"]==4){
		$queryy='UPDATE `order` SET payment = 1 WHERE orderid = '.$orderid.' ';
		$dataa=mysqli_query($conn, $queryy);
		$query = 'SELECT o.bookingdate AS bookingdate,orderdetails.* FROM `order` o LEFT JOIN orderdetails ON orderdetails.orderid = o.orderid WHERE o.orderid = '.$orderid.' ';
		$data = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($data)) {
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
	}
	else if($x["statusid"]==5) {
		$query = 'SELECT o.bookingdate AS bookingdate,orderdetails.* FROM `order` o LEFT JOIN orderdetails ON orderdetails.orderid = o.orderid WHERE o.orderid = '.$orderid.' ';
		$data = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($data)) {
             $a[] = ($row);
         }
         foreach ($a as $key => $value) {
         	$time=strtotime($value["bookingdate"]);
			$month=date("n",$time);
			$year=date("Y",$time);
         	$truyvan2='SELECT COUNT(*) AS DEM FROM `monthlyrevenuedetails` WHERE year = '.$year.' AND month = '.$month.' AND id = '.$value["id"].'';
                $data2=mysqli_query($conn,$truyvan2);
            $truyvan1='UPDATE `shoes` SET `purchased`= `purchased` - '.$value["quantity"].',`stock`= `stock` + '.$value["quantity"].'  WHERE id = '.$value["id"].'';
            $data1=mysqli_query($conn,$truyvan1);
            if($value["size"] == "38"){
            	$query ='UPDATE `sizetable` SET `s38`= s38 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }else if($value["size"] == 39){
            	$query ='UPDATE `sizetable` SET `s39`= s39 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 40){
            	$query ='UPDATE `sizetable` SET `s40`= s40 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 41){
            	$query ='UPDATE `sizetable` SET `s41`= s41 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 42){
            	$query ='UPDATE `sizetable` SET `s42`= s42 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 43){
            	$query ='UPDATE `sizetable` SET `s43`= s43 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 44){
            	$query ='UPDATE `sizetable` SET `s44`= s44 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 45){
            	$query ='UPDATE `sizetable` SET `s45`= s45 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 46){
            	$query ='UPDATE `sizetable` SET `s46`= s46 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else if($value["size"] == 47){
            	$query ='UPDATE `sizetable` SET `s47`= s47 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
            else{
            	$query ='UPDATE `sizetable` SET `s48`= s48 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
            	$data = mysqli_query($conn, $query);
            }
		        while ($row = mysqli_fetch_assoc($data2)) {
		            $x = ($row);
		        }
		        if($x["DEM"]!=0){
		            $truyvan3='UPDATE `monthlyrevenuedetails` SET `sellnumber`=`sellnumber`-'.$value["quantity"].',`turnover`=`turnover`-'.$value["price"].'*'.$value["quantity"].' WHERE year = '.$year.' AND month = '.$month.' AND id = '.$value["id"].'';
		            $data3=mysqli_query($conn,$truyvan3);
		            $truyvan4='UPDATE `monthlyrevenue` SET `sellnumber`=`sellnumber`-'.$value["quantity"].',`turnover`=`turnover`- '.$value["price"].'*'.$value["quantity"].' WHERE `year`='.$year.' AND `month`='.$month.'';
		            $data4=mysqli_query($conn,$truyvan4);
		                    
		        }
		    }
    }
    else{

    }
}
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