<?php
if (isset($_POST['submit'])) {
    include 'dbconnect.php';
    $email = $_POST['email'];
    $pass = sha1($_POST['password']);
    $sqllogin = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_pass = '$pass'";
    $stmt = $conn->prepare($sqllogin);
    $stmt->execute();
    $number_of_rows = $stmt->fetchColumn();
    if ($number_of_rows  > 0) {
        session_start();
        $_SESSION["sessionid"] = session_id();
        $_SESSION["email"] = $email;
        echo "<script>alert('Login Success');</script>";
        echo "<script> window.location.replace('mainpage.php')</script>";
    } else {
        echo "<script>alert('Login Failed');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="/mytutor/admin/js/login.js"></script>
</head>

<body onload="loadCookies()">
    <header class="w3-header w3-theme w3-center w3-padding-32" >
        <h3>My Tutor User</h3>
        <p>Login Page</p>
    </header>
    <div style="display:flex; justify-content: center">
        <div class="w3-container w3-card w3-padding w3-margin" style="width:600px;margin:auto;text-align:left;">
            <form name="loginForm" action="login.php" method="post">
                <p>
                    <label><b>Email</b></label>
                    <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail" placeholder="Your email" required>
                </p>
                <p>
                    <label><b>Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="password" id="idpass" placeholder="Your password" required>
                </p>
                <p>
                    <input class="w3-check" name="rememberme" type="checkbox" id="idremember" onclick="rememberMe()">
                    <label>Remember Me</label>
                </p>
                <p>
                    <input class="w3-button w3-round w3-border w3-theme-2" type="submit" name="submit" id="idsubmit">
                </p>
                <a href="register.php" class="w3-bar-item w3-button" style="color:#e29578;">Haven't register? Register now</a>

            </form>
        </div>
    </div>
    <div id="cookieNotice" class="w3-right w3-block " style="display: none;">
        <div class="w3-theme-1 w3-padding" >
            <h4>Cookie Consent</h4>
            <p>This website uses cookies or similar technologies, to enhance your
                browsing experience and provide personalized recommendations.
                By continuing to use our website, you agree to our
                <a style="color:#e29578;" href="/privacy-policy">Privacy Policy</a>
            </p>
            <div class="w3-button">
                <button onclick="acceptCookieConsent();" class="w3-theme-2">Accept</button>
            </div>
        </div>
    </div>
    <footer class="w3-footer w3-center w3-theme">
        <p>My Tutor</p>
    </footer>

</body>
<script>
    let cookie_consent = getCookie("user_cookie_consent");
    if (cookie_consent != "") {
        document.getElementById("cookieNotice").style.display = "none";
    } else {
        document.getElementById("cookieNotice").style.display = "block";
    }
</script>


</html>