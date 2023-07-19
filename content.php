<?php
require('./includes/dbconfig.php');
$sql = "SELECT DISTINCT * FROM project_create
right JOIN employees ON project_create.create_by = employees.emp_id
GROUP BY employees.emp_id";
$result = mysqli_query($con, $sql);
?>

<script type="text/javascript">
		$(document).ready(function() {
            $(".owner").select2({
                placeholder: "เลือกหัวหน้าโปรเจค",
            });
            
        });

		</script>
<div class="container-fluid">
        <div class="row">

                <div class="col-lg-10 col-6 mx-auto">

                        <div class="container-fulid">


                                <form action="addProject.php" method="post" class="needs-validation ">
                                        <h1 class="text-center">สร้างโปรเจค</h1>
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">ชื่อโปรเจค</span>
                                                </div>
                                                <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" id="projectname" require>
                                                <div class="invalid-feedback">
                                                        กรุณากรอกชื่อโปรเจค
                                                </div>
                                        </div>

                                        <div class="input-group mt-3 ">
                                                <label for="employeesid" class="input-group-text">เจ้าของโปรเจค</label>
                                                <select class="owner form-select " name="idemp">

                                                        <option value="" selected>>----เลือกเจ้าของโปรเจค----<< /option>;
                                                                        <?php foreach ($result as $id) {

                                                                                echo '<option value="' . $id["emp_id"] . ' ">
                                        ' . $id["emp_id"] . '' . $id["emp_fname"] . ' ' . $id["emp_lname"] . ' </option>';
                                                                        }; ?>

                                                </select>
                                        </div>

                                        <div class="form-floating mt-3">
                                                <textarea id="detail" class="form-control" placeholder="รายละเอียดงานโปรเจค" name="detail"></textarea>
                                                <label for="detail">รายละเอียดงานโปรเจค</label>
                                                <div class="invalid-feedback">
                                                        ใส่รายละเอียดของโปรเจค
                                                </div>
                                        </div>

                                        <div class="input-group mt-3 row-12">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                                                </div>
                                                <input type="date" name="dead_line" id="deadline" min="<?php date("Y-m-d"); ?>" class="form-control col-lg-4" max="<?php Date("Y-m-d", strtotime("+6 Month ")); ?>">
                                                <div class="invalid-feedback">
                                                        กรุณาเลือกวันสิ้นสุดโปรเจค
                                                </div>
                                        </div>

                                        <div class="d-flex justify-content-end ">
                                                <button class="btn btn-success mt-3" type="submit">Submit</button>

                                        </div>
                                </form>

                        </div>

                </div>
        </div>