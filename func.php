<?php

//progressBar
function perProgess($data,$dateNow,$deadLine){

    if($dateNow<=$deadLine){
        return  '<div class="progress">' .
        '<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: ' . $data . '%;" aria-valuenow="' . $data . '" aria-valuemin="0" aria-valuemax="100">' . $data . '%' .
        '</div>' .
        '</div>';
    }else{
        return  '<div class="progress">' .
        '<div class="progress-bar bg-danger" role="progressbar" style="width: ' . $data . '%;" aria-valuenow="' . $data . '" aria-valuemin="0" aria-valuemax="100">' . $data . '%' .
        '</div>' .
        '</div>';
    }
       
}

//สูตรคำนวณProgressBar
function progress_Bar($id)
{
    include('./includes/dbconfig.php');
    $sql = "SELECT  COUNT(activity_progress),activity_progress,SUM(activity_progress) as bar
    FROM activity 
    WHERE  task_id = $id";
    $result=$con->query($sql);
    foreach($result as $val){
        
        // $val['COUNT(activity_progress)'];
        return  $val = intval(($val['bar'] * 100) / ($val['COUNT(activity_progress)'] * 100));
    }
}
//สูตรคำนวณProgressBarโดยรวม
function Total_progress($id)
{
    include('./includes/dbconfig.php');
   
        $sql = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id,a.activity_progress,SUM(a.activity_progress) as bar,COUNT(a.activity_id)
        FROM project_create AS p
        LEFT JOIN task as t on t.project_id = p.project_id
        LEFT JOIN activity AS a on a.task_id = t.task_id
        WHERE p.project_id= $id";
        $result=$con->query($sql);

        foreach($result as $val){
           
            if($val['COUNT(a.activity_id)']==0){
                return 0;
            }else{
                return    $val = intval(($val['bar'] * 100) / ($val['COUNT(a.activity_id)'] * 100));
            }
           
        } 
}

function projectId(){
   include('./includes/dbconfig.php');
    $sql = "SELECT project_id,project_name
        FROM project_create";

        $result = $con->query($sql);
        $projectIds = array();
        foreach($result as $val){
            $projectIds[] = $val['project_id'];
        }
        return $projectIds;
}

// แสดงรายละเอียดโปรเจค
function detail($id){
   include('./includes/dbconfig.php');
    $sql ="SELECT  p.project_name,p.dead_line,p.owner,p.detail,emp.emp_fname,emp.emp_lname
    FROM project_create AS p 
    LEFT JOIN employees AS emp on emp.emp_id = p.owner
    WHERE p.project_id =$id";


    $result= $con->query($sql);
    foreach($result as $val){
        return $val;
    }
}

// แสดงรายละเอียดคนสร้าง
function create_by($id){
   include('./includes/dbconfig.php');
    $sql ="SELECT  emp.emp_fname,emp.emp_lname,p.create_by,p.create_time
    FROM project_create AS p 
    LEFT JOIN employees AS emp on emp.emp_id = p.create_by
    WHERE p.project_id =$id";


    $result= $con->query($sql);
    foreach($result as $val){
        return $val;
    }
}
// แสดงรายละเอียดอัพเดทโดยใคร
function update_by($id){
   include('./includes/dbconfig.php');
    $sql ="SELECT  emp.emp_fname,emp.emp_lname,p.update_by,p.update_time
    FROM project_create AS p 
    LEFT JOIN employees AS emp on emp.emp_id = p.update_by
    WHERE p.project_id =$id";


    $result= $con->query($sql);
    foreach($result as $val){
        return $val;
    }
}

function barChart($id){
   include('./includes/dbconfig.php');
    $sql = "SELECT 
    p.project_name,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id 
HAVING 
    total = 100";

return $result = $con->query($sql);
}

function inBar($id){
   include('./includes/dbconfig.php');
    $sql = "SELECT 
    p.project_name,
    p.status,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id AND p.status =1
HAVING 
    total <> 100";
  return $result = $con->query($sql);
}

// Fillterโปรเจค100%
function fillter($id){
   include('./includes/dbconfig.php');
    $sql = "SELECT 
    p.project_name,
    t.project_id,
    t.task_id,
    a.activity_id,
    a.activity_progress,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id AND p.status =1
HAVING 
    total = 100";

$result = $con->query($sql);


foreach($result as $val){
    return intval($val['total']);
}
}

// Fillterที่ไม่สำเร็จ
function fillterInComplete($id){
   include('./includes/dbconfig.php');
    $sql = "SELECT 
    p.project_name,
    p.status,
    t.project_id,
    t.task_id,
    a.activity_id,
    a.activity_progress,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id AND p.status =1
HAVING 
    total <> 100 AND p.status =1 ";

$result = $con->query($sql);


foreach($result as $val){
    return intval($val['total']);
}
}


// เอาวันที่สิ้นสุดโปรเจค
function taskDeadLine($id){
   include('./includes/dbconfig.php');
    $sql="SELECT dead_line
    FROM task 
    WHERE project_id = $id";

    $result = $con->query($sql);

    foreach($result as $val){
        return $val;
    }

}

// หน้าReport Start
function countOwner(){
   include('./includes/dbconfig.php');
    $sql ="SELECT emp.emp_fname,emp.emp_lname,COUNT(p.owner) as project_count,CONCAT(emp_fname,' ',emp_lname) as FullName
    FROM project_create AS p
    LEFT JOIN employees AS emp ON emp.emp_id = p.owner
    GROUP BY p.owner
    ORDER BY project_count DESC
    LIMIT 5";

return $result = $con->query($sql);

}

function topFiveMonthUpdate(){
   include('./includes/dbconfig.php');
    $sql="SELECT ac.activity_id,ac.update_time,p.project_id,p.project_name,COUNT(p.project_id) AS project_count
    FROM project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
    LEFT JOIN history_acitivity AS ac on ac.activity_id = a.activity_id
    WHERE MONTH(ac.update_time) = MONTH(now())
           and YEAR(ac.update_time) = YEAR(now())
     GROUP BY p.project_id
     ORDER BY project_count DESC
     LIMIT 5";

return $result = $con->query($sql);
}

// หน้าReport End
function timeline($TaskId,$ProId){
    include('./includes/dbconfig.php');
    $today=date('Y-m-d');
$sql="SELECT ac.activity_id,ac.activity_name,ac.update_time,task.task_id,task.project_id,ac.act_value,ac.update_by,emp.emp_fname,emp.emp_lname
FROM history_acitivity AS ac
LEFT JOIN activity ON activity.activity_id = ac.activity_id
LEFT JOIN task ON task.task_id = activity.task_id
LEFT JOIN employees AS emp ON emp.emp_id = ac.update_by
WHERE task.task_id =$TaskId AND task.project_id =$ProId";
   $result = mysqli_query($con,$sql);
  while($row = mysqli_fetch_assoc($result )){
  
    if($pre !==date('d/m/Y',strtotime($row['update_time']))){
        echo '<div class="time-label">
        <span class="bg-info">
          '.date('d/m/Y',strtotime($row['update_time'])).'
        </span>
      </div>
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <div>
      
      <i class="fa-solid fa-circle-check fa-2xl" style="color: #00ff33;"></i>';
    }
  else{
    echo'<div class="time-label">
   
  </div>
  <!-- /.timeline-label -->
  <!-- timeline item -->
  <div>
  <i class="fa-solid fa-circle-check fa-2xl" style="color: #00ff33;"></i>';
  }
  echo'
    <div class="timeline-item">
      <span class="time"><i class="far fa-clock"></i>'.date('H:i',strtotime($row['update_time'])).'</span>
  
      <h3 class="timeline-header"><a href="#">Update Activity</a> '.$row['activity_name'].'</h3>
  
      <div class="timeline-body">
        <h4>ทำการอัพเดทความคืบหน้าที่'.$row['act_value'].'%</h4>
      </div>
      <div class="timeline-footer">
      <h5 class="timeline-header"><a href="#">คนที่อัพเดท</a> '.$row['update_by'].$row['emp_fname'].$row['emp_lname'].'</h5>
      </div>
    </div>
  </div>';
  $pre = date('d/m/Y',strtotime($row['update_time']));
}
  }
//   <a href="#" class="btn btn-primary btn-sm">Read more</a>
//   <a href="#" class="btn btn-danger btn-sm">Delete</a>
  
  