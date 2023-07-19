<?php
require('./includes/dbconfig.php');
$order = 1;
$actN = 1;
$sql = "SELECT * FROM project_create";
$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id,task.status
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id 
WHERE task.task_id IS null OR task.status NOT IN(0)
ORDER BY project_create.project_id DESC";
$emp_sql = "SELECT * FROM employees";
$a = ""; //ตัวแปรที่เอาไว้เก็บค่าProject_Name
$task_query = mysqli_query($con, $sql2);
$result = mysqli_query($con, $sql);
$emp_query = mysqli_query($con, $emp_sql);
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
    <script>
        $(document).ready(function() {


            // modal หน้าactivityNew
            $(".open_activity").click(function() {

                var idx = $(this).attr('idx');

                $.post("activityNew.php", {
                        id: idx
                    },
                    function(result) {
                        console.log(result); 
                        $("#modal_act").html(result);
                    }
                );
                // modal หน้าactivityNew end

            });
            // let table = new DataTable('#taskTable');
          
            $('#taskTable').DataTable({

                "ordering": false,
                // ที่ต้องใส่ordering เพราะถ้าให้เรียงแบบขึ้นแถวใหม่เป็นเลเวลต้องยกเลิกการเรียงลำดับ

            });


            $('.taskselect').select2({
                theme: 'bootstrap4',
                placeholder: "เลือกโปรเจคที่ต้องการ"

            });
            $('.task_emp').select2({
                theme: 'bootstrap4',
                placeholder: "เลือกผู้รับผิดชอบ"

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
                <h1>หน้าสำหรับสร้างงาน</h1>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">ดูรายละเอียดการสร้างงาน</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="  mt-3">
                                            <section>
                                                <h2 class="text-center">สร้างงาน</h2>
                                                <form action="taskquery.php" method="post">
                                                    <div class="input-group mt-3 ">
                                                        <label class="input-group-text">ชื่อโปรเจค</label>
                                                        <select name="project_id" onchange="fetchProjectDeadline(this)" class="form-control taskselect " required>
                                                            <option value="">-เลือกหัวข้อโปรเจค-</option>;
                                                            <?php foreach ($result as $results) {
                                                                echo '<option value="' . $results["project_id"] . '">
                                         ' . $results["project_name"] . '
                                    </option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mt-3 mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                Task
                                                            </span>
                                                        </div>
                                                        <input type="text" name="addTask" class="form-control" placeholder="ป้อนชื่องาน" autocomplete="off">
                                                        <select name="task_emp[]" class=" task_emp " multiple="multiple" required>
                                                            <option value="">-เลือกผู้รับผิดชอบ</option>
                                                            <?php foreach ($emp_query as $results) {
                                                                echo '<option value=" ' . $results["emp_id"] . '">
                                       ' . $results["emp_id"] . '  ' . $results["emp_fname"] . '  ' . $results["emp_lname"] . ' 
                                    </option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <input type="date" name="datetask" id="datetask" class="form-control" min="<?php echo date("Y-m-d");?>">
                                                    <div class="m-3 d-flex justify-content-end">
                                                        <button class="btn btn-success btn-lg">เพิ่มงาน</button>
                                                    </div>
                                            </section>

                                        </div>
                                        <table class="table border mt-3 " id="taskTable">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>ลำดับที่</th>
                                                    <th>ชื่อโปรเจค</th>
                                                    <th>ชื่องาน</th>
                                                    <th>กิจกรรมย่อย</th>
                                                    <th>ลบงาน</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($task = mysqli_fetch_assoc($task_query)) {


                                                    if ($a != $task['project_name']) {
                                                        // echo $a ."<br>";
                                                        echo "<tr class='table-secondary'>";
                                                        echo "<td>" . $order++ . "</td>";
                                                        echo "<td >" . $task['project_name'] . "</td>";
                                                        echo "<td></td>";
                                                        echo "<td></td>";
                                                        echo "<td></td>";
                                                        echo "</tr>";
                                                    }


                                                    echo "<tr>";
                                                    echo "<td></td>";
                                                    echo "<td></td>";
                                                    echo "<td>" . $task['task_name'] . "</td>";
                                                    if (isset($task['task_id'])) {
                                                        echo "<td><a href='' class='btn btn-info open_activity 'data-target='#add_act' data-toggle='modal' idx='" . $task['task_id'] . "'>
                                    <i class='bi bi-plus-circle-fill'></i>
                                        เพิ่มกิจกรรมย่อย
                                        </a></td>";

                                                        echo "<td><a href='./deletetask.php?idtask=" . $task['task_id'] . "'  class='btn btn-danger ' onclick='return confirm(\"ต้องการลบข้อมูลหรือไม่??\")'><i class='bi bi-trash'></i>ลบงาน</a></td>";
                                                        echo "</tr>";
                                                    } else {
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                    }


                                                    $a = $task['project_name'];
                                                }
                                                echo ' </tbody>
                </table>
                </form>
           
       ' ?>
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
    </script>
    
    <script>
        function fetchProjectDeadline(selectElement) {
    var project_id = selectElement.value;

    $.ajax({
        url: "fetch_project_deadline.php",
        method: "POST",
        data: { project_id: project_id },
        success: function(response) {
            var projectDeadline = response;
            // console.log(projectDeadline);
            var currentDate = new Date().toISOString().split("T")[0];

            // ส่วนที่เพิ่มเข้ามา: ตรวจสอบว่าเป็นวันที่ที่ถูกต้องหรือไม่
            if (isValidDate(projectDeadline)) {
                var maxDate = Math.min(projectDeadline, currentDate);
                var today = projectDeadline.toString();
                // console.log(today);
                
                document.getElementById("datetask").max = today;
            }
        }
    });
}

// ตรวจสอบว่าเป็นวันที่ที่ถูกต้องหรือไม่
function isValidDate(dateString) {
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    return dateString.match(regEx) !== null;
}
         task.classList.toggle('active');
    // project.classList.remove('active');
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>