<?php
include_once("dbconnect.php");

if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['name'];
} else {
    $user_email = "sookqichow00@gmail.com";
}

if (isset($_POST['submit'])) {
    $tutor_id = $_POST['tutor_id'];
    if ($user_email == "sookqichow00@gmail.com") {
        echo "<script>alert('Please register an account first.');</script>";
        echo "<script> window.location.replace('registration.php')</script>";
    } else {
        echo "<script> window.location.replace('tutordetails.php?tutor_id=$tutor_id')</script>";
        echo "<script>alert('OK.');</script>";
    }
}
if (isset($_GET['tutor_id'])) {
    $tutor_id = $_GET['tutor_id'];
    $sqltutor = "SELECT * FROM tbl_tutors WHERE tutor_id = '$tutor_id'";
    $stmt = $conn->prepare($sqltutor);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Tutor not found.');</script>";
        echo "<script> window.location.replace('tutors.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('tutors.php')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/mytutor/admin/js/mainpage.js"></script>
    <title>Welcome to My Tutor</title>
</head>

<body>

    <div class="topnav">
        <div class="topnav-right">
            <a href="index.php" class="w3-hide-small ">Courses</a>
            <a href="tutors.php" class="w3-hide-small ">Tutors</a>
            <a href="#" class="w3-hide-small ">Subscription</a>
            <a href="#" class="w3-hide-small ">Profile</a>
        </div>
    </div>
    <div id="mySidebar" class="w3-sidebar w3-bar-block w3-theme-2 w3-hide-large w3-hide-medium" style="display:none">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>
        <a href="index.php" class="w3-bar-item w3-button w3-left">Courses</a>
        <a href="tutors.php" class="w3-bar-item w3-button w3-left">Tutors</a>
        <a href="#" class="w3-bar-item w3-button w3-left">Subscription</a>
        <a href="#" class="w3-bar-item w3-button w3-left">Profile</a>
    </div>

    <div class="w3-theme-2">
        <button onclick="w3_open()" class="w3-button w3-right w3-hide-large w3-hide-medium">☰</button>
        <div class="w3-container">
            <h3>Tutor Details</h3>

        </div>
        <div class="w3-bar w3-theme-2">
            <a href="tutors.php" class="w3-bar-item w3-button w3-right">Back</a>
        </div>
    </div>

    <div>
        <?php
        foreach ($rows as $tutors) {
            $tutor_id =$tutors['tutor_id'];
            $tutor_name =$tutors['tutor_name'];
            $tutor_phone = $tutors['tutor_phone'];
            $tutor_email = $tutors['tutor_email'];
            $tutor_password = $tutors['tutor_password'];
            $tutor_description = $tutors['tutor_description'];
            $tutor_datereg = $tutors['tutor_datereg'];
        }
        echo "<div class='w3-padding w3-center'><img class='w3-image resimg' src=/mytutor/admin/res/assets/tutors/$tutor_id.jpg" .
            " onerror=this.onerror=null;this.src='/mytutor/admin/res/images/users/user.png'"
            . " ></div><hr>";
        echo "<div class='w3-container w3-padding-large'><h4><b>$tutor_name</b></h4>";
        echo " <div><p><b>Phone: </b><br>$tutor_phone</p><p><b>Email: </b>$tutor_email</p><p><b>Description:</b> $tutor_description</p> 
                <form action='tutordetails.php' method='post'> 
                    <input type='hidden'  name='tutor_id' value='$tutor_id'>
                    
                </form><br>
        
                </div></div>";


        ?>
    </div>


    <div class="w3-center w3-bottom w3-theme" style="max-width:1500px;margin:0 auto;">My Tutor</div>

</html>