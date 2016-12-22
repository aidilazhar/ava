<?php
/*** Start Processing Submitted Form Above ***/
if( isset($_POST['payment_options']) && $_POST['payment_options'] != "" ) {

$merchantid = "cloudycash";	
$vkey = "72571e556977f0dd11f019d9c05c3c58";	
$process_status = true;
$orderid = $_POST['molid'];
 
	if( $process_status === true ) {
		$params = array(
			'status'          => true,	// Set True to proceed with MOLPay
			'mpsmerchantid'   => $merchantid,
			'mpschannel'      => $_POST['payment_options'],
			'mpsamount'       => $_POST['total_amount'],
			'mpsorderid'      => $_POST['molid'],
			'mpsbill_name'    => $_POST['molfullname'],
			'mpsbill_email'   => $_POST['molemail'],
			'mpsbill_mobile'  => $_POST['molmobile'],
			'mpscountry'      => "MY",
			'mpsvcode'        => md5($_POST['total_amount'].$merchantid.$orderid.$vkey),
			'mpscurrency'     => "MYR",
			'mpslangcode'     => "en",
			'mpscancelurl'	  => "http://avava.co/api/cancel_order.php",
			'mpsreturnurl'    => "http://avava.co/api/molpay_return.php"
		);
	} elseif( $process_status === false ) {
		$params = array(
			'status'          => false,      // Set False to show an error message.
			'error_code'	  => "Your Error Code (Eg: 500)",
			'error_desc'      => "Your Error Description (Eg: Internal Server Error)",
			'failureurl'      => "index.html"
		);
	}
}
else
{
	$params = array(
		'status'          => false,      // Set False to show an error message.
		'error_code'	  => "500",
		'error_desc'      => "Internal Server Error",
		'failureurl'      => "index.html"
	);
}
echo json_encode( $params );
exit();
?>