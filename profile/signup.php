<?php
    session_start();

    require_once "../config/connection.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];
    $password = $_POST['password'];  

    $check_login = $link->query("SELECT * FROM Users WHERE _login='$email'");
    if (mysqli_num_rows($check_login) > 0) {
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "This email already exists",
            "fields" => ['email']
        ];

        echo json_encode($response);
        
        die();
    }

    $error_fields = [];

    if ($name === '') {
        $error_fields[] = 'name';
    }

    if ($password === '') {
        $error_fields[] = 'password';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_fields[] = 'email';
    }

    if (!in_array($gender, array("Male", "Female", "Other"))) {
        $error_fields[] = 'gender';
    }

    if ($location === '' || mysqli_num_rows($link->query("SELECT * FROM Locations WHERE country='$location'")) === 0) {
        $error_fields[] = 'location';
    }

    if(!validateDate($birthdate, 'Y-m-d')) {
        $error_fields[] = 'birthdate';
    }

    if (!$_FILES['avatar']) {
        $error_fields[] = 'avatar';
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
    foreach ($link->query("SELECT * FROM Locations WHERE country='$location'") as $loc) {
        $location_id = $loc['id'];
    }
    $currentdate = date('Y-m-d H:i:s', strtotime("now"));

    $path = "../sources/users/" . time() . $_FILES['avatar']['name'];
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) {
        $response = [
            "status" => false,
            "type" => 2,
            "message" => "Error loading avatar",
        ];
        echo json_encode($response);
    }

    if ($link->query("INSERT INTO Users VALUES (0, '$email', '$password', '$name', '$birthdate', '$gender', $location_id, '$path', 0, '$currentdate', '$currentdate')")) {
        $response = [
            "status" => true
        ];
        echo json_encode($response);
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
?>