<?php
session_start();
error_reporting(0);
include('#config.php');
if($_SESSION['alogin']!=''){
$_SESSION['alogin']='';
}
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
} else{
    
    echo "<script>alert('Invalid Details');</script>";

}

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        html{
            background-image: url(image/login.png);
            background-size: cover;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .wrapper {
            width: 420px;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(2px);
            color: black;
            border-radius: 12px;
            padding: 30px 40px;
            border-style: solid;
            border-color: #333;
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }

        .wrapper .input-box {
            position: relative;
            width: 100%;
            height: 50px;

            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: white;
            border: none;
            outline: none;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            color: black;
            padding: 20px 45px 20px 20px;
        }

        .input-box input::placeholder {
            color: #fff;
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 30%;
            transform: translate(-50%);
            font-size: 20px;

        }

        .wrapper .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14.5px;
            margin: -15px 0 15px;
        }

        .remember-forgot label input {
            accent-color: #fff;
            margin-right: 3px;

        }

        .remember-forgot a {
            color: #fff;
            text-decoration: none;

        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .wrapper .btn {
            width: 100%;
            height: 45px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .wrapper .register-link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;

        }

        .register-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }

        .input-box input::placeholder {
            color: black;
            /* Change placeholder text color to a slightly transparent white */
        }

        a {
            color: black !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form id="signinForm" action="welcome.php" method="post"> <!-- Added ID to the form -->
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" id="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>
    <script>
        // JavaScript for sign-in functionality
        document.getElementById('signinForm').addEventListener('submit', function (event) {
            event.preventDefault();
            // Add your sign-in functionality here
            // For example, you can validate user input and perform authentication
            // After successful authentication, store the username in local storage
            let username = document.getElementById('username').value;
            localStorage.setItem('username', username);
            window.location.href = 'budget.html';
        });
    </script>
</body>

</html>