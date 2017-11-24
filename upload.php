<?php
require_once('../../../wp-load.php');
require 'vendor/autoload.php';

$sendgrid = new SendGrid('sendgrid api');

$mail = new SendGrid\Email();// send email to admin
$mail2 = new SendGrid\Email();// send confirmation email to client

// Step 4: Post form data for process
// Sender details
$name = "example.Com";// Sender name
$fname = $_POST['fname'];// Sender Name
$email = $_POST['email'];// Sender Email
$phone = $_POST['phone'];// Sender Telephone
$description = $_POST['description'];// Sender Message
$token = $_POST['token'];//get token to create Order Id

$target_dir = "/wp-content/uploads/trial/"; // Absolute path for directory where file will save
$storeFolder = $target_dir .$token.'/'; 
$originalName = $_FILES['file']['name'];
$safeName     = cleanNameFunction($originalName);
$target_file = $storeFolder . $safeName ;
$tempFile = $_FILES['file']['tmp_name']; 

$upload_dir = wp_upload_dir();
$url = $upload_dir['baseurl'].'/'.$token.'/'.$safeName ;  
// Step 1: Creat a direcotry to save file

if(!file_exists($storeFolder) && !is_dir($storeFolder)) {
    mkdir($storeFolder);
}
// Step 2: Change file name according to setting
function cleanNameFunction($name){
    $name = preg_replace("/[^a-zA-Z0-9.]+/", "", $name);
    return $name;
}

// Step 3: move the temp file to Server to store the file in target direcotry
if (move_uploaded_file($tempFile, $target_file)) {
$status = 1;
}

// //$images_arr = array();
//     foreach($_FILES['file']['tmp_name'] as $key=>$val){
//         //upload and stored images
//         $tempFile = $_FILES['file']['tmp_name'][$key];
//         $targetFile =  $storeFolder. $_FILES['file']['name'][$key];
//         move_uploaded_file($tempFile,$targetFile);
        
//         // $tempFile = $_FILES['file']['tmp_name']; 

//         // $target_file = $storeFolder . $_FILES['file']['name'][$key] ;
//         // move_uploaded_file($_FILES['file']['tmp_name'][$key],$target_file);

//         // if(move_uploaded_file($_FILES['file']['tmp_name'][$key],$target_file)){
//         // 	$status = 1;
//         //     $images_arr[] = $target_file;
//         // }
//     }

// Step 5: Creat email based on Step 4 posted data
$msg = "Free Trial Id: $token \r\n\r\nDear Admin,\r\n\r\nA new free trial has been submitted on example.com.\r\n\r\nName: $fname\r\n\r\nEmail Address: $email\r\n\r\nTelephone: $phone \r\n\r\n\r\nBrief Instruction: $description\r\n\r\n";


	$msg .= "You can download the files from this link: \r\n \n$url \r\n\n\nPlease review the instruction carefully and process the trial order accordingly.\r\n\r\nKind Regards, \r\n\r\nImageEditing.com \r\n\r\nSkype: metrodeskbd[24 hours] \r\n\r\nEmail:support@imageediting.com";
	$recipient ="example@example.com";
	$subject = "$token - New Free Trial from example";
	// Confirmation reciever
	$confirm_subject = "Thank you for trying example.Com";
	$confirm_msg = "Dear $fname,\r\n\r\nThank you for trying example.Com Free Trial service. Your free trial Id: $token. \r\n\r\nWe will notify you when your order is ready.\r\n\r\nFor any support you can reply to this email or call us at 00880 1741589509.\r\n\r\nKind Regards, \r\n\r\nImageEditing \r\n\r\nVisit: www.imageediting.com\r\n\r\nEmail: support@imageediting.com";

// Step 6: send email
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
		echo "Order submission failed. ";
	}

?>

