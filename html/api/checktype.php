<?php
$id = $_GET["id"];
$donation = date('F Y');

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");


$result = $conn->query("SELECT * FROM users where id = '".$id."' AND donation = '".$donation."'");

$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) {
 	echo '[{"type":"1"}]';
} else {

    echo '[{"type":"2"}]';
	  
  }



$conn->close();


?>