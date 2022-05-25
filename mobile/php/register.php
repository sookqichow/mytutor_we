<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$email = addslashes($_POST['email']);
$name = addslashes($_POST['name']);
$phoneno = $_POST['phoneno'];
$pass = $_POST['pass'];
$address = $_POST['address'];
$base64image = $_POST['image'];
$status = "available";
$sqlinsert = "INSERT INTO `tbl_users`( `user_email`, `user_name`, `user_phoneno`, `user_pass`, `user_address`) 
VALUES ('[email]','[name]','[phoneno]','[pass]','[vaddress]')";
if ($conn->query($sqlinsert) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
    $filename = mysqli_insert_id($conn);
    $decoded_string = base64_decode($base64image);
    $path = '../assets/products/' . $filename . '.jpg';
    $is_written = file_put_contents($path, $decoded_string);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>