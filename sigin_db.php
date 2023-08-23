<?php
session_start();
require_once './includes/dbconfig.php';

if (isset($_POST['signin'])) {
    $username = mysqli_escape_string($con,$_POST['username']);
    $password  = mysqli_escape_string($con,$_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Please enter both username and password.";
        header('Location: index.php');
        exit();
    }

    try {
        $check_data = $con->prepare("SELECT emp_uid, emp_pwd,role FROM employees WHERE emp_uid = ?");
        $check_data->bind_param("s", $username);
        $check_data->execute();
        $check_data->store_result();

        if ($check_data->num_rows > 0) {
            $check_data->bind_result($dbUsername, $dbPassword,$dbRole);

            if ($check_data->fetch()) {
                if ($password===$dbPassword) {
                    // Successful login - store the username in the session
                    $_SESSION['username'] = $username;
                    header('Location: index.php');
                    if($dbRole=="admin"){
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $username;
                    }
                    exit();
                } else {
                    
                    // $_SESSION['error'] =  $dbPassword;
                    $_SESSION['error'] =  $password;
                    header('Location: login-v2.php');
                    exit();
                }
            }
        } else {
            $_SESSION['error'] = "Username not found.";
            header('Location: login-v2.php');
            exit();
        }
    } catch (PDOException $e) {
        // Log the error and display a generic error message to the user
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again later.";
        header('Location: index.php');
        exit();
    }
}
?>
