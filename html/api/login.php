<?php
if($_POST["mobile"] == '' && $_POST["nric"] == ''){die;}
$mobile = $_POST["mobile"];
$nric = $_POST["nric"];

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$ulocation = $details->city;
$donation = date('F Y');

if($ulocation != ''){$conn->query("UPDATE users SET ulocation = '".$ulocation."' WHERE mobile = '".$mobile."'");}

if ($nric ==''){
$resulta = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status=0");
$resultb = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND status=1");
if ($resulta->num_rows > 0) {
    while($row = $resulta->fetch_assoc()) {echo '[{"status":"0","fullname":"'. $row["fullname"].'"}]';}
} elseif ($resultb->num_rows > 0) {
     while($row = $resultb->fetch_assoc()) {echo '[{"status":"1","fullname":"'. $row["fullname"].'"}]';}
} else { echo '[{"status":"2","fullname":"0"}]'; }

} else {

$result = $conn->query("SELECT * FROM users where mobile = '".$mobile."' AND nric = '".$nric."' AND status=1");

$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) {
$conn->query("UPDATE users SET login = login + 1 WHERE mobile = '".$mobile."'");
$outp = "[";
 while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	if ($rs["donation"] != $donation){ $type = 2;}else{$type = 1;}
    if ($outp != "[") {$outp .= ",";}
	$outp .= '{"id":"'  . $rs["id"]. '",';
	$outp .= '"mobile":"'  . $rs["mobile"]. '",';
	$outp .= '"expired":"'  .$rs["donation"]. '",';
	$outp .= '"type":"'  .$type. '",';
    $outp .= '"fullname":"'. $rs["fullname"]. '"}'; }
$outp .="]";
echo($outp);
	
} else {

    echo '[{"status":"1"}]';
	  
  }

}

$conn->close();


?>