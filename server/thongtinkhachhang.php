<?php
include "connect.php";
$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$address=$_POST['address'];
$bookingdate=$_POST['bookingdate'];
$deliverydate=$_POST['deliverydate'];
$note=$_POST['note'];
$total=$_POST['total'];
$accountid=$_POST['accountid'];
if(strlen($name)>0 && strlen($phone)>0 && strlen($email)>0 &&strlen($address)>0){
    $query="INSERT INTO order(orderid,bookingdate,deliverydate,statusid,name,address,phone,email,note,total,payment,accountid) VALUE (NULL,$bookingdate,$deliverydate,'1','$name','$address','$phone','$email','$note',$total,0,$accountid)";
     if(mysqli_query($conn,$query)){
         $iddonhang=$conn->insert_id;
         echo $iddonhang;
     }else{
         echo "Thất bại";
          }
    }else{
    echo "Bạn hãy kiểm tra lại các dữ liệu";
}
?>