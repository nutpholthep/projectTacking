<?php
session_start();
include('./func.php');
include('./includes/dbconfig.php');
error_reporting(0);
$id = $_GET['idp'];
$total = 0;
$numTask = 0;
$total_progress = 0;

$order = 1;
$detail = detail($id);
$create_by = create_by($id);
$update_by = update_by($id);
$taskDeadLine = taskDeadLine($id);

$sql2 = "SELECT DISTINCT project_create.project_name, task.task_name, task.task_id, activity.activity_name, activity.activity_progress, project_create.detail, activity.activity_id,project_create.project_id, task.dead_line
FROM task
RIGHT JOIN project_create ON project_create.project_id = task.project_id
RIGHT JOIN activity ON task.task_id = activity.task_id 
WHERE project_create.project_id = $id
ORDER BY task.task_id";

$result_task = mysqli_query($con, $sql2);
// $task_query = mysqli_fetch_assoc($result_task);

$IdTask;
$taskName = "";

// ตารางพนักงาน
$emp = "SELECT t.team_member,t.project_id,emp.emp_fname,emp.emp_lname,task.task_id,task.task_name
FROM team AS t
LEFT JOIN employees AS emp ON emp.emp_id = t.team_member
LEFT JOIN task on task.task_id = t.task_id
WHERE t.project_id=$id
ORDER BY t.team_member ASC";
// SELECT team_member 
// FROM team
// LEFT JOIN employees as emp on emp_code = team_member
$result_emp = mysqli_query($con, $emp);
// echo $emp;
$a = "";
$deadline = $detail['dead_line'];

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<script>
  $(document).ready(function() {
    // modal หน้าแก้ไขรายละเอียดทั้งหมด
    // $("#open_edit").click(function() {

    //   let idx = $(this).attr('idx');

    //   $.post("modaledit.php", {
    //       id: idx
    //     },
    //     function(result) {
    //       $("#modal_edit").html(result);
    //     }
    //   );


    // });
    $("#open_edit").click(function() {
      let idx = $("#idx").val();

      $.post("modaledit.php", {
        id: idx
      }, function(result) {
        // $("#modal_edit").html('');
        console.log(result);
        $("#modal_edit").html(result);
      });
    });

    // modal หน้าแก้ไขActivity
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
      let idp = "<?php echo $_GET['idp'] ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
      $.post("modalupdate.php", {
          id: idx,
          idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
        },
        function(result) {
          console.log(result);
          $("#modal_update").html(result);
        }
      );


    });

    // var groupColumn = 2;
    // สร้างProgress_Bar

    let table = $('#progress').DataTable({

      responsive: true,
      "ordering": false,
      // ที่ต้องใส่ordering เพราะถ้าให้เรียงแบบขึ้นแถวใหม่เป็นเลเวลต้องยกเลิกการเรียงลำดับ

      "processing": true,
      "autoWidth": true,
      "columnDefs": [{
          "targets": 4,
        },
        {
          responsivePriority: 1,
          targets: 2
        },
        {
          responsivePriority: 2,
          targets: -1
        },



      ],

    });

    let teammem = $('#teammem').DataTable({
      scrollY: '40vh',
      scrollCollapse: true,
      paging: false,
      "ordering": false
    });



  });
</script>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <?php
    include('./navbar.php');
    include('./aside.php');
    ?>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>รายละเอียดโปรเจค <?php echo $detail['project_name'] ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $detail['project_name'] ?></li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">

                  <h3 class="profile-username text-center"><?php echo $detail['project_name'] ?></h3>

                  <!-- <p class="text-muted text-center">Software Engineer</p> -->

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>เจ้าของโปรเจค</b> <a class="float-right"><?php echo $detail['owner'] . " " . $detail['emp_fname'] . " " . $detail['emp_lname'] ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>คนที่สร้างโปรเจค</b> <a class="float-right"><?php echo $create_by['create_by'] . " " . $create_by['emp_fname'] . " " . $create_by['emp_lname'] ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>วันที่สร้างโปรเจค</b> <a class="float-right"><?php echo date("d/m/Y ", strtotime($create_by['create_time'])) ?> </a>
                    </li>
                  </ul>

                  <div>
                    <input type="hidden" id="idx" name="$edit_id" value="<?php echo $id ?>">
                    <a href="#" id="open_edit" class="btn btn-warning" data-toggle="modal" data-target="#edit_page">แก้ไขรายละเอียด <span class="lnr lnr-pencil fw-bold"></span></a>
                    <a href="deleteProject.php?iddel=<?php echo $id ?>" class="btn btn-danger" onclick="confirmDelete(event, <?php echo $id ?>)">ลบโปรเจค<span class="lnr lnr-trash  "></span>
                      </svg></a>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">รายละเอียดเพิ่มเติม</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <strong><i class="fas fa-book mr-1"></i> วันที่สิ้นสุดโปรเจค</strong>

                  <p class="text-muted">
                    <?php echo date("d/m/Y", strtotime($deadline)) ?>
                  </p>

                  <hr>

                  <strong><i class="fas fa-map-marker-alt mr-1"></i> วันที่อัพเดทโปรเจค</strong>

                  <p class="text-muted"><?php echo date("d/m/Y", strtotime($update_by['update_time'])) ?></p>

                  <hr>

                  <strong><i class="fas fa-pencil-alt mr-1"></i>คนที่อัพเดทโปรเจคล่าสุด</strong>

                  <p class="text-muted">
                    <?php echo $update_by['update_by'] . " " . $update_by['emp_fname'] . " " . $update_by['emp_lname'] ?>
                    <!-- <span class="tag tag-danger">UI Design</span>
                    <span class="tag tag-success">Coding</span>
                    <span class="tag tag-info">Javascript</span>
                    <span class="tag tag-warning">PHP</span>
                    <span class="tag tag-primary">Node.js</span> -->
                  </p>

                  <hr>

                  <strong><i class="far fa-file-alt mr-1"></i>คำอธิบายโปรเจค</strong>

                  <p class="text-muted"><?php echo $detail['detail'] ?></p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" href="#edit_timeline" data-toggle="tab">Edit Timeline</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <!-- Post -->
                      <div class="post">
                        <div class="user-block">
                          <h2 class="text-center">รายละเอียดงาน</h2>
                        </div>
                        <!-- /.user-block -->
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
                              if ($taskName != $task['task_name']) {
                                echo '<tr class="table-secondary">';
                                echo '<td class="text-end">' . $order++ . '</td>';
                                echo '<td><h5>' . $task["task_name"] . '</h5></td>';
                                echo '<td></td>
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
                                   $dateNow = strtotime('now');
                                  $deadLine = strtotime($taskDeadLine['dead_line']);
                                  $st2 = date('d/m/Y', $deadLine);
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

                              $progress_proj = Total_progress($id);
                            }
                            ?>

                            <?php
                            //ตัวแปรที่เก็บค่าสูตรคำนวณโดยวิธีคิด จำนวนActtivityทั้งหมด*100/จำนวนแถวทั้งหมด
                            if ($progress_proj == 0) { ?>

                              <div id="detailProgress">
                                <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                  <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:0%">0
                                  </div>
                                </div>
                              </div>
                            <?php  } else {

                              //  คำสั่งQueryคำนวณ
                            ?>
                              <div id="detailProgress">
                                <input type="hidden" name="result_progessBar" value="<?php echo $progress_proj ?>">
                                <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="<?php echo  $progress_proj ?>" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                  <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:<?= $progress_proj ?>%"><?php echo  $progress_proj . '%'; ?>
                                  </div>
                                </div>
                              </div>
                            <?php  } ?>

                          </tbody>
                        </table>
                      </div>
                      <!-- /.post -->

                      <!-- Post -->

                      <!-- /.post -->


                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                      <!-- The timeline -->
                      <div class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <?php
                        ///ERROR MODAL
                        $pros = "SELECT p.project_id, task.task_id
                         FROM project_create AS p
                         LEFT JOIN task ON task.project_id = p.project_id";
                        $out = mysqli_query($con, $pros);
                        while ($cols = mysqli_fetch_assoc($out)) {
                          $task_id = $cols['task_id'];
                          $p_id = $cols['project_id'];
                          $que_act = "SELECT ac.activity_id, ac.activity_name, ac.update_time, task.task_id, task.project_id, ac.act_value
                          FROM history_acitivity AS ac
                          LEFT JOIN activity ON activity.activity_id = ac.activity_id
                           LEFT JOIN task ON task.task_id = activity.task_id
                          WHERE task.task_id = '$task_id' AND task.project_id = '$id'";
                          $result = mysqli_query($con, $que_act);
                          while ($row = mysqli_fetch_assoc($result)) {
                            $task_ids = $row['task_id'];
                            $p_id = $row['project_id'];
                            $acti_ID = $row['activity_id'];

                            //  edittimeline($id);
                          }
                        }
                        timeline($task_ids, $id);

                        ?>
                        <!-- END timeline item -->

                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                    </div>
                    <!-- /.tab-pane -->
                    <!-- /.card-body -->

                    <div class="tab-pane" id="edit_timeline">
                      <!-- The timeline -->
                      <div class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <?php
                        edittimeline($id);
                        ?>
                        <!-- END timeline item -->

                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  </div>
  </div>





  <!-- modal -->
  <!-- แก้ไขข้อมูลในหน้าแสดงผลด้วย Modal -->
  <!-- <div class="modal fade " id="edit_page" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title ">แก้ไขรายละเอียดทั้งหมด</h1>
       
          <button class="btn btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="modal_edit"></div>
        </div>
      </div>
    </div>
  </div> -->

  <div class="modal fade" id="edit_page" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">แก้ไขรายละเอียดทั้งหมด</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="modal_edit"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- modal update -->
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

  <!-- modal ระบุว่าใครเป็นรับผิดชอบงานไหน -->
  <div class="modal fade " id="add_memberTask">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">เลือกงานที่รับผิดชอบ</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="modal_add_memberTask"></div>
        </div>
      </div>
    </div>
  </div>



  <script>
    display.classList.toggle('active');
    function confirmDelete(event, projectId) {
    event.preventDefault();
    Swal.fire({
        title: 'ต้องการลบโปรเจคหรือไม่?',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ยกเลิก',
        // reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'ลบโปรเจคสำเร็จ!',
                'คุณได้ทำงานลบสำเร็จแล้ว.',
                'success'
            ).then(() => {
                // Redirect after the SweetAlert dialog is closed
                window.location.href = './deleteProject.php?iddel=' + projectId;
            });
        }
    });
}
  </script>

  <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
  <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
  <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>



</body>

</html>