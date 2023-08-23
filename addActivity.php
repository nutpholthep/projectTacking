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
// เพิ่มActivity
require('./includes/dbconfig.php');
$idact = $_POST['act_name']; //รับข้อมูลจากหน้าTaskเพื่อเป็นModalเพิ่มActivity
$task_id = $_POST['task'];
// print_r($_POST);
// exit;
$sql = "INSERT INTO activity (activity_name,task_id) VALUES ('$idact','$task_id')";
$result = mysqli_query($con,$sql);

if($result){
    echo " <script>
Swal.fire({
    icon: 'success',
    title: 'เพิ่มกิจกรรมย่อย',
    showConfirmButton: false,
    timer: 1500
}).then(function() {
    // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
    window.location.href = 'task.php';
});
</script>";
    // header("location:task.php");

}
else{
    echo "เกิดข้อผิดพลาด";
}
?>