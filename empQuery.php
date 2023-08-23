<?php
require('./includes/dbconfig.php');
if(isset($_POST['emp_submit'])){
   $fname = $_POST['f_name'];
   $lname = $_POST['l_name'];
   $pattern = $_POST['pattern'];
   $sql = "INSERT INTO employees (emp_fname, emp_lname, emp_pwd,emp_uid)
VALUES ('$fname', '$lname', ' $pattern', $pattern)";
if ($con->query($sql) === TRUE) {
    header("location:m_emp.php");
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
}else{
    echo 2;
}