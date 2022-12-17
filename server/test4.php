<?php
include "connect.php";

$query = "SELECT GROUP_CONCAT(DISTINCT id SEPARATOR ', ') as item
FROM orderdetails 
GROUP BY orderid";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
  $result[] = ($row);
  // code...
}
$fp = fopen('test4.csv', 'w');
  
// Loop through file pointer and a line
foreach ($result as $fields) {
    fputcsv($fp, $fields);
}
  
fclose($fp);
// print_r($result);
if (!empty($result)) {
  $arr = [
    'success' => true,
    'message' => "Thanh cong",
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