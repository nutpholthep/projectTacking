<?php
// ลบActivity
require('./includes/dbconfig.php');
$pro =$_GET['idp'];
$actModal = $_GET["actid"]; ///เอามาจากปุ่มลบในModalMainPage
$actFormMain = $_POST['actMain'];
// print_r($_POST);
// print_r($_GET);
// exit();
if(isset($task)){
    $task = $_GET["idact"]; ///เอามาจากปุ่มลบในModalActivity
    $sql = "UPDATE activity SET status =0
WHERE activity_id =$task ";
$result = mysqli_query($con,$sql);

if($result){
    header("location:./task.php");
 
}
else{
    echo "เกิดข้อผิดพลาด";
}
}

if(isset($actFormMain)){
    $sql = "UPDATE activity SET status =0
WHERE activity_id =$actModal";
$result = mysqli_query($con,$sql);
// echo $actModal;
if($result){
    header("location:mainpage.php?idp=".$pro);
 
}
else{
    echo "เกิดข้อผิดพลาด";
}
}

?>