<?php
$id = $_GET["id"];
$term = $_GET["term"];

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

if ($term == ''){
$result = $conn->query("SELECT id,fullname,mobile,ulocation,flag FROM users where id !='".$id."' AND status = 1 ORDER BY RAND() DESC LIMIT 20");
}else{
$result = $conn->query("SELECT id,fullname,mobile,ulocation,flag FROM (select * from users where id != '".$id."') AS users WHERE fullname LIKE '%".$term."%' OR mobile LIKE '%".$term."%' OR nric LIKE '%".$term."%' LIMIT 20");}

$outp = "[";

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"id":"'  . $rs["id"] . '",';
    $outp .= '"fullname":"'   . $rs["fullname"]        . '",';
	$outp .= '"flag":"'   . $rs["flag"]        . '",';
    $outp .= '"location":"'   . $rs["ulocation"]        . '",';
	$outp .= '"mobile":"'. substr_replace($rs["mobile"], 'XX', -6, -4).'"}'; 
}
$outp .="]";

$conn->close();

echo($outp);
?>