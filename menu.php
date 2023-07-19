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
</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <?php
    include('./navbar.php');
    include('./aside.php');
    ?>
    <div class="content-wrapper">
      <div class="content">
        <h1>หน้าสำหรับเพิ่มเมนู</h1>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">ดูรายละเอียดเมนูและเพิ่มเมนู</h3>
                  </div>

                  <div class="card-body">
                    <a href="./addmenu.php" class="btn btn-info mb-3">เพิ่มเมนูใหม่ +</a>
                    <a href="./category.php" class="btn btn-info mb-3 ml-3">เพิ่มหมวดหมู่ +</a>
                    <table id="example2" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>รูปภาพ</th>
                          <th>ชื่อเมนู</th>
                          <th>รายละเอียด</th>
                          <th>ราคา</th>
                          <th>แก้ไข</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
<td><img src="upload/<?= $k['img_file'];?>" width="70px"></td>
                        </tr>
                      </tbody>

                    </table>
                  </div>

                </div>


              </div>

            </div>

          </div>

        </section>

      </div>
    </div>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>