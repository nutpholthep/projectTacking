<?php
include './dbconfig.php';
function insert_category($category,$conn){
$sql = "INSERT INTO category (category_name)
VALUES (?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s',$category);
$stmt->execute();
$stmt->close();
$conn->close();
}

function select_category($conn){
    $sql="SELECT * FROM category";
    $reslut=$conn->query($sql);
    return $reslut;
}

function category_edit($conn,$id){
    $sql="SELECT category_name FROM category 
    WHERE id=$id";
    $reslut=$conn->query($sql);
    return $reslut;
}

function category_update($conn,$id,$name){
    $sql ="UPDATE category 
    SET category_name='$name'
    WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('location:../category.php');
      } else {
        echo "Error updating record: " . $conn->error;
      }
      $conn->close();
}
function category_status($conn,$id){
    $sql ="UPDATE category 
    SET status = 0
    WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('location:../category.php');
      } else {
        echo "Error updating record: " . $conn->error;
      }
      $conn->close();
}

