<body style="color:#FFF">
<?php


$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");


$result = $conn->query("SELECT * FROM users ORDER BY RAND() LIMIT 100");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"id":"'  . $rs["id"] . '",';
    $outp .= '"fullname":"'   . $rs["fullname"]. '",';
    $outp .= '"location":"'   . $rs["ulocation"]. '",';
	$outp .= '"nric":"'   . $rs["nric"]. '",';
	$outp .= '"mobile":"'.$rs["mobile"].'"}'; 
}
$outp .="]";

$conn->close();

echo($outp);
?>
</body>