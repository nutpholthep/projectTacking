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
include('./includes/dbconfig.php');
$id = $_POST['idedit']; //โปรเจคId
$pname = $_POST['project_Name']; //ชื่อโปรเจค
$owner =$_POST['owner']; //ชื่อเจ้าของโปรเจค
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$updateTime = $_POST['update_time']; //กำหนดเวลาของโปรเจค
$update_By = $_POST['update_by'];//ชื่อคนที่อัปเดต
$datail =$_POST['detail'];
// print_r($_POST);
// exit;
$sql = "UPDATE project_create
SET project_name='$pname',owner='$owner',dead_line='$date',update_time='$updateTime',update_by='$update_By',detail='$datail'
WHERE project_id = $id ";


$result = mysqli_query($con,$sql);
if($result){
    echo " <script>
    Swal.fire({
        icon: 'success',
        title: 'อัพเดทความคืบหน้าสำเร็จ',
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
        // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
        window.location.href = 'mainpage.php?idp=". $_POST['idedit'] ."';
    })
    </script>";
    // header('location:mainpage.php?idp='.$_POST['idedit']);
   

}else{
    mysqli_error($con);
}

?>