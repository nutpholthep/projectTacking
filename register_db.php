<?php 
    session_start();
    include('./includes/dbconfig.php');

    $errors = array();

    if (isset($_POST['reg_user'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);

        if (empty($id)) {
            array_push($errors, "id is required");
        }
        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
        if (empty($firstname)) {
            array_push($errors, "Firstname is required");
        }
        if (empty($surname)) {
            array_push($errors, "Surname is required");
        }

        $user_check_query = "SELECT * FROM user WHERE id = '$id' OR username = '$username' ";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['id'] === $id) {
                array_push($errors, "Id already exists");
            }
            if ($result['username'] === $username) {
                array_push($errors, "Username already exists");
            }
        }

       if (count($errors) == 0) {
           $password = md5($password);

           $sql = "INSERT INTO user (id, username, password, firstname, surname) VALUES ('$id', '$username', '$password', '$firstname', '$surname')";
           mysqli_query($conn, $sql);

           $_SESSION['username'] = $username;
           $_SESSION['success'] = "You are now logged in";
           header('location: login.php');
       } 
    }

?>