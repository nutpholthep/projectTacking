<?php
session_start();
unset($_SESSION['username']);
// unset($_SESSION['admin_login']);
session_destroy();
header('location:login-v2.php');
exit();
