<?php
// ไฟล์นี้จะเป็นไฟล์เพียงอันเดียวเพื่อดึงข้อมูลเวลาสิ้นสุดของโปรเจกต์จากฐานข้อมูล

// เชื่อมต่อกับฐานข้อมูล
require('./includes/dbconfig.php');

if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลเวลาสิ้นสุดของโปรเจกต์
    $sql = "SELECT dead_line FROM project_create WHERE project_id = $project_id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $projectDeadline = $row['dead_line'];

        // ส่งข้อมูลเวลาสิ้นสุดของโปรเจกต์กลับให้กับ JavaScript
        echo $projectDeadline;
    }
}

?>
