<?php
session_start();
require('./includes/dbconfig.php');
$act = "SELECT task.task_id,activity.activity_id,activity.activity_name,task.project_id
FROM task
left JOIN activity ON task.task_id = activity.task_id
WHERE activity.activity_id = ".$_POST['id'];

$act_query = mysqli_query($con,$act);
$actN =1;

$empsql ="SELECT * FROM employees";
$emp_query = mysqli_query($con,$empsql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
  $('#edit_by').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกโปรเจคที่ต้องการ",
                dropdownParent: $('#modal_edit_activity')
            });
</script>
<div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
          <form action="editActivity.php" method="post">
         
              <h1>แก้ไขรายละเอียดกิจกรรมย่อย</h1>              
                <table class="table table-striped table-warning mt-2 ">
                    <thead class="thead-dark">
                    
                        <th>ชื่อกิจกรรมย่อย2</th>
                        <th>ลบงาน</th>
                    </thead>
                    <tbody >
                      <?php while($lact=mysqli_fetch_assoc($act_query)){ ?>
                        <input type="hidden" name="actid" value="<?php echo $lact['activity_id']?>">
                        <input type="hidden" name="b_name" value="<?php echo $lact['activity_name']?>">
                        <input type="hidden" name="task_id" value="<?php echo $lact['task_id']?>">
                        <input type="hidden" name="id" value="<?php echo $lact['project_id']?>">
                        <input type="hidden" name="edit_by" value="<?php echo $_SESSION['username']?>">
                       
                            <tr>
                        
                        <td><input type="text" class="form-control" value="<?php echo $lact['activity_name']?>" name="edit_act"></td>
                        <td> <a href="deleteactivity.php?actid=<?php echo $lact['activity_id']; ?>&idp=<?php echo $lact['project_id']?>&actMain=0" class="btn btn-danger" onclick="confirmDelete(event, <?php echo $lact['activity_id']; ?>,<?php echo $lact['project_id']?>)">
                                            <i class="bi bi-trash"></i>ลบงาน</a></td>
                       </tr> 

<?php } ?>
</table>

      <div class="modal-footer">
        <input type="submit" value="บันทึกข้อมูล" name="actMain" class="btn btn-success">
        <!-- <button type="submit" name="actMain" class="btn btn-success" value="บันทึกข้อมูล">บันทึกข้อมูล</button> -->
      </div>
      </form>
    </div>
    
    <script>
      function confirmDelete(event, actId,proId) {
    event.preventDefault();
    Swal.fire({
        title: 'ต้องการลบข้อมูลหรือไม่?',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ยกเลิก',
        // reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'ลบงานหรือกิจกรรม!',
                'คุณได้ทำงานลบสำเร็จแล้ว.',
                'success'
            ).then(() => {
                // Redirect after the SweetAlert dialog is closed
                // window.location.href = './deletetask.php?idtask=' + taskId;
                window.location.href = 'deleteactivity.php?actid='+actId+'&idp='+proId+'&actMain='+0;
            });
        }
    });
}
    </script>
</body>
</html>