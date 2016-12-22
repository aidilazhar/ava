<?php
if ($_GET["pid"] == ''){die;}

$pid = $_GET["pid"];
$rname = $_GET["rname"];
$donation = date('F Y');

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$conn->query("UPDATE users SET view = view + 1 WHERE id = '".$pid."'");
$resulta = $conn->query("SELECT * FROM users where id ='".$pid."'");
$resultb = $conn->query("SELECT * FROM profiles where user_id ='".$pid."'");
$resultc = $conn->query("SELECT id,mobile FROM users where id ='".$pid."' AND donation != '".$donation."' AND  notify = 0 AND status = 1");
$rowcount = mysqli_num_rows($resultc);

$outp = "[";

while($rs = $resulta->fetch_array(MYSQLI_ASSOC)) {
	
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"0",';
     $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"details":"'   . $rs["fullname"]        . '",';
	$outp .= '"flag":"'   . $rs["flag"]        . '",';
	$outp .= '"ulocation":"'   . $rs["ulocation"]        . '",';
	$outp .= '"nric":"'   . substr_replace($rs["nric"], 'XXXX', -7, -3). '",';
	$outp .= '"mobile":"'   . substr_replace($rs["mobile"], 'XX', -6, -4). '",';
	$outp .= '"rating":"'   . $rs["rating"]        . '",';
	$outp .= '"status":"1"}'; 
}

while($rs = $resultb->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"'  . $rs["type"] . '",';
	 $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"name":"'   . $rs["name"]        . '",';
    $outp .= '"details":"'   . $rs["details"]        . '",';
	$outp .= '"votes":"'   . $rs["votes"]        . '",';
	$outp .= '"date":"'   . $rs["date"]        . '",';
	$outp .= '"number":"'   . $rs["number"]        . '",';
	$outp .= '"status":"'. $rs["status"]     . '"}'; 
}
$outp .="]";



echo($outp);

if ($rowcount > 0 ) {
while($rs = $resultc->fetch_array(MYSQLI_ASSOC)) {
      $destination = urlencode($rs["mobile"]);
      $message = "AVAVA: ".$rname." viewed your profile information at http://avava.my";
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
	  $conn->query("UPDATE users SET notify = 1 WHERE id = '".$pid."'");
    }
}

$conn->close();
?>