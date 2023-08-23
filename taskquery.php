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
$task_name= $_POST["addTask"];
$project_id = $_POST["project_id"];
$task_emp =$_POST['task_emp'];
$datetask =$_POST['datetask'];
// $pid = $_POST['project_id'];
// echo $idt;
// print_r($_POST);
// exit;

$sql = "INSERT INTO task (task_name,project_id,dead_line) 
VALUES ('$task_name','$project_id','$datetask')";
$result = mysqli_query($con,$sql);
if($result){
// เอาค่าโปรเจคIDล่าสุด
$que = "SELECT p.project_id,p.project_name,task.task_id,task.task_name,MAX(task.task_id)
FROM project_create AS p
LEFT JOIN task on task.project_id = p.project_id
WHERE p.project_id =$project_id";
$result2=mysqli_query($con,$que);
$t=mysqli_fetch_assoc($result2);
$maxID=$t['MAX(task.task_id)']; 


if($result2){
 //เอาโปรเจคIDล่าสุดและลูปเพื่อสมาชิกภายในทีมออกมา
 foreach($task_emp as $teamNew){
     // echo $teamNew;
     $sql2 = "INSERT INTO team (team_member,project_id,task_id)
     VALUES ($teamNew,$project_id,$maxID)"; 
     // echo $sql2;
//      print_r($_POST);
// exit;
     $result3=mysqli_query($con,$sql2);
 }
}
echo " <script>
Swal.fire({
    icon: 'success',
    title: 'เพิ่มงานสำเร็จ',
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