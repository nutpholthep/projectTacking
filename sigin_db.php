<?php
session_start();
require_once './includes/dbconfig.php';

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $_SESSION['error'] = "รหัสพนักงานผิด";
        header('location: sigin.php');
    } else if (empty($password)) {
        $_SESSION['error'] = "กรุณากรอกรหัสผ่าน";
        header('location: sigin.php');
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        $_SESSION['error'] = "รหัสผ่านต้องมีความยาวระหว่าง 5-20 ตัวอักษร";
        header('location: index.php');
    } else {
        try {
            $check_data = $con->prepare("SELECT emp_id, emp_pwd FROM employees WHERE emp_id = ?");
            $check_data->bind_param("s", $username);
            $check_data->execute();
            $check_data->store_result();

            if ($check_data->num_rows > 0) {
                $check_data->bind_result($dbUsername, $dbPassword);

                echo password_verify($password, $dbPassword);
                if ($check_data->fetch()) {
                    if ($username === $dbUsername) {
                       
                        if (password_verify($password, $dbPassword)) {
                            header('location: ss.php');
                        } else {
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header('location: login-v2.php');
                        }
                    } else {
                        $_SESSION['error'] = 'อีเมลผิด';
                        header('location: login-v2.php');
                    }
                }
            } else {
                $_SESSION['error'] = "ไม่มีในระบบ";
                header('location: login-v2.php');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
