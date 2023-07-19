<?php
echo $deadline = "2023-06-16";
 $lim = date('Y-m-d');
echo'<br>';
$time_line = array();
while(strtotime($lim)<strtotime($deadline)){
    $time_line[] +=strtotime($lim++);
    echo'<br>';
}
 $sum_date =count($time_line);
 echo "คุณเหลือเวลาทำอีก ".$sum_date." วัน";
