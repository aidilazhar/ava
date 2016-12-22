<?php

$pid = $_GET["pid"];
$usrid = $_GET["usrid"];
$v = $_GET["v"];

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$result = $conn->query("SELECT id FROM actions WHERE type='1' AND pid = '".$pid."' AND user_id = '".$usrid."'");

$check = mysqli_num_rows($result);

if ($check == 0) {
if ($v == 1){
$conn->query("UPDATE profiles SET votes = votes + 1 WHERE id = '".$pid."'");} else {
$conn->query("UPDATE profiles SET votes = votes - 1 WHERE id = '".$pid."'");}

$conn->query("INSERT INTO actions (type,pid,user_id) VALUES ('1','".$pid."','".$usrid."')");

$result = $conn->query("SELECT votes FROM profiles WHERE id = '".$pid."'");
if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) { echo '[{"status":"1","total":"'.$row["votes"].'"}]';}}

} else {
echo '[{"status":"2","msg":"0"}]';}

$resulta = $conn->query("SELECT * FROM profiles WHERE id = '".$pid."' AND votes < 1 AND status = 1");
if ($resulta->num_rows > 0) {while($row = $resulta->fetch_assoc()) { unlink("../".$row["details"]);
$conn->query("DELETE FROM profiles WHERE id = '".$pid."' AND votes < 1 AND status = 1");}}


$resultb = $conn->query("SELECT * FROM profiles WHERE id = '".$pid."' AND votes < 0 AND status = 0 AND created_by = '".$usrid."'");
if ($resultb->num_rows > 0) {while($row = $resultb->fetch_assoc()) { unlink("../".$row["details"]);
$conn->query("DELETE FROM profiles WHERE id = '".$pid."' AND votes < 0 AND status = 0 AND created_by = '".$usrid."'");}}

$conn->query("UPDATE profiles SET status = 1 WHERE id = '".$pid."' AND votes > 5");

$conn->close();

?>


