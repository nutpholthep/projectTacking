<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
</body>
</html>
<?php
require('./includes/dbconfig.php');
// เพิ่มโปรเจค
$pname = $_POST['project_Name']; //ชื่อโปรเจค
// $fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
// $lname= $_POST['project_Owner_lname']; //นามสกุลเจ้าของโปรเจค

$ownerId = $_POST['idemp']; //ชื่อเจ้าของโปรเจค
$detail= $_POST['detail']; //รายละเอียดงาน
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$createby = $_POST['create_by']; //สร้างโดย
// $team = $_POST['team']; //สมาชิกทีม

//เลือกลูกทีม
// print_r($_POST);
// exit;

$sql = " INSERT INTO project_create (project_name,owner,detail,dead_line,create_by) VALUE ('$pname','$ownerId','$detail','$date','$createby')";

$result = mysqli_query($con,$sql);

// echo " <script>
// Swal.fire({
//     icon: 'success',
//     title: 'สร้างโปรเจคสำเร็จ',
//     showConfirmButton: false,
//     timer: 1500
// }).then(function() {
//     // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
//     window.location.href = 'task.php';
// });
// </script>";

if($result){
// เอาค่าโปรเจคIDล่าสุด
echo " <script>
Swal.fire({
    icon: 'success',
    title: 'สร้างโปรเจคสำเร็จ',
    showConfirmButton: false,
    timer: 1500
}).then(function() {
    // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
    window.location.href = 'task.php';
});
</script>";
// header('location:task.php');
}else{
    mysqli_error($con);
}

?>