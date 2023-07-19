<?php
require('./includes/dbconfig.php');

$order = 1;
$actN = 1;
$sql = "SELECT * FROM project_create";
$sql2 = "SELECT project_create.project_name, task.task_name, task.task_id, task.status
FROM task
RIGHT JOIN project_create ON project_create.project_id = task.project_id
WHERE task.task_id IS null OR task.status NOT IN(0)
ORDER BY project_create.project_id DESC";
$emp_sql = "SELECT * FROM employees";
$a = ""; //ตัวแปรที่เอาไว้เก็บค่า Project_Name
$task_query = mysqli_query($con, $sql2);
$result = mysqli_query($con, $sql);
$emp_query = mysqli_query($con, $emp_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="card-body">
    <div class="mt-3">
        <section>
            <h2 class="text-center">สร้างงาน</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="input-group mt-3">
                    <label class="input-group-text">ชื่อโปรเจค</label>
                    <select name="project_id" class="form-control taskselect" required onchange="fetchProjectDeadline(this)">
                        <option value="">-เลือกหัวข้อโปรเจค-</option>
                        <?php while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="input-group mt-3 mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Task</span>
                    </div>
                    <input type="text" name="addTask" class="form-control" placeholder="ป้อนชื่องาน" autocomplete="off">
                    <select name="task_emp[]" class="task_emp" multiple="multiple" required>
                        <option value="">-เลือกผู้รับผิดชอบ</option>
                        <?php while ($row = mysqli_fetch_assoc($emp_query)) {
                            echo '<option value="' . $row["emp_id"] . '">' . $row["emp_id"] . ' ' . $row["emp_fname"] . ' ' . $row["emp_lname"] . '</option>';
                        } ?>
                    </select>
                </div>
                <input type="date" name="datetask" id="datetask" class="form-control" min="<?php echo date("Y-m-d"); ?>" required>
                <div class="m-3 d-flex justify-content-end">
                    <button class="btn btn-success btn-lg">เพิ่มงาน</button>
                </div>
            </form>
        </section>
    </div>
    <!-- ตารางงาน -->
</div>
<script>
   
function fetchProjectDeadline(selectElement) {
    var project_id = selectElement.value;

    $.ajax({
        url: "fetch_project_deadline.php",
        method: "POST",
        data: { project_id: project_id },
        success: function(response) {
            var projectDeadline = response;
            console.log(projectDeadline);
            var currentDate = new Date().toISOString().split("T")[0];

            // ส่วนที่เพิ่มเข้ามา: ตรวจสอบว่าเป็นวันที่ที่ถูกต้องหรือไม่
            if (isValidDate(projectDeadline)) {
                var maxDate = Math.min(projectDeadline, currentDate);
                var today = projectDeadline.toString();
                console.log(today);
                
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

</script>
</body>
</html>
