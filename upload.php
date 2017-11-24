<?php
require_once('../../../wp-load.php');
require 'vendor/autoload.php';

$sendgrid = new SendGrid('api code');

$mail = new SendGrid\Email();// send email to example
$mail2 = new SendGrid\Email();// send confirmation email to client

// Step 5: Post form data for process
// Sender details
$name = "example.Com";// Sender name
$fname = $_POST['fname'];// Sender Name
$email = $_POST['email'];// Sender Email
$phone = $_POST['phone'];// Sender Telephone
$description = $_POST['description'];// Sender Message

// Step 1: Get token id to creat folder
$token = $_POST['token'];//get token to create Order Id

// declare file store destination absolute paths
$target_dir = "wp-content/uploads/trial/"; // Absolute path for directory where file will save

// Step 2: Creat a folder with token as folder name where file will get saved
$storeFolder = $target_dir .$token.'/'; // add newly created folder to target path
if(!file_exists($storeFolder) && !is_dir($storeFolder)) {
    mkdir($storeFolder);
}

// Step 3: Change file name according to setting
function cleanNameFunction($name){
    $name = preg_replace("/[^a-zA-Z0-9.]+/", "", $name);
    return $name;
}
$originalName = $_FILES['file']['name'];
$safeName     = cleanNameFunction($originalName);

// Declare target path for file
$tempFile = $_FILES['file']['tmp_name'];
$target_file = $storeFolder . $safeName ;

// Step 4: move the temp file to Server to store the file in target direcotry
if (move_uploaded_file($tempFile, $target_file)) {
$status = 1;
}

// Step 5: Get file links
$upload_dir = wp_upload_dir();
$url = $upload_dir['baseurl'].'/'.$token.'/'.$safeName ; 

// Step 6: Creat email based on Step 5 posted data
$msg = "Free Trial Id: $token \r\n\r\nDear Admin,\r\n\r\nA new free trial has been submitted on example.com.\r\n\r\nName: $fname\r\n\r\nEmail Address: $email\r\n\r\nTelephone: $phone \r\n\r\n\r\nBrief Instruction: $description\r\n\r\n";


	$msg .= "You can download the files from this link: \r\n \n$url \r\n\n\nPlease review the instruction carefully and process the trial order accordingly.\r\n\r\nKind Regards, \r\n\r\nexample.com \r\n\r\n";
	$recipient ="example@example.com";
	$subject = "$token";
	// Confirmation reciever
	$confirm_subject = "Thank you for trying example.Com";
	$confirm_msg = "Dear $fname,\r\n\r\nThank you for trying example.Com Free Trial service. Your free trial Id: $token. \r\n\r\nWe will notify you when your order is ready.";

// Step 7: send email
	// mail($recipient, $subject, $from, $mailheader) or die("Error!");
	$mail->
	addTo( $recipient )->
	setFromName($name)->
	setFrom( $email )->
    setSubject($subject)->
	setText($msg);
	// $mail2: Send Confirmation mail to client
	$mail2->
	addTo( $email )->
	setFromName($name)->
	setFrom( $recipient )->
    setSubject($confirm_subject)->
	setText($confirm_msg);
  	//Send Mail.
	if ( ($sendgrid->send($mail)) && ($sendgrid->send($mail2)) ){
		exit(header('Location: https://example.com/thank-you/'));
	}
	else{
		echo "Order submission failed.";
	}

?>

