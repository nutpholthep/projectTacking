<?php
include('./func.php');
include('./includes/dbconfig.php');
$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id,project_create.create_time,project_create.dead_line,project_create.detail,employees.emp_fname,employees.emp_lname,project_create.create_by,project_create.project_id,project_create.owner
FROM task
right JOIN  project_create ON project_create.project_id = task.project_id
right JOIN  employees ON project_create.owner = employees.emp_id 
WHERE project_create.detail IS null OR project_create.status NOT IN(0)
GROUP BY project_create.project_id";
$result_task = mysqli_query($con, $sql2);
$order = 1;
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
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
    <script>
        // สร้างDataTable
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                responsive: true,

                "columnDefs": [{
                        // progress_Bar
                        "targets": 7,
                        "render": function(data, type, row, meta) {
                            return '<div class="progress mt-3">' +
                                '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        // ช่องคำอธิบายมีตัวอักษรไม่เกิน 20 ตัว
                        "targets": 4,
                        "data": "description",

                        "render":

                            function(data, type, row, meta) {
                                return type === 'display' && data.length > 20 ?
                                    '<span title="' + data + '">' + data.substr(0, 20) + '...</span>' :
                                    data;
                            }

                    }
                ],


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
        <h1>หน้าสำหรับดูรายละเอียดโปรเจคในรูปแบบDatatable</h1>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">ดูรายละเอียดโปรเจคในรูปแบบDatatable</h3>
                  </div>

                  <div class="card-body">
                  <div class="dropdown d-flex justify-content-end mb-2 ">
                <button class="btn btn-primary " dropdown-toggle type="button" data-toggle="dropdown" aria-expanded="false">
                   Filter Project
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./display.php">Default</a></li>
                    <li><a class="dropdown-item" href="./display.php?status=1">Complete</a></li>
                    <li><a class="dropdown-item" href="./display.php?status=2">InComplete</a></li>
                </ul>
            </div>

            <table id="myTable" class="table table-striped table-bordered display responsive nowrap  ">
                <thead class="table-dark text-center">
                    <tr class="text-center">
                        <th class="text-center">ลำดับที่</th>
                        <th class="text-center">ชื่อโปรเจค</th>
                        <th class="text-center">ดูรายละเอียดโปรเจค</th>
                        <th class="text-center">เจ้าของโปรเจค</th>
                        <th class="text-center text-break">คำอธิบายโปรเจค</th>
                        <th class="text-center">วันที่เริ่มโปรเจค</th>
                        <th class="text-center">วันที่สิ้นสุดโปรเจค</th>
                        <th class="text-center">ความคืบหน้าโดยรวม</th>


                    </tr>

                </thead>
                <tbody class="text-break">
                    <?php
                    //แสดงผลข้อมูลในฐานข้อมูล
                    while ($task = mysqli_fetch_assoc($result_task)) {
                        $id = $task['project_id']; ?>
                        <?php
                         if (!isset($_GET['status'])) {

                                echo ' <tr>
                                <td class="text-right"> '.$order++.' </td>
                                <td class=""> '.$task["project_name"].' </td>
                                <td class="text-center"> <a href="mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>
    
                                </td>
                                <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                <td> '.$task["detail"].' </td>
                                <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>';
    
    
                                $progess_bar = Total_progress($id);
                               
                              
                              echo'
    
                                <td> '.intval($progess_bar).' </td>

                                </tr>';
                                 
                        }
                        
                        
                        if (isset($_GET['status']) && $_GET['status'] == '1') {
                            
                            $check =  fillter($id);
                            
                            if ($check == 100) {
                                echo ' <tr>
                                <td class="text-right"> '.$order++.' </td>
                                <td class=""> '.$task["project_name"].' </td>
                                <td class="text-center"> <a href="mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>
    
                                </td>
                                <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                                <td> '.$task["detail"].' </td>
                                <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                                <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>';
    
    
                                $progess_bar = Total_progress($id);
                               
                              
                              echo'
    
                                <td> '.intval($progess_bar).' </td>

                                </tr>';
                                // echo $check;    
                        }
                        
                        }
                     
                    if (isset($_GET['status']) && $_GET['status'] == '2') {
                            
                        $incomplete =  fillterInComplete($id);
                        
                        if ($incomplete) {
                            echo ' <tr>
                            <td class="text-right"> '.$order++.' </td>
                            <td class=""> '.$task["project_name"].' </td>
                            <td class="text-center"> <a href="mainpage.php?idp='.$task["project_id"].' " class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>

                            </td>
                            <td> '.$task["emp_fname"].'  '.$task["emp_lname"].' </td>
                            <td> '.$task["detail"].' </td>
                            <td class="text-success fw-bold">'.date("d/m/Y", strtotime($task["create_time"])).'</td>
                            <td class="text-danger fw-bold">'.date("d/m/Y", strtotime($task["dead_line"])).'</td>';
    
    
                            $progess_bar = Total_progress($id);
                           
                          
                          echo'

                            <td> '.intval($progess_bar).' </td>

                            </tr>';
                               
                    }
                    
                    }
                
                 } ?><!--ปีกกา While -->
                        
                </tbody>
            </table>
            <?php
            // 
            $IdProject = projectId();
            //  echo $IdProject;

            ?>
                  </div>

                </div>


              </div>

            </div>

          </div>

        </section>

      </div>
    </div>
    </div>
    </div>
    </script>
    <script>
      display.classList.toggle('active');
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>