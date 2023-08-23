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
emp_fname = '$fname',emp_fname = '$lname',emp_pwd = '$pwd',
role = '$role', status = '$status'
WHERE emp_uid = '$id'";
if($con->query($sql)=== TRUE){
    header("location:m_emp.php");
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
}else{
    echo 2;
}