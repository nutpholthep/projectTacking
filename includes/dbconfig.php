<?php
$serverName ="localhost";
$dbUsername ="root";
$dbPassword="";
$dbName="project_tracking";

$con = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);

if(!$con){
    die("Connection failed".mysqli_connect_error());
}

// เชื่อมต่อฐานข้อมูล
// $con=mysqli_connect("localhost","root","","project_tracking") or die("เกิดข้อผิดพลาด");
?>