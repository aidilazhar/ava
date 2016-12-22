<?php
$mobile = $_POST["mobile"];
$nric = $_POST["nric"];
$fullname = strtoupper($_POST["fullname"]);
$cdate = date("Y-m-d h:i:s");

$scode = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNM", 6)), 0, 6);

$address = $_POST["address"];

if ($_POST["city"] == ''){
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$ulocation = $details->city;
if($ulocation == ''){ $ulocation = "Kuala Lumpur"; }
} else {
$ip = $_SERVER['REMOTE_ADDR'];
$ulocation = $_POST["city"]; }

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");
$resulta = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status=1");
$resultb = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status=0");

$rowcounta = mysqli_num_rows($resulta);
$rowcountb = mysqli_num_rows($resultb);

$insertusr ="INSERT INTO users (fullname,mobile, nric,ulocation,address,scode,ip,status,created_date) VALUES ('".$fullname."', '".$mobile."','".$nric."','".$ulocation."','".$address."','".$scode."','".$ip."','0','".$cdate."')";

$updateusr ="UPDATE users SET fullname = '".$fullname."', nric = '".$nric."', ulocation = '".$ulocation."', scode = '".$scode."'  WHERE mobile = '".$mobile."'";

if ($rowcounta > 0 || $mobile =='' || $nric =='' || $fullname =='' ) {
   

      echo "Registration Failed: One of your field is empty";
	
	
} elseif ($rowcountb > 0 ) {
	
   mysqli_query($conn, $updateusr);
      $destination = urlencode($mobile);
      $message = "AVAVA: click here to verify your account:http://avava.co/api/verify.php?scode=".$scode;
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

      echo "<div class='alert alert-success' role='alert'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i> Registration Success<br> Verification URL Send to your mobile ".$mobile."</div>";


}else {
	   
   mysqli_query($conn, $insertusr);
      $destination = urlencode($mobile);
      $message = "AVAVA: click here to verify your account:http://avava.co/api/verify.php?scode=".$scode;
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

      echo "<div class='alert alert-success' role='alert'>Registration Success<br> Verification URL Send to your mobile ".$mobile."</div>";
}


$conn->close();


?>
