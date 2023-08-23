<?php
session_start();
require('./includes/dbconfig.php');
$order = 1;
$actN = 1;
$sql = "SELECT * FROM employees";
$result = $con->query($sql);
require_once("./func.php");
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
                <h1>หน้าสำหรับรายชื่อสมาชิก</h1>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">ดูรายละเอียดรายชื่อสมาชิก</h3>
                                    </div>

                                    <div class="card-body">
                                        <table id="empTable" class="table">
                                            <thead>
                                                <th>ลำดับ</th>
                                                <th>ชื่อจริง</th>
                                                <th>นามสกุล</th>
                                                <th>ไอดี</th>
                                                <th>สิทธิ์</th>
                                                <th>สถานะ</th>
                                                <th>แก้ไข</th>
                                            </thead>
                                            <tbody>
                                                <?php while($row=$result->fetch_assoc()){?>
                                                <tr>
                                                    <td><?php echo $order++?></td>
                                                    <td><?php echo $row["emp_fname"]?></td>
                                                    <td><?php echo $row["emp_lname"]?></td>
                                                    <td><?php echo $row["emp_uid"]?></td>
                                                    <td><?php echo $row["role"]?></td>
                                                    <td><?php echo checkStatus($row["status"])?></td>
                                                    <td><a href="./editEmp.php?id=<?php echo $row["emp_uid"]?>" class="btn btn-warning">แก้ไขข้อมูลสมาชิก</a></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                        <a href="./addEmp.php" class="btn btn-primary">เพิ่มสมาชิกใหม่</a>
                                        
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