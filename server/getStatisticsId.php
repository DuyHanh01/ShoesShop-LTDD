<?php
	include "connect.php";
	$id = $_POST['id'];
	$brandid =$_POST['brandid'];
	if($brandid==0 && $id ==0 ){
        $query = 'SELECT monthlyrevenuedetails.`id`,`name`,`year`, `month`, SUM(`sellnumber`) AS sellnumber, SUM(`turnover`) AS turnover FROM `monthlyrevenuedetails` LEFT JOIN shoes ON shoes.id= monthlyrevenuedetails.id LEFT JOIN brand ON brand.brandid= shoes.brandid GROUP BY monthlyrevenuedetails.`id`, `year`, `month`';
    }else
    if($brandid==0 && $id !=0){
        $query = 'SELECT monthlyrevenuedetails.`id`,`name`,`year`, `month`, SUM(`sellnumber`) AS sellnumber, SUM(`turnover`) AS turnover FROM `monthlyrevenuedetails` LEFT JOIN shoes ON shoes.id= monthlyrevenuedetails.id WHERE monthlyrevenuedetails.`id` = '.$id.' GROUP BY monthlyrevenuedetails.`id`, `year`, `month`';
    }else
    if($brandid!=0 && $id ==0 ){
        $query = 'SELECT monthlyrevenuedetails.`id`,`name`,`year`, `month`, SUM(`sellnumber`) AS sellnumber, SUM(`turnover`) AS turnover FROM `monthlyrevenuedetails` LEFT JOIN shoes ON shoes.id= monthlyrevenuedetails.id LEFT JOIN brand ON brand.brandid= shoes.brandid WHERE brand.brandid='.$brandid.' GROUP BY monthlyrevenuedetails.`id`, `year`, `month`';
    }
	
	$data = mysqli_query($conn, $query);
	$result = array(); 
	while ($row = mysqli_fetch_assoc($data)) {
		$result[] = ($row);
	}
	if (!empty($result)) {
		$arr = [
				'success' => true,
				'message' => "thanh cong",
				'result' => $result
		];
	}else{
		$arr = [
			'success' => false,
			'message' => "khong thanh cong",
			'result' => $result
		];
	}
	print_r(json_encode($arr));
	
?>
