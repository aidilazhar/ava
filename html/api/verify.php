<!DOCTYPE html>
<html lang="en">
<head>
  <title>AVAVA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#3366cc;color:#FFF">
<div class="container">
  <div class="row">
<div class="jumbotron text-center" style="background-color:#3366cc">
<center id="frontlogo"><img src="../images/logo.png" style="width:180px"></center>
<?php

$scode = $_GET["scode"];
$donation = date('F Y');

$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");

$result = $conn->query("SELECT * FROM users WHERE scode = '".$scode."' AND status = '0'");
$rowcount = mysqli_num_rows($result);
//$updateusr ="UPDATE users SET status = '1' WHERE scode = '".$scode."'";
$updateusr ="UPDATE users SET donation = '".$donation."', status = '1' WHERE scode = '".$scode."'";
$deleteusr ="DELETE FROM `users` WHERE created_date < date_sub(now(), interval 3 month)";


if ($rowcount > 0 || $scode !='') {
mysqli_query($conn, $updateusr);
mysqli_query($conn, $deleteusr);
echo "<h2>Your Account Successfully Verified</h2>";
echo '<p><a class="btn btn-success btn-lg" href="http://avava.my" role="button">Login Now</a></p>';
} else {
echo "<h2>We're unable to verified your account</h2>";
echo "<p>If you need help, please send email to ceo@avava.my </p>";

}
$conn->close();
?>
</div>
</div>
</div>
      

</body>
</html>
