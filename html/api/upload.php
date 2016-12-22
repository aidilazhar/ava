<?php

$useridu = $_POST["useridu"];
$timed = date("Ymdhis");
$sourcePath = $_FILES['userImage']['tmp_name'];
$info = pathinfo($_FILES['userImage']['name']);
$ext = $info['extension']; 
$newname = trim($useridu).$timed.".".$ext;
$targetPath = "../usrimages/".$newname;
$realPath = "usrimages/".$newname;
$finalPath = preg_replace('/\s+/', '', $realPath);
$cridu = $_POST["cridu"];
$cdate = date("Y-m-d h:i:s");


$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$result = $conn->query("SELECT * FROM profiles where user_id = '".$useridu."' AND created_by = '".$cridu."'");


$rowcount = mysqli_num_rows($result);


$insertProfile ="INSERT INTO profiles (user_id,type,name,details,number,date,votes,status,created_by,created_date) VALUES ('".$useridu."', '7','".$name."','".$finalPath."','".$number."','".$date."','".$votes."','0','".$cridu."','".$cdate."')";


if ($rowcount >= 6 || $ext !='jpg' ) { echo "0"; } 
else {
$percent = 0.5;
header('Content-type: image/jpeg');
list($width, $height) = getimagesize($sourcePath);
$new_width = $width * $percent;
$new_height = $height * $percent;
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($sourcePath);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
imagejpeg($image_p,$targetPath, 100);
mysqli_query($conn, $insertProfile);
echo $useridu;
}

$conn->close();
?>

