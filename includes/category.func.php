<?php
include './function.php';
if(isset($_POST['submit'])){
    $category= $_POST['category'];
    if(insert_category($category,$conn)){
        header('location:../category.php');
    }
}

if(isset($_POST['edit_category'])){
    $id =$_POST['e_id'];
    $name =$_POST['category'];
    category_update($conn,$id,$name);
    header('location:../category.php');
}

if(isset($_POST['add_menu'])){
    // echo 'Have value';
    $img_file =$_POST['img_file'];
    // add_menu($conn,$img_file);
    // header('location:../category.php');
    $targetDir = "pic_menu/";
    print_r($_FILES);
    if (!empty($_FILES["file"]["name"])) {
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $insert = $conn->query("INSERT INTO menu (img) VALUES ('$fileName'");
                if ($insert) {
                  echo'yes';
                } else {
                   echo 'fali';
                }
            }
        }
    }
}