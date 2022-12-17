<?php
include 'connect.php'; // include database connection file
$id = $_POST['id'];
$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

// getting the number of total number of files 
$countfiles = count($_FILES['file']['name']);
$file = $_FILES['file']['name'][0]; // getting first file

if(empty($file))
{
    // if file is empty show error
	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
	echo $errorMSG;
}
else
{

$upload_path = 'images/'; // declare file upload path
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid image extensions - file extensions

// Looping all files 
for($i=0;$i<$countfiles;$i++){
    $fileName = $_FILES['file']['name'][$i];
    $tempPath = $_FILES['file']['tmp_name'][$i];
    $fileSize  =  $_FILES['file']['size'][$i];

    $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension

    // check if the files are contain the vALID  extensions
    if(in_array($fileExt, $valid_extensions))
	{				
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $fileName))
		{
			// check file size '5MB' - 5MegaByte is allowed
			if($fileSize < 5000000){

                //built-in method to move file to directory
				move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
                
                //insert into database table
                $query =  mysqli_query($conn,'INSERT INTO `images`(`imgid`, `id`, `image`) VALUES (null,34,"'.$fileName.'")');
                
            }
			else{		
				$arr = [
	         'success' => false,
	         'message' => "Sorry, your file is too large, please upload 5 MB size"
	            ];
			}
		}
		else
		{		
			$arr = [
	         'success' => false,
	         'message' => "Sorry, file already exists check upload folder"
	            ];
		}
	}
	else
	{		
		$arr = [
         'success' => false,
         'message' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed"
            ];	
	}
   
   }
}

//if no error message show response
if(!isset($errorMSG))
{	
	$arr = [
         'success' => true,
         'message' => "thanh cong",
         "name" => $fileName
            ]; 
}
echo json_encode($arr); 

?>