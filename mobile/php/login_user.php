<?php
if (!isset($_POST)){
    echo "failed";
}

include_once("dbconnect.php");
$email = $_POST['email'];
$password= sha1($_POST['password']);
$sqllogin = "SELECT * FROM tbl_users WHERE user_email='$email' AND user_pass='$password'";
$result = $conn->query($sqllogin);
$numrow = $result->num_rows;
if ($numrow > 0){
    while($row=$result->fetch_assoc()){
        $admin['id']=$row['user_id'];
        $admin['name']=$row['user_name'];
        $admin['email']=$row['user_email'];
        $admin['phoneno']=$row['user_phoneno'];
        $admin['address']=$row['user_address'];
    }
    $response=array('status'=>'success','data'=>$user);
    sendJasonResponse($response);
}else{
    $response=array('status'=>'failed','data'=>null);
    sendJasonResponse($response);
}

function sendJasonResponse($sentArray){
    header('content.Type:application/json');
    echo json_encode($sentArray);
}

?>