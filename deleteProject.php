
<?php
// ลบโปรเจค
require('./includes/dbconfig.php');
$id = $_GET['iddel'];//รับไอดีจากหน้าDisplay

$sql = "UPDATE project_create
INNER JOIN task ON project_create.project_id = task.project_id
INNER JOIN activity ON task.task_id = activity.task_id
SET project_create.status = 0, task.status = 0, activity.status = 0
WHERE project_create.project_id = $id";


$result = mysqli_query($con,$sql);

if($result){
  
   header("location:tem_display.php");
}else{
    mysqli_error($con);
}

?>