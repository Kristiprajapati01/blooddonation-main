<?php
require('../connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['Adminemail'])) {
    header("Location: ../login.php?error=Login first");
    exit();
}
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Handle BloodBank registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Retrieve form inputs
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
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        header("Location: bankregister.php?error=Only Gmail addresses are allowed!");
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
                $sql_bloodbank = $con->prepare("INSERT INTO bloodbank (id, service_type, service_start_time, service_end_time,image) VALUES (?, ?, ?, ?,?)");
                $sql_bloodbank->bind_param("issss", $bloodbank_id, $service_type, $service_start_time, $service_end_time, $image_path);

                if ($sql_bloodbank->execute()) {
                    echo json_encode(['redirect' => 'BloodBankResult.php?success=Registration successful! BloodBank can login now!!']);
                } else {
                    echo json_encode(['error' => 'Failed to register blood bank details.']);
                }
            } else {
                echo json_encode(['error' => 'Failed to register user.']);
            }
            exit();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BloodBank Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    <script src="../javascript/addressInput.js"></script>
</head>

<body class="bg-gray-100">
    <section id="popup" class="flex h-auto bg-gray-100 justify-center items-center">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-bold text-center mb-8 text-red-600">BloodBank Registration</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="mb-4 p-4 rounded-lg text-center <?php echo ($_GET['error'] === 'New record created successfully!!') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <p><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
            <?php endif; ?>

            <form action="process_bankregister.php" name="bloodBankRegistrationForm" method="post" enctype="multipart/form-data">
                <div class="space-y-6">
                    <!-- Blood Bank Name -->
                    <div class="mb-4">
                        <label for="bankname" class="text-gray-700 font-semibold mb-2 block">BloodBank Name</label>
                        <input type="text" name="fullname" id="bankname" placeholder="Enter BloodBank Name" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Blood Bank Email -->
                    <div class="mb-4">
                        <label for="bloodBankEmail" class="text-gray-700 font-semibold mb-2 block">Blood Bank Email</label>
                        <input type="email" name="email" id="bloodBankEmail" placeholder="Enter Email" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="bloodBankPassword" class="text-gray-700 font-semibold mb-2 block">Password</label>
                        <input type="password" name="password" id="bloodBankPassword" placeholder="Enter Password" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="bloodBankCpassword" class="text-gray-700 font-semibold mb-2 block">Confirm Password</label>
                        <input type="password" name="cpassword" id="bloodBankCpassword" placeholder="Re-enter Password" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="bloodBankPhone" class="text-gray-700 font-semibold mb-2 block">Phone Number</label>
                        <input type="text" name="phone" id="bloodBankPhone" placeholder="Enter Phone Number" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Service Hours -->
                    <div class="mb-4">
                        <label for="servicehour" class="text-gray-700 font-semibold mb-2 block">Service Hours</label>
                        <select name="servicehour" id="servicehour" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" onchange="toggleCustomHours()">
                            <option value="" disabled selected>Select Service Hours</option>
                            <option value="24-hour">24 Hours</option>
                            <option value="Custom">Custom Hours</option>
                        </select>
                    </div>

                    <!-- Custom Hours (if selected) -->
                    <div id="customHours" class="mb-4 hidden">
                        <label for="customHoursStart" class="text-gray-700 font-semibold mb-2 block">Custom Hours</label>
                        <div class="flex space-x-4">
                            <input type="time" name="customHoursStart" id="customHoursStart" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                            <input type="time" name="customHoursEnd" id="customHoursEnd" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>

                    <script>
                        function toggleCustomHours() {
                            var select = document.getElementById('servicehour');
                            var customHours = document.getElementById('customHours');
                            if (select.value === 'Custom') {
                                customHours.classList.remove('hidden');
                            } else {
                                customHours.classList.add('hidden');
                            }
                        }
                    </script>

                    <!-- Location Input -->
                    <div class="mb-4">
                        <label for="location" class="text-gray-700 font-semibold mb-2 block">Campaign Location</label>
                        <input type="text" name="address" id="location" placeholder="Enter location" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        <div id="suggestions" class="mt-2"></div>
                        <input type="hidden" id="userLat" name="latitude">
                        <input type="hidden" id="userLong" name="longitude">
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="text-gray-700 font-semibold mb-2 block">Upload Profile Image</label>
                        <input type="file" name="image" id="image" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <input type="hidden" name="user_type" value="BloodBank">

                    <!-- Register Button -->
                    <button type="submit" name="register" class="w-full py-3 px-6 bg-red-600 text-white text-lg font-semibold rounded-lg hover:bg-red-700 transition duration-200">
                        Register Now
                    </button>
                </div>
            </form>
        </div>
    </section>
</body>

<script>
    $(document).ready(function () {
        $('#location').on('input', function () {
            var address = $(this).val().trim();
            if (address.length > 0) {
                var url = "https://nominatim.openstreetmap.org/search?format=json&q=" + encodeURIComponent(address) + "&countrycodes=NP";
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (data) {
                        $('#suggestions').empty();
                        if (data.length > 0) {
                            data.forEach(function (place) {
                                $('#suggestions').append('<div class="suggestion p-2 bg-gray-100 cursor-pointer hover:bg-gray-200" data-lat="' + place.lat + '" data-lon="' + place.lon + '">' + place.display_name + '</div>');
                            });
                        }
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            } else {
                $('#suggestions').empty();
            }
        });

        $(document).on('click', '.suggestion', function () {
            var placeName = $(this).text();
            var lat = $(this).data('lat');
            var lon = $(this).data('lon');
            $('#location').val(placeName);
            $('#userLat').val(lat);
            $('#userLong').val(lon);
            $('#suggestions').empty();
        });

        $('#location').on('keypress', function (e) {
            if (e.which == 13) { // Enter key pressed
                e.preventDefault();
                var firstSuggestion = $('#suggestions .suggestion').first();
                if (firstSuggestion.length > 0) {
                    var placeName = firstSuggestion.text();
                    var lat = firstSuggestion.data('lat');
                    var lon = firstSuggestion.data('lon');
                    $('#location').val(placeName);
                    $('#userLat').val(lat);
                    $('#userLong').val(lon);
                    $('#suggestions').empty();
                }
            }
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#location').length) {
                $('#suggestions').empty();
            }
        });
    });
</script>
</html>
