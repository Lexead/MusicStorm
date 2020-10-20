<?php
    session_start();

    require_once "../config/connection.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $error_fields = [];

    if ($email === '') {
        $error_fields[] = 'email';
    }

    if ($password === '') {
        $error_fields[] = 'password';
    }

    if (!empty($error_fields)) {
        $response = [
            "status" => false,
            "type" => 1,
            "message" => 'Check the correctness of the fields', 
            "fields" => $error_fields
        ];

        echo json_encode($response);

        die();
    }

    $password = md5($password);

    $check_user = $link->query("SELECT * FROM Users WHERE _login='$email' AND _password='$password'");
    if (mysqli_num_rows($check_user) > 0) {
        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id" => $user["id"],
            "name" => $user["_name"],
            "email" => $user["_login"],
            "birthdate" => $user["birthdate"],
            "gender" => $user["gender"], 
            "location_id" => $user["location_id"], 
            "admin" => $user["_admin"],
            "avatar" => $user["avatar"]
        ];
            
        $response = [
            "status" => true
        ];

        echo json_encode($response);
    }
    else {
        $response = [
            "status" => false,
            "type" => 1,
            "message" => 'User not found. Wrong email or password', 
            "fields" => $error_fields
        ];

        echo json_encode($response);

        die();
    }
?>