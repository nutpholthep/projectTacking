<?php
session_start();
?>
<aside class="main-sidebar sidebar-dark-primary  elevation-4">
    <a href="./index.php" class="brand-link">
        <img src="./img/pic.png" alt="Mutra Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ระบบจัดการโปรเจค</span>
    </a>
    <?php
        if(isset($_SESSION['users_login'])){
            $user_id = $_SESSION['users_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id ='$user_id'");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <h3 class="mt-4">Welcome, <?php echo $row['firstname'] .''. $row['lastname']?></h3>

    <div class="sidebar">
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="./img/pic.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div> -->


        <nav class="mt-2">
         
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            รายการสินค้า
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a> -->

                    <!-- <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มหมวดหมู่</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มสินค้า</p>
                            </a>
                        </li>
                    </ul> -->
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link" id="project">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>สร้างโปรเจค</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./task.php" class="nav-link" id="task">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>จัดการงาน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./display.php" class="nav-link" id="display">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>ตารางแสดงโปรเจคทั้งหมด</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./report.php" class="nav-link" id="report">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>กราฟแสดงภาพรวม</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="./saleshistory.php" class="nav-link">
                    <i class="nav-icon fa-sharp fa-regular fa-calendar"></i>
                        <p>ประวัติการขาย</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./member.php" class="nav-link">
                    <i class="nav-icon fa-sharp fa-regular fa-user"></i>
                        <p>
                            จัดการสมาชิก
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li> -->
                <li class="nav-item">

                    <a href="./logout.php" class="btn btn-danger btn-block"> <i class="nav-icon fa-sharp fa-regular fa-user"></i> Logout</a>
                    </a>
                </li> 
            </ul>
        </nav>

    </div>
</aside>


<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>

<script src="./navtoggle.js"></script>