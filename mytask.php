<?php
// error_reporting(0);
session_start();
include('./func.php');
require('./includes/dbconfig.php');
$order = 1;
$sql2 = "SELECT DISTINCT project_create.project_name, task.task_name, task.task_id, activity.activity_name, activity.activity_progress, project_create.detail, activity.activity_id,project_create.project_id, task.dead_line,team.team_member
FROM task
LEFT JOIN project_create ON project_create.project_id = task.project_id
LEFT JOIN activity ON task.task_id = activity.task_id 
LEFT JOIN team ON team.task_id = task.task_id
LEFT JOIN employees AS emp ON emp.emp_uid = team.team_member
WHERE team.team_member = ".$_SESSION['username']." AND activity.activity_id IS NOT NULL  AND project_create.status NOT IN (0)
ORDER BY task.task_id";

$result_task = mysqli_query($con, $sql2);
$taskName ='';
$prev=null;
$dateNow = strtotime('now');
// $deadLine = strtotime($taskDeadLine['dead_line']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Project_tracking</title>
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="./img/pic.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="shortcut icon" href="./img/pic.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            $(".open_Edact").click(function() {

let idx = $(this).attr('idx');

$.post("modalEditActivity.php", {

    id: idx
  },
  function(result) {
    console.log(result);
    $("#modal_edit_activity").html(result);
  }
);


});
// modal update
$(".open_update").click(function() {

let idx = $(this).attr('idx');
// let idp = "< ?php echo $_GET['idp'] ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
$.post("modalupdate.php", {
    id: idx,
    // idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
  },
  function(result) {
    console.log(result);
    $("#modal_update").html(result);
  }
);


});
           

        });
    </script>
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
        <?php
        include('./navbar.php');
        include('./aside.php');
        ?>
        <div class="content-wrapper">
            <div class="content">
                <h1>หน้างานของฉัน</h1>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">ดูรายละเอียดของงานที่ฉันได้รับมอบหมาย</h3>
                                    </div>

                                    <div class="card-body">
                                    <table class=" table table-light  mt-2 display responsive nowrap" id="progress">
                          <thead class="table-dark">
                            <tr>
                              <th>ลำดับที่</th>
                              <th>ชื่องาน</th>
                              <th>กิจกรรมย่อย</th>
                              <th>Action</th>
                              <th>ความคืบหน้ากิจกรรมย่อย</th>
                              <th>ความคืบหน้าทั้งหมด</th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php while ($task = mysqli_fetch_assoc($result_task)) { ?>


                              <?php
                              //  $id =$task['project_id'];
                              //  $taskDeadLine = taskDeadLine($id);
                              $deadLine = strtotime($task['dead_line']);
                              $st2 = date('d/m/Y', $deadLine);
                              if ($taskName != $task['task_name']) {
                                echo '<tr class="bg-secondary">';
                                echo '<td class="text-end">' . $order++ . '</td>';
                                echo '<td><h5>' . $task["task_name"] . '</h5></td>';
                                echo '<td class="badge badge-pill badge-info text-wrap ">'.checkTime($dateNow,$deadLine). '</td>
                                            <td></td>
                                            <td></td>';

                                $progress = progress_Bar($task['task_id']);
                                if ($prev == $progress) {
                                  echo '<td></td>';
                                } else {
                                  echo '<td> ' . $display = perProgess($progress, $dateNow, $deadLine) . '</td>';
                                }
                                $prev = $progress;
                                echo '</tr>';
                              } ?>

                              <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo $task["activity_name"]; ?></td>
                                <?php if ($task['activity_progress'] == 100) {
                                
                                  if ($dateNow <= $deadLine) {
                                    echo '<td class="text-success">
                                                <p class="fw-bolder text-uppercase">Complete</p>';
                                    echo '</td>';
                                  } else {
                                    echo '<td class="text-danger">
                                                <p class="fw-bolder text-uppercase">Overtime</p>';
                                    echo '</td>';
                                  }
                                } else {
                                  echo '<td> <a href="#" class=" btn btn-success open_update " data-toggle="modal" idx="' . $task["activity_id"] . '" data-target="#add_update"><i class="fa-solid fa-rotate-right"></i>
                                                </a>';

                                  echo ' <a href="#" class="btn bg-warning open_Edact" data-target="#edit_activity" data-toggle="modal" idx=" ' . $task["activity_id"] . ' "><i class="fa-regular fa-pen-to-square"></i></a></td>';
                                }


                                ?>
                                <td><?php echo $display = perProgess($task['activity_progress'], $dateNow, $deadLine);  ?></td>
                                <td></td>
                              </tr>
                            <?php
                              //   ความคืบหน้าโปรเจคทั้งหมด
                              //    echo $task['activity_id'];
                              $taskName = $task['task_name'];

                            //   $progress_proj = Total_progress($id);
                            }
                            ?>

                            

                          </tbody>
                        </table>
                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

        </div>

    </div>



    </section>


    <!-- modal activity -->
    <div class="modal fade " id="add_act">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มกิจกรรมย่อยในงาน </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal_act"></div>
                </div>
            </div>

        </div>
    </div>

    </div>

    <div class="modal fade " id="add_update">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h1>
          <button type="button" class="btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="modal_update"></div>
        </div>
      </div>
    </div>
  </div>


  <!-- modal edit activity -->
  <div class="modal fade " id="edit_activity">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="modal_edit_activity"></div>
        </div>
      </div>
    </div>
  </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="navtoggle.js"></script>
    <script>
       work.classList.toggle('active');
    </script>
</body>

</html>