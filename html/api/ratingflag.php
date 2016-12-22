<?php

$pid = $_GET["pid"];
$usrid = $_GET["usrid"];
$t = $_GET["t"];

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$resulta = $conn->query("SELECT id FROM actions WHERE type='2' AND pid = '".$pid."' AND user_id = '".$usrid."'");
$resultb = $conn->query("SELECT id FROM actions WHERE type='3' AND pid = '".$pid."' AND user_id = '".$usrid."'");

$checka = mysqli_num_rows($resulta);
$checkb = mysqli_num_rows($resultb);


if ($t == r && $checka == 0){
$conn->query("UPDATE users SET rating = rating + 1 WHERE id = '".$pid."'");
$conn->query("INSERT INTO actions (type,pid,user_id) VALUES ('2','".$pid."','".$usrid."')");
$result = $conn->query("SELECT rating FROM users WHERE id = '".$pid."'");
if ($result->num_rows > 0) {while($row = $result->fetch_assoc()) {
		echo '[{"status":"1","total":"'.$row["rating"].'"}]';
    }
  }
} elseif ($t == f && $checkb == 0){
$conn->query("UPDATE users SET flag = flag + 1 WHERE id = '".$pid."'");
$conn->query("INSERT INTO actions (type,pid,user_id) VALUES ('3','".$pid."','".$usrid."')");
$result = $conn->query("SELECT flag FROM users WHERE id = '".$pid."'");
if ($result->num_rows > 0) {while($row = $result->fetch_assoc()) {
		echo '[{"status":"1","total":"'.$row["flag"].'"}]';
    }
  }
} else {  echo '[{"status":"2","msg":"0"}]'; }

$conn->close();


?>



