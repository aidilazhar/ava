<?php
$vkey ="72571e556977f0dd11f019d9c05c3c58"; //Replace 2602770db42d768eafac407eb7a92e14 with your MOLPay Verify Key

/********************************
*Don't change below parameters
********************************/
$tranID     =    $_POST['tranID'];
$orderid     =    $_POST['orderid'];
$status     =    $_POST['status'];
$domain     =    $_POST['domain'];
$amount     =    $_POST['amount'];
$currency     =    $_POST['currency'];
$appcode     =    $_POST['appcode'];
$paydate     =    $_POST['paydate'];
$skey        =    $_POST['skey'];

/***********************************************************
* To verify the data integrity sending by MOLPay
************************************************************/
$key0 = md5( $tranID.$orderid.$status.$domain.$amount.$currency );
$key1 = md5( $paydate.$domain.$key0.$appcode.$vkey );

if( $skey != $key1 ) $status= -1; // Invalid transaction. 
// Merchant might issue a requery to MOLPay to double check payment status with MOLPay.

if ( $status == "00" ) {

$donation = date('F Y');
$conn = new mysqli("localhost", "avava_dba", "S3)R+BPshiH*", "avava_db");
$updateusr ="UPDATE users SET donation = '".$donation."' WHERE id = '".$orderid."'";
mysqli_query($conn, $updateusr);

} else {


}

// Merchant is recommended to implement IPN once received the payment status
// regardless the status to acknowledge MOLPay system

header("Location: http://avava.co/index.html");
exit;

function check_cart_amt( $orderid, $amount )
{
  /*** NOTE : this is a user-defined function which should be prepared by merchant ***/
	return true;
}
?>