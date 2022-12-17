<?php
    include "connect.php";
    $orderid = $_POST['orderid'];
    $query = 'SELECT orderdetails.* FROM `order` o LEFT JOIN orderdetails ON orderdetails.orderid = o.orderid WHERE o.orderid = '.$orderid.' ';
        $data = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($data)) {
             $a[] = ($row);
         }
         foreach ($a as $key => $value) {
             $truyvan1='UPDATE `shoes` SET `purchased`= `purchased` - '.$value["quantity"].',`stock`= `stock` + '.$value["quantity"].'  WHERE id = '.$value["id"].'';
            $data1=mysqli_query($conn,$truyvan1);
            if($value["size"] == "38"){
                $query ='UPDATE `sizetable` SET `s38`= s38 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }else if($value["size"] == "39"){
                $query ='UPDATE `sizetable` SET `s39`= s39 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "40"){
                $query ='UPDATE `sizetable` SET `s40`= s40 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "41"){
                $query ='UPDATE `sizetable` SET `s41`= s41 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "42"){
                $query ='UPDATE `sizetable` SET `s42`= s42 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "43"){
                $query ='UPDATE `sizetable` SET `s43`= s43 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "44"){
                $query ='UPDATE `sizetable` SET `s44`= s44 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "45"){
                $query ='UPDATE `sizetable` SET `s45`= s45 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "46"){
                $query ='UPDATE `sizetable` SET `s46`= s46 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else if($value["size"] == "47"){
                $query ='UPDATE `sizetable` SET `s47`= s47 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
            else{
                $query ='UPDATE `sizetable` SET `s48`= s48 + '.$value["quantity"].' WHERE id = '.$value["id"].' ';
                $data = mysqli_query($conn, $query);
            }
         }
    $query1 = 'DELETE FROM `order` WHERE orderid = '.$orderid.'';
    $data1 = mysqli_query($conn, $query1);
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