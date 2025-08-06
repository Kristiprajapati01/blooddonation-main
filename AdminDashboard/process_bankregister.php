<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('../connection.php');
session_start();

$fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['cpassword']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = validate($_POST['address']);
    $latitude = validate($_POST['latitude']);
    $longitude = validate($_POST['longitude']);   
    $user_type = 'BloodBank'; 
    $service_type = htmlspecialchars(trim($_POST['servicehour']));
    $custom_hours_start = isset($_POST['customHoursStart']) ? htmlspecialchars(trim($_POST['customHoursStart'])) : null;
    $custom_hours_end = isset($_POST['customHoursEnd']) ? htmlspecialchars(trim($_POST['customHoursEnd'])) : null;

    // Handle image upload
    $default_image = 'img/slide1.png';
    $image_path = $default_image;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../upload/';
        $upload_file = $upload_dir . basename($_FILES['image']['name']);
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_types)) {
            header("Location: bankregister.php?error=Invalid file type.");
            exit();
        } elseif ($_FILES['image']['size'] > 5000000) { // 5MB limit
            header("Location: bankregister.php?error=File size exceeds limit.");
            exit();
        } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $image_path = $upload_file;
        } else {
            header("Location: bankregister.php?error=Failed to move uploaded file.");
            exit();
        }
    }

    // Validate form inputs
    if (empty($fullname) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        header("Location: bankregister.php?error=Please fill all the fields!!");
        exit();
    } elseif (empty($latitude) || empty($longitude)) {
        $error = "Enter correct address";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
        header("Location: bankregister.php?error=Name must contain only letters.");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: bankregister.php?error=Invalid email format.");
        exit();
    } elseif ($password != $confirm_password) {
        header("Location: bankregister.php?error=Password and confirm password do not match.");
        exit();
    } else {
        // Check if the email already exists for the BloodBank user type
        $user_exist_query = $con->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'BloodBank'");
        $user_exist_query->bind_param("s", $email);
        $user_exist_query->execute();
        $result = $user_exist_query->get_result();

        if ($result && $result->num_rows > 0) {
            header("Location: bankregister.php?error=Email already exists for this user type.");
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

             // Set service start and end time based on service_type
        if ($service_type == '24-hour') {
            $service_start_time = '00:00:00'; // Midnight
            $service_end_time = '23:59:59'; // End of day
        } else if ($service_type == 'Custom') {
            // Use the custom hours provided by the user
            $service_start_time = ($custom_hours_start) ? date("H:i:s", strtotime($custom_hours_start)) : null;
            $service_end_time = ($custom_hours_end) ? date("H:i:s", strtotime($custom_hours_end)) : null;
        } else {
            $service_start_time = null;
            $service_end_time = null;
        }
            // Insert into users table
            $sql = $con->prepare("INSERT INTO users (fullname, email, password, phone, address, user_type,longitude,latitude) VALUES ( ?, ?, ?, ?, ?, ?,?,?)");
            $sql->bind_param("ssssssss", $fullname, $email, $hashed_password, $phone, $address, $user_type,$longitude,$latitude);

            if ($sql->execute()) {
                $bloodbank_id = $con->insert_id;
                $sql_bloodbank = $con->prepare("INSERT INTO bloodbank (id, service_type, service_start_time, service_end_time, image) VALUES (?, ?, ?, ?, ?)");
                $sql_bloodbank->bind_param("issss", $bloodbank_id, $service_type, $service_start_time, $service_end_time, $image_path);
            
                if ($sql_bloodbank->execute()) {
                    header("Location: admindashboard.php?success=Registration successful! BloodBank can login now!!");
                    exit();
                } else {
                    header("Location: bankregister.php?error=Failed to register blood bank details.");
                    exit();
                }
            }
            
        }
    }

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // [Previous validation code remains the same until the SQL execution]

    // Insert into users table
    $sql = $con->prepare("INSERT INTO users (fullname, email, password, phone, address, user_type, longitude, latitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssssss", $fullname, $email, $hashed_password, $phone, $address, $user_type, $longitude, $latitude);

    if ($sql->execute()) {
        $bloodbank_id = $con->insert_id;
        $sql_bloodbank = $con->prepare("INSERT INTO bloodbank (id, service_type, service_start_time, service_end_time, image) VALUES (?, ?, ?, ?, ?)");
        $sql_bloodbank->bind_param("issss", $bloodbank_id, $service_type, $service_start_time, $service_end_time, $image_path);

        if ($sql_bloodbank->execute()) {
            echo json_encode(['success' => 'Blood Bank Registered Successfully']);
        } else {
            echo json_encode(['error' => 'Failed to register blood bank details: ' . $con->error]);
        }
    } else {
        echo json_encode(['error' => 'Failed to register user: ' . $con->error]);
    }
    exit();
}
?>