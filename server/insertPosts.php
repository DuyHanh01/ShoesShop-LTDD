<?php
	include "connect.php";

	$shoesname = $_POST['shoesname'];
	$price = $_POST['price'];
	$size = $_POST['size'];
	$description = $_POST['description'];
	$accountid = $_POST['accountid'];
	$images = $_POST['images'];
	// $shoesname = "nike";
	// $price = 2000;
	// $size = 42;
	// $description = "con moi";
	// $accountid = 14;

	$query = 'INSERT INTO `product`(`id`, `shoesname`, `price`, `size`, `description`, `accountid`, `statusid`) VALUES (null,"'.$shoesname.'",'.$price.',"'.$size.'","'.$description.'",'.$accountid.',1)';
	$data = mysqli_query($conn, $query);
	
	if ($data == true) {
		$query="SELECT `id` AS id FROM `product` WHERE accountid = $accountid ORDER BY id DESC LIMIT 1";
        $data = mysqli_query($conn,$query);
         while ($row = mysqli_fetch_assoc($data)) {
             $orderid = ($row);
         }
         if(!empty($orderid)){
            $json=json_decode($images,true);
            foreach ($json as $key => $value) {
				
            $truyvan='INSERT INTO `images`(`imgid`, `id`, `image`) VALUES (null,'.$orderid["id"].',"'.$value["image"].'")';
            //$truyvan='INSERT INTO `orderdetails`(`orderid`, `id`, `quantity`, `size`, `price`, `total`) VALUES ('.$orderid["orderid"].','.$value["id"].','.$value["purchased"].',"'.$value["size"].'",'.$value["price"].','.$value["price"].'*'.$value["purchased"].')';
            
			$data = mysqli_query($conn,$truyvan);
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
            // $truyvan1='UPDATE `shoes` SET `purchased`= `purchased` + '.$value["purchased"].',`stock`= `stock` - '.$value["purchased"].'  WHERE id = '.$value["id"].'';
            // $data1 = mysqli_query($conn,$truyvan1);
            }
                
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