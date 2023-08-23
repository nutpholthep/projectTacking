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
$task_id =$_POST['task_id'];
$act_id = $_POST['actid'];
$eAct_id =$_POST['edit_act'];
$pro_id =$_POST['id'];
$edit_by =$_POST['edit_by'];
$b_name =$_POST['b_name'];

$sql = "UPDATE activity 
SET activity_name = '$eAct_id'
WHERE activity_id =$act_id and task_id = $task_id";
// print_r($_POST);
// exit;
$result =mysqli_query($con,$sql);


if($result){
  $history_edit ="INSERT INTO history_edit_activity(edit_by,activity_id,activity_name,b_name) 
  VALUE('$edit_by','$act_id','$eAct_id','$b_name')";
$history_query = mysqli_query($con,$history_edit);
// print_r($_POST);
// exit;

if($history_query){
  echo " <script>
  Swal.fire({
      icon: 'success',
      title: 'แก้ไขกิจกรรมย่อยสำเร็จ',
      showConfirmButton: false,
      timer: 1500
  }).then(function() {
      // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
      window.location.href = 'mainpage.php?idp=".$pro_id."';
  })
  </script>";
    // header("location:mainpage.php?idp=".$pro_id);
}
 }else{
     mysqli_error($con);
 }





?>