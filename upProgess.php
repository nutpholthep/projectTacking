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
$pro =$_POST['idp'];
$i = $_POST['act_id'];
$act_name = $_POST['act_name'];
$idupdate = $_POST['act_update'];
$update_by = $_POST['update_by'];
// $result_progessBar = $_POST['result_progessBar'];
$prev_value = $_POST['prev_value'];

// print_r($_POST);
// exit;
if($prev_value == $idupdate){
    echo '<script>
      Swal.fire({
        title:"ไม่สามารถเพิ่มค่าน้อยกว่าหรือเท่ากับค่าปัจจุบันได้",
        icon:"error"
      }).then(()=>{
        history.back()
      });
     
    </script>';
    // header("location:mainpage.php?idp=".$_POST['idp']);
}else{
    $sql= "UPDATE activity SET activity_progress ='$idupdate'
    WHERE activity_id = '$i'";
    // echo $sql;
    $result = mysqli_query($con,$sql);
    if($result){
        // รับค่าที่ส่งจากหน้าupprogress
       
       $history ="INSERT INTO history_acitivity (update_by,activity_id,activity_name,act_value) 
        VALUES('$update_by','$i','$act_name','$idupdate')";
        $hisQuery = mysqli_query($con,$history);

        if($hisQuery){
            echo " <script>
Swal.fire({
    icon: 'success',
    title: 'อัพเดทความคืบหน้าสำเร็จ',
    showConfirmButton: false,
    timer: 1500
}).then(function() {
    // เมื่อผู้ใช้ปิดกล่อง Swal ให้นำทางไปยังหน้าอื่น
    window.location.href = 'mainpage.php?idp=". $_POST['idp'] ."';
})
</script>";
//  
if(!$_POST['idp']){
    header("location:./mytask.php");
}

        }
    }else{
        mysqli_error($con);
    }
}

   
