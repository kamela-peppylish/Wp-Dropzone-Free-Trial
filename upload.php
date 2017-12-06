<?php
$token = $_POST['token'];
// Step 2: Creat a folder with token as folder name where file will get saved
$target_dir = "/wp-content/uploads/trial/"; // Absolute path for directory where file will save
$storeFolder = $target_dir .$token.'/'; // add newly created folder to target path
if(!file_exists($storeFolder) && !is_dir($storeFolder)) { // declare file store destination absolute paths
    mkdir($storeFolder);
}
// Step 3: Change file name according to setting
function cleanNameFunction($name){
    $name = preg_replace("/[^a-zA-Z0-9.]+/", "", $name);
    return $name;
}
$originalName = $_FILES['file']['name'];
$safeName = cleanNameFunction($originalName);
// Declare target path for file
$tempFile = $_FILES['file']['tmp_name'];
$target_file = $storeFolder . $safeName ;
// Step 4: move the temp file to Server to store the file in target direcotry
if (move_uploaded_file($tempFile, $target_file)) {$status = 1;}
?>

