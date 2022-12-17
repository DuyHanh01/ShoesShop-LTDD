<?php
include "connect.php";
$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$address=$_POST['address'];
$note=$_POST['note'];
$total=$_POST['total'];
$accountid=$_POST['accountid'];
$chitiet=$_POST['chitiet'];
$bookingdate = date_create()->format('Y-m-d H:i:s');
$time=strtotime($bookingdate);
$month=date("n",$time);
$year=date("Y",$time);
$query='INSERT INTO `order`(`orderid`, `bookingdate`, `deliverydate`, `statusid`, `name`, `address`, `phone`, `email`, `note`, `total`, `payment`, `accountid`) VALUES (null,"'.$bookingdate.'",null, 1 ,"'.$name.'","'.$address.'","'.$phone.'","'.$email.'","'.$note.'",'.$total.',0,'.$accountid.')';
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
            $data = mysqli_query($conn,$truyvan);
            $truyvan1='UPDATE `shoes` SET `purchased`= `purchased` + '.$value["purchased"].',`stock`= `stock` - '.$value["purchased"].'  WHERE id = '.$value["id"].'';
            $data1 = mysqli_query($conn,$truyvan1);
            }
                if($data==true&&$data1==true){
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