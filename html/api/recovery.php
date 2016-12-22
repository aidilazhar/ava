<?php
$mobile = $_GET["mobile"];

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$result = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status = 1 AND recovery < 2");
$updateusr ="UPDATE users SET recovery = recovery + 1   WHERE mobile = '".$mobile."'";

$rowcount = mysqli_num_rows($result);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);


if ($rowcount > 0) {

      $destination = urlencode($mobile);
      $message = 'AVAVA:"'  .$row["fullname"]. '" Mobile: "'  .$row["mobile"]. '" NRIC: "'  .$row["nric"]. '" ';
      $message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
      $message = urlencode($message);
      
      $username = urlencode("aidilazhar");
	  $password = urlencode("enambelas16");
	  $sender_id = urlencode("avava");
      $type = 1;


      $fp = "https://www.isms.com.my/isms_send.php";
      $fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
      $http = curl_init($fp);

	  curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
	  $http_result = curl_exec($http);
	  $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	  curl_close($http);

	  mysqli_query($conn, $updateusr);

      echo '[{"status":"1"}]';


} else { echo '[{"status":"0"}]'; }


$conn->close();


?>
