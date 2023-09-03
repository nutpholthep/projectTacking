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
if(isset($_POST['emp_submit'])){
   $fname = $_POST['f_name'];
   $lname = $_POST['l_name'];
   $pattern = $_POST['pattern'];
   $sql = "INSERT INTO employees (emp_fname, emp_lname, emp_pwd,emp_uid)
VALUES ('$fname', '$lname', ' $pattern', $pattern)";
if ($con->query($sql) === TRUE) {
    // header("location:m_emp.php");
    echo " <script>
Swal.fire({
    icon: 'success',
    title: 'เพิ่มพนักงานสำเร็จ',
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