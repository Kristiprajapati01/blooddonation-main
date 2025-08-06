<?php
require('connection.php');
session_start();

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    // Collect and validate input data
    $fullname = validate($_POST['fullname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST['cpassword']);
    $phone = validate($_POST['phone']);
    $address = validate($_POST['address']);
    $latitude = validate($_POST['latitude']);
    $longitude = validate($_POST['longitude']);
    $user_type = validate($_POST['user_type']);

    // Check for empty fields
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password) || empty($phone) || empty($address) || empty($user_type)) {
        $error = "Please fill all the fields!";
    } elseif (empty($latitude) || empty($longitude)) {
        $error = "Enter correct address";
    } elseif (!preg_match('/^[a-zA-Z ]+$/', $fullname)) {
        $error = "Name must contain only letters";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        $error = "Only Gmail addresses are allowed!";
    }elseif ($password !== $confirm_password) {
        $error = "Password and confirm password do not match!";
    } else {
        // Check if email already exists
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND user_type = ?");
        $stmt->bind_param("ss", $email, $user_type);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists for this user type";
        } else {
            // Insert new user into the users table
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $con->prepare("INSERT INTO users (fullname, email, password, phone, address, user_type,latitude,longitude) VALUES (?, ?, ?, ?, ?, ?,?,?)");
            $stmt->bind_param("ssssssdd", $fullname, $email, $hashed_password, $phone, $address, $user_type, $latitude, $longitude);

            if ($stmt->execute()) {
               
                    $success = "User Registration successful! You can now login.";
                
            } else {
                $error = "Failed to register user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    <script src="javascript/addressInput.js"></script>
    <style>
        .formerror {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-gray-200">
    <section id="registration" class="flex items-center justify-center min-h-screen bg-gray-100 pt-32">
        <div class="w-full max-w-4xl p-8 bg-white shadow-xl rounded-2xl">
            <h2 class="text-4xl font-extrabold text-center text-red-600 mb-6">User Register</h2>

            <form id="userRegistrationForm" action="userregister.php" name="userRegistrationForm" method="post" class="space-y-6">
                <?php if (isset($error)) : ?>
                    <div class="formerror text-center text-red-500 font-medium"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="grid grid-cols-1 gap-6">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="fullname">Full Name</label>
                        <input class="shadow border rounded-xl w-full p-3 focus:ring-2 focus:ring-red-400" type="text" name="fullname" id="userFullname" placeholder="Enter Full Name" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="email">Email</label>
                        <input class="shadow border rounded-xl w-full p-3 focus:ring-2 focus:ring-red-400" type="email" name="email" id="userEmail" placeholder="Enter Email" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="password">Password</label>
                        <input class="shadow border rounded-xl w-full p-3 focus:ring-2 focus:ring-red-400" type="password" name="password" id="userPassword" placeholder="Enter Password" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="cpassword">Re-enter Password</label>
                        <input class="shadow border rounded-xl w-full p-3 focus:ring-2 focus:ring-red-400" type="password" name="cpassword" id="userCpassword" placeholder="Re-enter Password" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="phone">Phone Number</label>
                        <input class="shadow border rounded-xl w-full p-3 focus:ring-2 focus:ring-red-400" type="text" name="phone" id="userPhone" placeholder="Enter Phone Number" required>
                    </div>

                    <div class="mb-4 relative">
                        <label class="block text-gray-700 font-bold mb-2" for="address">Location</label>
                        <input class="shadow border rounded-xl w-full p-3 focus:ring-2 focus:ring-red-400" type="text" id="location" name="address" placeholder="Enter Address" required>
                        <div id="suggestions" class="absolute z-10 bg-white border rounded-lg mt-1 w-full shadow-md max-h-40 overflow-y-auto"></div>
                        <input type="hidden" id="userLat" name="latitude">
                        <input type="hidden" id="userLong" name="longitude">
                    </div>
                </div>

                <input type="hidden" name="user_type" value="User">
                <button type="submit" id="RegButton" name="register" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 w-full rounded-xl transition-all duration-300">Register Now</button>

                <div class="text-center mt-4 text-lg">
                    Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login now</a>
                </div>
            </form>
        </div>
    </section>

    <!-- Dialog Box -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-2xl p-8 shadow-xl text-center max-w-md w-full">
            <h3 class="text-2xl font-bold text-green-600 mb-4">Registered Successfully!</h3>
            <p class="text-gray-600 mb-6">You will now be redirected to the login page.</p>
            <button id="okButton" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg font-semibold transition">OK</button>
        </div>
    </div>

    <!-- jQuery and JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Autocomplete location
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
                                    $('#suggestions').append('<div class="suggestion px-3 py-2 hover:bg-gray-100 cursor-pointer" data-lat="' + place.lat + '" data-lon="' + place.lon + '">' + place.display_name + '</div>');
                                });
                            }
                        }
                    });
                } else {
                    $('#suggestions').empty();
                }
            });

            // Click on suggestion
            $(document).on('click', '.suggestion', function () {
                var placeName = $(this).text();
                var lat = $(this).data('lat');
                var lon = $(this).data('lon');

                $('#location').val(placeName);
                $('#userLat').val(lat);
                $('#userLong').val(lon);
                $('#suggestions').empty();
            });

            // Enter key auto-select
            $('#location').on('keypress', function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    var first = $('#suggestions .suggestion').first();
                    if (first.length) {
                        $('#location').val(first.text());
                        $('#userLat').val(first.data('lat'));
                        $('#userLong').val(first.data('lon'));
                        $('#suggestions').empty();
                    }
                }
            });

            // Hide suggestions on click outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#location, #suggestions').length) {
                    $('#suggestions').empty();
                }
            });

            // Show dialog box on form submit
            // $('#userRegistrationForm').on('submit', function (e) {
            //     e.preventDefault(); // Prevent real submit (you can use AJAX here instead)
            //     // Simulate success (if you want to use real PHP form action, remove this block)
            //     $('#successModal').removeClass('hidden').addClass('flex');
            // });

            // OK button
            $('#okButton').on('click', function () {
                window.location.href = 'login.php';
            });
        });
    </script>
    <?php if (!empty($success)) : ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('successModal').classList.remove('hidden');
    document.getElementById('successModal').classList.add('flex');
    });
</script>
<?php endif; ?>
</body>
</html>
