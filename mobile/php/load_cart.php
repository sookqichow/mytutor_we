<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
include_once("dbconnect.php");
$user_email = $_POST['user_email'];
$sqlloadcart = "SELECT tbl_carts.cart_id, tbl_carts.subject_id, tbl_carts.cart_qty, tbl_subjects.subject_name, tbl_subjects.subject_price 
FROM tbl_carts INNER JOIN tbl_subjects ON tbl_carts.subject_id = tbl_subjects.subject_id WHERE tbl_carts.user_email = '$user_email' AND tbl_carts.cart_status IS NULL";
$result = $conn->query($sqlloadcart);
$number_of_result = $result->num_rows;
if ($result->num_rows > 0) {
    //do something
    $total_payable = 0;
    $carts["cart"] = array();
    while ($rows = $result->fetch_assoc()) {

        $sublist = array();
        $sublist ['cartid'] = $rows['cart_id'];
        $sublist ['subjectname'] = $rows['subject_name'];
        $subjectprice = $rows['subject_price'];
        $sublist ['price'] = number_format((float)$subjectprice, 2, '.', '');
        $sublist ['cartqty'] = $rows['cart_qty'];
        $sublist ['subjectid'] = $rows['subject_id'];
        $price  = $rows['cart_qty'] * $subjectprice;
        $total_payable = $total_payable + $price;
        $sublist ['pricetotal'] = number_format((float)$price, 2, '.', ''); 
        array_push($carts["cart"],$sublist );
    }
    $response = array('status' => 'success', 'data' => $carts, 'total' => $total_payable);
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
