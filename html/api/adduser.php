<?php
if ($_POST["mobile"] == ''){die;}
$mobile = $_POST["mobile"];
$cid = $_POST["cid"];
$nid = $_POST["nid"];
$nric = $_POST["nric"];
$fullname = strtoupper($_POST["fullname"]);

$requestname = strtok($nid, " ");

$scode = substr(str_shuffle(str_repeat("0123456789QWERTYUIOPASDFGHJKLZXCVBNM", 6)), 0, 6);
$cdate = date("Y-m-d h:i:s");

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$ulocation = $details->city;

$city_array = array("Johor Bahru","Alor Setar","Kota Bharu","Melaka","Seremban","Kuantan","Pulau Pinang","Ipoh","Kangar","Kota Kinabalu","Kuching","Shah Alam","Kuala Terengganu","Petaling Jaya","Ampang","Kuala Lumpur","Singapore");

shuffle($city_array);

if($ulocation == ''){ $ulocation = $city_array[0]; }


$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$resulta = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status= 1");
$resultb = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status= 0");

$rowcounta = mysqli_num_rows($resulta);
$rowcountb = mysqli_num_rows($resultb);

$insertusr ="INSERT INTO users (fullname,mobile, nric,ulocation,scode,status,created_by,created_date) VALUES ('".$fullname."', '".$mobile."','".$nric."','".$ulocation."','".$scode."','0','".$cid."','".$cdate."')";

$updateusr ="UPDATE users SET fullname = '".$fullname."', nric = '".$nric."', ulocation = '".$ulocation."', scode = '".$scode."'  WHERE mobile = '".$mobile."'";

if ($rowcounta > 0 ) {
   
      echo $mobile;
      /*echo '<div class="panel panel-success" id="Fsuccessa"><div class="panel-heading"  id="psuccessb"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> We will inform you as soon as "'.$fullname.'" information becomes available.</b></div></div>';*/
	
	
} elseif ($rowcountb > 0 ) {
	
   mysqli_query($conn, $updateusr);
     echo $mobile;
     /*echo '<div class="panel panel-success" id="Fsuccessa"><div class="panel-heading"  id="psuccessb"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> We will inform you as soon as "'.$fullname.'" information becomes available.</b></div></div>';*/


}else {
	   
   mysqli_query($conn, $insertusr);
   echo $mobile;

     /* $destination = urlencode($mobile);
      $message = "AVAVA: ".$fullname.", ".$requestname." viewed your profile information at http://avava.my";
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


   echo '<div class="panel panel-success" id="Fsuccessa"><div class="panel-heading"  id="psuccessb"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> We will inform you as soon as "'.$fullname.'" information becomes available.</b></div></div>';*/
  
}



$conn->close();


?>
