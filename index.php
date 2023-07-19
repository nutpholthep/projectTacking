<?php
require('./includes/dbconfig.php');
$sql = "SELECT DISTINCT * FROM project_create
right JOIN employees ON project_create.create_by = employees.emp_id
GROUP BY employees.emp_id";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>New project_tracking</title>
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <link rel="shortcut icon" href="./img/pic.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<link rel="stylesheet" href="./style.css">
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
          theme: 'bootstrap4'
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
<div class="card">
<div class="container-fluid">
        <div class="row">

                <div class="col-lg-10 col-12 mx-auto">

                        <div class="container-fulid">

                        <div class="card-body">
                                <form action="addProject.php" method="post" class="needs-validation" novalidate>
                                        <h1 class="text-center">สร้างโปรเจค</h1>
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">ชื่อโปรเจค</span>
                                                </div>
                                                <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" id="projectname" required>
                                                <div class="invalid-feedback">
                                                        กรุณากรอกชื่อโปรเจค
                                                </div>
                                               
                                        </div>

                                        
                                        <div class="input-group mt-3 ">
                                                <label for="employeesid" class="input-group-text">เจ้าของโปรเจค</label>
                                                <select class="js-example-basic-single custom-select" name="idemp" id="dropdown" required>

                                                        <option value="" selected>>----เลือกเจ้าของโปรเจค----<</option>;
                                                                        <?php foreach ($result as $id) {

                                                                                echo '<option value="' . $id["emp_id"] . ' ">
                                        ' . $id["emp_id"] . '' . $id["emp_fname"] . ' ' . $id["emp_lname"] . ' </option>';
                                                                        }; ?>

                                                </select>
                                        </div>

                                        <div class="form-floating mt-3">
                                                <textarea id="detail" class="form-control" placeholder="รายละเอียดงานโปรเจค" name="detail"></textarea>
                                                <!-- <label for="detail">รายละเอียดงานโปรเจค</label> -->
                                                <div class="invalid-feedback">
                                                        ใส่รายละเอียดของโปรเจค
                                                </div>
                                        </div>

                                        <div class="input-group mt-3 row-12">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                                                </div>
                                                <input type="date" name="dead_line" id="deadline" min="<?php echo date("Y-m-d"); ?>" class="form-control col-lg-4" max="<?php echo Date("Y-m-d", strtotime("+6 Month")); ?>" required>
                                                <div class="invalid-feedback">
                                                        กรุณาเลือกวันสิ้นสุดโปรเจค
                                                </div>
                                        </div>

                                        <div class="d-flex justify-content-end ">
                                                <button class="btn btn-success mt-3" type="submit" name="submit">Submit</button>

                                        </div>
                                </form>

                        </div>

                </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    </div>

   






<!-- <script src="./validation.js"></script> -->
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
        //   event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

project.classList.toggle('active');
</script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
  <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
  <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>