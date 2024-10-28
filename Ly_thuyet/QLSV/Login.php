<?php
session_start();
require_once 'google_client.php'; // Include the Google client setup file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Jost', sans-serif;
            background: #BCF2F6;
        }
        .main {
            width: 350px;
            height: 500px;
            background: rgba(255, 255, 255, 0.8);
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 5px 20px 50px #000;
        }
        #chk {
            display: none;
        }
        .login {
            position: relative;
            width: 100%;
            height: 100%;
        }
        label {
            color: #024CAA;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 50px;
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }
        input {
            width: 60%;
            height: 10px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 20px auto;
            padding: 12px;
            border: none;
            outline: none;
            border-radius: 5px;
            position: relative;
        }
        .password-container {
            position: relative;
            margin: 20px auto;
        }

        .toggle-password {
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #024CAA;
        }

        button {
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #024CAA;
            font-size: 1em;
            font-weight: bold;
            margin-top: 30px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }
        button:hover {
            background: #6d44b8;
        }
        .signup {
            height: 460px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
        }
        .signup label {
            color: #024CAA;
            transform: scale(.6);
        }
        #chk:checked ~ .signup {
            transform: translateY(-500px);
        }
        #chk:checked ~ .signup label {
            transform: scale(1);    
        }
        #chk:checked ~ .login label {
            transform: scale(.6);
        }
        .google-login {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60%;
            height: 40px;
            margin: 20px auto;
            background: #db4437;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background 0.3s ease;
            text-decoration: none;
        }
        .google-login:hover {
            background: #c23321;
        }
        .google-login i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="main">  	
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="login">
            <form action="kt_mk.php" method="post">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" id="tenTK" placeholder="User name" name="txtTenTK" required>
                <div class="password-container">
                    <input type="password" id="password" placeholder="Password" name="txtPass" required>
                    <i class="toggle-password fas fa-eye" onclick="togglePassword()"></i>
                </div>
                <button type="submit">Login</button>
                 <!-- Google Login Button -->
                 <a href="<?= $googleLoginUrl; ?>" class="google-login">
                    <i class="fab fa-google"></i> Login with Google
                </a>

            </form>
        </div>
        <div class="signup">
            <form action="xuly_themtk.php" method="post">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" id="tenTK" placeholder="User name" name="txtTenTK" required>
                <div class="password-container" >
                    <input type="password" id="signup-password" placeholder="Password" name="txtPass" required>
                    <i class="toggle-password fas fa-eye" onclick="toggleSignupPassword()"></i>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.login .toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function toggleSignupPassword() {
            const signupPasswordInput = document.getElementById('signup-password');
            const toggleIcon = document.querySelector('.signup .toggle-password');
            if (signupPasswordInput.type === 'password') {
                signupPasswordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                signupPasswordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        function googleLogin() {
    window.location.href = 'google_login.php'; // Replace with your Google login handler file
}

    </script>
</body>
</html>