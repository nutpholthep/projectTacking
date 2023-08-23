<?php
session_start();
require('./includes/dbconfig.php');
$id =$_GET['id'];
$sql = "SELECT * FROM employees
WHERE emp_uid= '$id'";
$choose_id = $con->query($sql);
$number = 1;
$select_ids= $choose_id->fetch_assoc();


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
    <script src="./navtoggle.js"></script>
    <script>
        $(document).ready(function() {


            // modal หน้าactivityNew
            // $(".open_activity").click(function() {

            //     var idx = $(this).attr('idx');

            //     $.post("activityNew.php", {
            //             id: idx
            //         },
            //         function(result) {
            //             console.log(result);
            //             $("#modal_act").html(result);
            //         }
            //     );
            //     // modal หน้าactivityNew end

            // });
            // let table = new DataTable('#taskTable');

            $('#empTable').DataTable({

                // "ordering": false,
                // ที่ต้องใส่ordering เพราะถ้าให้เรียงแบบขึ้นแถวใหม่เป็นเลเวลต้องยกเลิกการเรียงลำดับ

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
                <h1>หน้าสำหรับแก้ข้อมูลสมาชิก</h1>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">ดูรายละเอียดการแก้ข้อมูลสมาชิก</h3>
                                    </div>

                                    <div class="card-body">
                                        <form class="needs-validation"  action="empQueryEdit.php" method="post" novalidate>
                                            <input type="hidden" name="id" value="<?php echo $id?>">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">ชื่อจริง</label>
                                                    <input type="text" class="form-control" id="validationCustom01" name="f_name" value="<?php echo $select_ids['emp_fname']?>">
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom02">นามสกุล</label>
                                                    <input type="text" class="form-control" id="validationCustom02" name="l_name" value="<?php echo $select_ids['emp_lname']?>">
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom03">รหัสผ่าน</label>
                                                    <input type="text" class="form-control" id="validationCustom03" value="<?php echo $select_ids['emp_pwd']?>" name="pwd">
                                                    <div class="invalid-feedback">
                                                        Please provide a valid city.
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom04">สิทธิ์</label>
                                                    <select class="custom-select" id="validationCustom04" required name="role">
                                                        <?php
                                                        if($select_ids['role']== 'user'){ ?>
                                                            <option selected value="<?php echo $select_ids['role']?>"><?php echo $select_ids['role']?></option>
                                                            <option  value="admin">admin</option>
                                                      <?php  }elseif($select_ids['role']== 'admin'){ ?>
                                                         <option selected value="<?php echo $select_ids['role']?>"><?php echo $select_ids['role']?></option>
                                                         <option  value="user">user</option>
                                                   <?php   }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a valid state.
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom04">สถานะ</label>
                                                    <select class="custom-select" id="validationCustom05" required name="status">
                                                        <?php
                                                        if($select_ids['status']== '1'){ ?>
                                                            <option selected value="<?php echo $select_ids['status']?>">ใช้งานได้</option>
                                                            <option  value="0">ปิดการใช้งาน</option>
                                                      <?php  }elseif($select_ids['status']== '0'){ ?>
                                                         <option selected value="<?php echo $select_ids['status']?>"><?php echo $select_ids['status']?></option>
                                                         <option  value="1">ใช้งานได้</option>
                                                   <?php   }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a valid state.
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" name="emp_edit">Submit</button>
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

    <script>
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
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        emp.classList.toggle('active');
        // project.classList.remove('active');
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>