<?php 
    session_start();
    include('./includes/dbconfig.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="header">
        <h2>Register</h2>
    </div>

    <form action="register_db.php" method="post">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <labet for="id">Id</labet>
            <input type="id" name="id">
        </div>
        <div class="input-group">
            <labet for="username">Username</labet>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <labet for="Password">Password</labet>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <labet for="firstname">Firstname</labet>
            <input type="firstname" name="firstname">
        </div>
        <div class="input-group">
            <labet for="surname">Surname</labet>
            <input type="surname" name="surname">
        </div>
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a mamber?<a href="login.php">Sign in</a></p>
    </form>

</body>
</html>