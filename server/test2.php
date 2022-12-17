<?php
include "Connect.php";
$name="vu";
$phone="0369880609";
$email="vu@gmail.com";
$address="gia lai";
$note="nhanh";
$total=14800;
$note="nhanh";
$bookingdate = date_create()->format('Y-m-d H:i:s');
$time=strtotime($bookingdate);
$month=date("n",$time);
$year=date("Y",$time);
$accountid=4;
$chitiet='[{"id":1,"images":"https://vcdn-giaitri.vnecdn.net/2020/07/06/air-jordan-1-dior-1815-1594004966.jpg","name":"Nike Dior","price":13000,"purchased":1,"size":"38"},{"id":2,"images":"https://shopgiayreplica.com/wp-content/uploads/2020/11/jordan-1-high-travis-scott.jpg","name":"Jordan 1 Travis Scott","price":900,"purchased":2,"size":"40"}]';
$query='INSERT INTO `order`(`orderid`, `bookingdate`, `deliverydate`, `statusid`, `name`, `address`, `phone`, `email`, `note`, `total`, `payment`, `accountid`) VALUES (null,"'.$bookingdate.'",null, 1 ,"'.$name.'","'.$address.'","'.$phone.'","'.$email.'","'.$note.'",'.$total.',0,'.$accountid.')';
    echo $query;
$data = mysqli_query($conn,$query);
    if($data==true){
        $query="SELECT `orderid` AS orderid FROM `order` WHERE accountid = $accountid ORDER BY orderid DESC LIMIT 1";
        $data = mysqli_query($conn,$query);
         while ($row = mysqli_fetch_assoc($data)) {
             $orderid = ($row);
         }
         if(!empty($orderid)){
            $json=json_decode($chitiet,true);
            foreach ($json as $key => $value) {
            $truyvan='INSERT INTO `orderdetails`(`orderid`, `id`, `quantity`, `size`, `price`, `total`) VALUES ('.$orderid["orderid"].','.$value["id"].','.$value["purchased"].',"'.$value["size"].'",'.$value["price"].','.$value["price"].'*'.$value["purchased"].')';
            $truyvan2='SELECT COUNT(*) AS DEM FROM `monthlyrevenuedetails` WHERE year = '.$year.' AND month = '.$month.' AND id = '.$value["id"].'';
                echo $truyvan;
                $data= mysqli_query($conn,$truyvan);
                $data2=mysqli_query($conn,$truyvan2);
                while ($row = mysqli_fetch_assoc($data2)) {
                     $x = ($row);
                 }
                 if($x["DEM"]!=0){
                    $truyvan3='UPDATE `monthlyrevenuedetails` SET `sellnumber`=`sellnumber`+'.$value["purchased"].',`turnover`=`turnover`+'.$value["price"].'*'.$value["purchased"].' WHERE year = '.$year.' AND month = '.$month.' AND id = '.$value["id"].'';
                    $data3=mysqli_query($conn,$truyvan3);
                    $truyvan4='UPDATE `monthlyrevenue` SET `sellnumber`=`sellnumber`+'.$value["purchased"].',`turnover`=`turnover`+ '.$value["price"].'*'.$value["purchased"].' WHERE `year`='.$year.' AND `month`='.$month.'';
                    $data4=mysqli_query($conn,$truyvan4);
                 }
                 else{
                        $truyvan5='INSERT INTO `monthlyrevenuedetails`(`id`, `year`, `month`, `sellnumber`, `turnover`) VALUES ('.$value["id"].','.$year.','.$month.','.$value["purchased"].','.$value["price"].'*'.$value["purchased"].')';
                        $data5=mysqli_query($conn,$truyvan5);
                 }
            }
                if($data==true){
                    $arr = [
                        'success' => true,
                         'message' =>"thanh cong",
                        ];
                }
                else{
                    $arr = [
                    'success' => false,
                     'message' =>"khong thanh cong",
                    ];  
                }
                print_r(json_encode($arr));
            }
         }
         else{
         $arr = [
            'success' => false,
            'message' =>"khong thanh cong",
            ];
            print_r(json_encode($arr));
          }
?>