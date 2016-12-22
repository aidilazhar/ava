<?php 
$userid = $_POST["userid"];
$type = $_POST["type"];
$name = $_POST["name"];
$details = $_POST["details"];
$date = $_POST["date"];
$number = $_POST["number"];
$crid = $_POST["crid"];
$cdate = date("Y-m-d h:i:s");


$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$result = $conn->query("SELECT * FROM profiles where user_id = '".$userid."' AND created_by = '".$crid."'");


$rowcount = mysqli_num_rows($result);


$insertProfile ="INSERT INTO profiles (user_id,type,name,details,number,date,votes,status,created_by,created_date) VALUES ('".$userid."', '".$type."','".$name."','".$details."','".$number."','".$date."','".$votes."','0','".$crid."','".$cdate."')";


if ($rowcount > 3 ) {
   
      echo '[{"status":"0"}]';

}else {
	   
   mysqli_query($conn, $insertProfile);

    echo '[{"status":"1","id":"'.$userid.'"}]';
}

$conn->close();

?>
