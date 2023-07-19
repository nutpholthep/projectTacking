<?php
include('./func.php');
include('./includes/dbconfig.php');
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="shortcut icon" href="./img/pic.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <?php
    include('./navbar.php');
    include('./aside.php');
    $sql = "SELECT project_id FROM project_create";
    $result = mysqli_query($con, $sql);
    while ($task = mysqli_fetch_assoc($result)) {
      $id = $task['project_id'];
      $query = barChart($id);
      $inbar = inBar($id);

      foreach ($inbar as $val) {
        $labels[] = $val['project_name'];
        $num = intval($val['total']);
        $datas[] = $num;
        // print_r(intval($val['total']).'<br>');
      }
      foreach ($query as $value) {
        $label[] = $value['project_name'];
        $data[] = $value['total'];
      }
    }

    $owner = countOwner();
    foreach ($owner as $owner_list) {
      $ownername[] = $owner_list['FullName'];
      $ownerData[] = $owner_list['project_count'];
    }
    $top = topFiveMonthUpdate();
    foreach ($top as $topf) {
      $toplabels[] = $topf['project_name'];
    echo  $topname[] = $topf['project_count'];
    }

    ?>
    <div class="content-wrapper">
      <div class="content">
        <h1>หน้าสำหรับดูรายละเอียดในรูปแบบกราฟ</h1>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">ดูรายละเอียดในรูปแบบกราฟ</h3>
                  </div>

                  <div class="card-body">
                    <div class="text-center">
                      <p>ภาพรวมโปรเจค</p>
                      <button id="bar" class="btn btn-primary">คนที่เป็นเจ้าของโปรเจคมากที่สุด</button>
                      <button id="pie" class="btn ">โปรเจคที่ยังไม่เสร็จเสร็จแล้ว</button>
                      <button id="top_month" class="btn ">โปรเจคที่คืบหน้ามากที่สุดในเดือนนี้</button>
                      <!-- <button id="act" class="btn ">โปรเจคที่อัพเดทบ่อยที่สุด</button> -->
                    </div>
                    <div>
                      <canvas id="myChart"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                      window.addEventListener('load', () => {
                        const ctx = document.getElementById('myChart').getContext('2d');
                        let chartType = 'bar'; // ประเภทกราฟเริ่มต้น

                        const chartData = {
                          labels: <?= json_encode($ownername) ?>,
                          datasets: [{
                            label: 'จำนวนโปรเจคที่รับผิดชอบ',
                            data: <?= json_encode($ownerData) ?>,
                            borderWidth: 2,
                            borderColor: null,
                            backgroundColor: [
                              'rgba(255, 99, 132)', // สีแดงโทนอ่อน
                              'rgba(255, 159, 64)', // สีส้มโทนอ่อน
                              'rgba(255, 205, 86)', // สีเหลืองโทนอ่อน
                              'rgba(75, 192, 192)', // สีเขียวเข้มโทนอ่อน
                              'rgba(54, 162, 235)', // สีฟ้าโทนอ่อน
                              'rgba(153, 102, 255)', // สีม่วงโทนอ่อน
                              'rgba(201, 203, 207)' // สีเทาโทนอ่อน
                            ],
                            fill: {
                target: 'origin',
                above: 'rgb(255, 159, 64)',   // Area will be red above the origin
                below: 'rgb(0, 0, 255)'    // And blue below the origin
              }
                          }]
                        };

                        const options = {
                          scales: {
                            y: {
                              beginAtZero: true
                            }
                          }
                        };

                        const chart = new Chart(ctx, {
                          type: chartType,
                          data: chartData,
                          options: options
                        });

                        const bar = document.getElementById('bar');
                        const pie = document.getElementById('pie');
                        const top = document.getElementById('top_month');

                        bar.addEventListener('click', function() {
                          owner('bar');
                        });
                        pie.addEventListener('click', function() {
                          incom('pie');
                        });
                        top.addEventListener('click', function() {
                          top_month('line');
                        });
                        // pie.addEventListener('click', income.bind('line'));
                        // bar.addEventListener('click', changeChartType.bind(null, 'bar'));
                        // pie.addEventListener('click', changeChartType.bind(null, 'pie'),updateChartData(< ?= json_encode($datas)?>));
                        // top.addEventListener('click', changeChartType.bind(null, 'line'));

                        function owner(type) {
                          chartType = type;
                          chart.config.type = chartType;
                          console.log(chart.config.type = chartType);
                          chartData.labels = <?php echo json_encode($ownername) ?>;
                          chartData.datasets[0].label = 'จำนวนโปรเจคที่รับผิดชอบ';
                          chartData.datasets[0].data = <?= json_encode($ownerData) ?>;
                          bar.classList.toggle('btn-primary');
                          pie.classList.remove('btn-primary');
                          top.classList.remove('btn-primary');
                          // bar.classList.add('active');
                          // pie.classList.remove('active');
                          chart.update()
                        }

                        function incom(type) {
                          chartType = type;
                          chart.config.type = chartType;
                          chartData.labels = <?php echo json_encode($labels) ?>;
                          chartData.datasets[0].label = 'ความคืบหน้า';
                          chartData.datasets[0].data = <?= json_encode($datas) ?>;
                          // pie.classList.add('active');
                          // bar.classList.remove('active');
                          pie.classList.toggle('btn-primary');
                          bar.classList.remove('btn-primary');
                          top.classList.remove('btn-primary');
                          chart.update()
                        }

                        function top_month(type) {
                          chartType = type;
                          chart.config.type = chartType;
                          chartData.labels = <?php echo json_encode($labels) ?>;
                          chartData.datasets[0].label = 'จำนวนที่อัพเดท';
                          chartData.datasets[0].data = <?= json_encode($datas) ?>;
                          // pie.classList.add('active');
                          // bar.classList.remove('active');
                          top.classList.toggle('btn-primary');
                          bar.classList.remove('btn-primary');
                          pie.classList.remove('btn-primary');
                          chart.update()
                        }


                        //     function changeChartType(type) {
                        //       chartType = type;
                        //       chart.config.type = chartType;
                        //       chart.update();
                        //       bar.classList.toggle('btn-primary', chartType === 'bar');
                        //       pie.classList.toggle('btn-primary', chartType === 'pie');
                        //       top.classList.toggle('btn-primary', chartType === 'line');
                        //     }
                        //     function updateChartData(newData) {
                        //   chartData.datasets[0].data = newData;
                        //   chartData.datasets[0].label = 'ความคืบหน้า';
                        //   chart.update();
                        // }
                      });
                    </script>
                    <script>
                      report.classList.toggle('active');
                    </script>

                    <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> -->
                    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
                    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
                    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>