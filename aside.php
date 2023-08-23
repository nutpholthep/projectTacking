<?php

require('./includes/dbconfig.php');
?>
<aside class="main-sidebar sidebar-dark-primary  elevation-4">
    <a href="./index.php" class="brand-link">
        <img src="./img/BixBox-1.png" alt="Mutra Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ระบบจัดการโปรเจค</span>
    </a>
    <?php
        if(isset($_SESSION['username'])){
            
            $user_id = $_SESSION['username'];
            $stmt =("SELECT * FROM employees WHERE emp_uid = '$user_id'");
            $output = $con->query($stmt);
            $row = $output->fetch_assoc();
          
        }
        ?>
      

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image">
                <img src="./img/pic.png" class="img-circle elevation-2" alt="User Image">
            </div> -->
            <div class="info">
                <a href="#" class="d-block">Welcome, <?php echo $row['emp_fname'].' '.$row['emp_lname']?></a>
            </div>
        </div>


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
                    <i class="nav-icon fa-solid fa-briefcase"></i>
                        <p>สร้างโปรเจค</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./task.php" class="nav-link" id="task">
                    <i class="nav-icon fa-regular fa-folder"></i>
                        <p>จัดการงาน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./display.php" class="nav-link" id="display">
                        <!-- <i class="nav-icon fas fa-edit"></i> -->
                        <i class="nav-icon fa-solid fa-table"></i>
                        <p>ตารางแสดงโปรเจคทั้งหมด</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./report.php" class="nav-link" id="report">
                        <!-- <i class="nav-icon fas fa-edit"></i> -->
                        <i class="nav-icon fa-solid fa-chart-simple"></i>
                        <p>กราฟแสดงภาพรวม</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./mytask.php" class="nav-link" id="work">
                        <!-- <i class="nav-icon fas fa-edit"></i> -->
                        <i class="nav-icon fa-regular fa-clipboard"></i>
                        <p>งานของฉัน</p>
                    </a>
                </li>
                <?php 
                if(isset($_SESSION['role'])){ ?>
                    <li class="nav-item">
                    <a href="./m_emp.php" class="nav-link" id="emp">
                        <!-- <i class="nav-icon fas fa-edit"></i> -->
                        <i class="fa-solid fa-users"></i>
                        <p>จัดการสมาชิก</p>
                    </a>
                </li>
               <?php }
                ?>
                
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

                    <a href="./logout.php" class="btn btn-danger btn-block"> <i class="fa-solid fa-arrow-right-from-bracket"></i></i> Logout</a>
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