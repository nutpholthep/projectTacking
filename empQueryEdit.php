<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php

require('./includes/dbconfig.php');
if(isset($_POST['emp_edit'])){
   $id = $_POST['id'];
   $fname = $_POST['f_name'];
   $lname = $_POST['l_name'];
   $pwd = $_POST['pwd'];
   $role = $_POST['role'];
   $status = $_POST['status'];
// print_r($_POST);
// exit;

$sql = "UPDATE employees SET
emp_fname = '$fname',emp_lname = '$lname',emp_pwd = '$pwd',
role = '$role', status = '$status'
WHERE emp_uid = '$id'";
if($con->query($sql)=== TRUE){
    // header("location:m_emp.php");
    echo " <script>
Swal.fire({
    icon: 'success',
    title: 'แก้ไขสำเร็จ',
    showConfirmButton: false,
    timer: 1500
}).then(function() {
    // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
    window.location.href = 'm_emp.php';
});
</script>";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
}else{
    echo 2;
}