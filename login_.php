<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_.css">
</head>
<body>
    <div class="container">
        <div class="form-box login">
            <form action="database_admin.php" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" required>
                    <img src="user (3).png" alt="user icon" class="icon">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" required>
                <img src="lock (1).png" alt="lock icon" class="icon"> 
                </div>
                <div class="forgot-link">
                    <a href="#">Forgot your password?</a>
                </div>                
                <button type="submit" class="btn">Login</button>
                <a href="javascript:history.back()" class="back-btn">Back</a>
            </form>
        </div>

<div class="form-box register">
    <form action="proses_register.php" method="POST">
        <h1>Registration</h1>

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <img src="user (3).png" alt="">
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <img src="gmail.png" alt="">
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <img src="lock (1).png" alt="">
        </div>

        <button type="submit" class="btn">Register</button>
        <a href="javascript:history.back()" class="back-btn">Back</a>
    </form>
</div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div> 
            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>
    
   <script src="login.js"></script> 
</body>
</html>