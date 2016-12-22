<?php
$lid = $_GET["lid"];

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$ulocation = $details->city;
$result = $conn->query("SELECT * FROM users where ulocation = '".$ulocation."'");
$rowcount = mysqli_num_rows($result);
if ($rowcount == 0 ) { $ulocation = "Kuala Lumpur";}


$rating = $conn->query("SELECT * FROM users WHERE ulocation = '".$ulocation."' AND rating > 0 ORDER BY rating DESC LIMIT 3");
$flag = $conn->query("SELECT a.id,a.fullname,b.name FROM users a,profiles b WHERE a.flag = 1 AND b.type = 5 GROUP BY a.id ORDER BY RAND() LIMIT 5");
$watchlist = $conn->query("SELECT * FROM users WHERE created_by = '".$lid."' ORDER BY id DESC LIMIT 5");
$location = $conn->query("SELECT * FROM users WHERE ulocation = '".$ulocation."' AND status = 1 ORDER BY id DESC LIMIT 3");
$views = $conn->query("SELECT * FROM users WHERE ulocation = '".$ulocation."' AND view > 0 ORDER BY view DESC LIMIT 3");
$photos = $conn->query("SELECT * FROM profiles WHERE type = '7' GROUP BY user_id LIMIT 6");


$outp = "[";
while($rs = $views->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"1",';
     $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"details":"'   . $rs["fullname"] . '",';
	$outp .= '"status":"'. $rs["view"]. '"}'; 
}

while($rs = $location->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"2",';
     $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"details":"'   . $rs["fullname"] . '",';
	$outp .= '"status":"'. $rs["ulocation"]. '"}'; 
}

while($rs = $rating->fetch_array(MYSQLI_ASSOC)) {
	
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"3",';
     $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"details":"'   . $rs["fullname"] . '",';
	$outp .= '"status":"'. $rs["rating"]. '"}'; 
}

while($rs = $watchlist->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"4",';
     $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"details":"'   . $rs["fullname"] . '",';
	$outp .= '"status":"'. $rs["ulocation"]. '"}'; 
}


while($rs = $flag->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"5",';
     $outp .= '"id":"'   . $rs["id"]        . '",';
    $outp .= '"details":"'   . $rs["fullname"] . '",';
	$outp .= '"status":"'. $rs["name"]. '"}'; 
}

while($rs = $photos->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"type":"7",';
    $outp .= '"id":"'   . $rs["user_id"]        . '",';
	$outp .= '"details":"'. $rs["details"]. '"}'; 
}


$outp .="]";

$conn->close();

echo($outp);
?>