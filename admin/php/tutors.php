<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['name'];
}else{
    $user_email = "sookqichow00@gmail.com";
}
include_once("dbconnect.php");
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'search') {
        $search = $_GET['search'];
            $sqltutor = "SELECT * FROM tbl_tutors WHERE tutor_name LIKE '%$search%'";
        
    }
} else {
    $sqltutor = "SELECT * FROM tbl_tutors";
}

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}


$stmt = $conn->prepare($sqltutor);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutor = $sqltutor . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutor);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$conn= null;
function subString($str)
{
    if (strlen($str) > 15) {
        return $substr = substr($str, 0, 15) . '...';
    } else {
        return $str;
    }
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
            <h3>My Tutor</h3>
        </div>
    </div>
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3>Tutor Search</h3>
        <form>
            <div class="w3-row">
                <div style="padding-right:4px">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" /></p>
                </div>
                
            </div>
            <button class="w3-button w3-theme w3-round w3-right" type="submit" name="submit" value="search">search</button>
        </form>

    </div>
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $tutors) {
            $i++;
            $tutor_id = $tutors['tutor_id'];
                $tutor_name = subString($tutors['tutor_name']);
                $tutor_phone = $tutors['tutor_phone'];
                $tutor_email = subString($tutors['tutor_email']);
                $tutor_password = $tutors['tutor_password'];
                $tutor_description = subString($tutors['tutor_description']);
                $tutor_datereg = $tutors['tutor_datereg'];
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-theme'><h5><b>$tutor_name</b></h5></header>";
            echo "<a> <img class='w3-image' src=/mytutor/admin/res/assets/tutors/$tutor_id.jpg" .
                " onerror=this.onerror=null;this.src='../../admin/users/user.jpg'"
                . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container '><p>Phone: $tutor_phone<br>Email: $tutor_email<br>Description: $tutor_description </p></div>";
            echo "<button class=' w3-theme-2 w3-round w3-block'><a href='tutordetails.php?tutor_id=$tutor_id'>View Details</a></button>
            </div>";
           
            
        }
        ?>
    </div>
    <br>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "tutor.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>

    <div class="w3-center w3-bottom w3-theme" style="max-width:1500px;margin:0 auto;">My Tutor</div>


    

</body>

</html>