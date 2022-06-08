<?php
include_once("dbconnect.php");

if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['name'];
} else {
    $user_email = "sookqichow00@gmail.com";
}

if (isset($_POST['submit'])) {
    $subject_id = $_POST['subject_id'];
    if ($user_email == "sookqichow00@gmail.com") {
        echo "<script>alert('Please register an account first.');</script>";
        echo "<script> window.location.replace('registration.php')</script>";
    } else {
        echo "<script> window.location.replace('productdetails.php?subject_id=$subject_id')</script>";
        echo "<script>alert('OK.');</script>";
    }
}
if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $sqlsubject = "SELECT * FROM tbl_subjects WHERE subject_id = '$subject_id'";
    $stmt = $conn->prepare($sqlsubject);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Subject not found.');</script>";
        echo "<script> window.location.replace('subject.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('subject.php')</script>";
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
            <h3>Course Details</h3>

        </div>
        <div class="w3-bar w3-theme-2">
            <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
        </div>
    </div>

    <div >
        <?php
        foreach ($rows as $subjects) {
            $subject_id = $subjects['subject_id'];
            $subject_name = $subjects['subject_name'];
            $subject_description = $subjects['subject_description'];
            $subject_price = $subjects['subject_price'];
            $tutor_id = $subjects['tutor_id'];
            $subject_sessions = $subjects['subject_sessions'];
            $subject_rating = $subjects['subject_rating'];
        }
        echo "<div class='w3-padding w3-center'><img class='w3-image resimg' src=/mytutor/admin/res/assets/courses/$subject_id.png" .
            " onerror=this.onerror=null;this.src='/mytutor/admin/res/images/users/user.png'"
            . " ></div><hr>";
        echo "<div class='w3-container w3-padding-large'><h4><b>$subject_name</b></h4>";
        echo " <div><p><b>Description</b><br>$subject_description</p><p><b>Price: </b>RM $subject_price</p><p><b>Session:</b> $subject_sessions</p><p ><b>Rating:</b> $subject_rating <i class='fa fa-star'></i></p> 
                <form action='coursedetails.php' method='post'> 
                    <input type='hidden'  name='subject_id' value='$subject_id'>
                    <input class='w3-button w3-theme w3-round' type='submit' name='submit' value='Subscribe'>
                </form><br>
        
                </div></div>";


        ?>
    </div>


    <div class="w3-center w3-bottom w3-theme" style="max-width:1500px;margin:0 auto;">My Tutor</div>

</html>