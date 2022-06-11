<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$name = addslashes($_POST['name']);
$idno = $_POST['idno'];
$email = addslashes($_POST['email']);
$password = sha1($_POST['password']);
$address = $_POST['address'];
$phone = $_POST['phone'];
$base64image = $_POST['image'];
$sqlregister = "INSERT INTO `tbl_newusers`(`name`,`idno`,`email`,`pass`,`address`,`phone`) 
                VALUES ('$name','$idno','$email','$password','$address',
                '$phone')";
if ($conn->query($sqlregister) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
    $filename = mysqli_insert_id($conn);
    $decoded_string = base64_decode($base64image);
    $path = 'mytutor/user' . $filename . '.jpg';
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
