<?php
require('connection.php');
session_start();

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $user_type = validate($_POST['user_type']);

    if (empty($email) || empty($password) || empty($user_type)) {
        header("Location: login.php?error=Please fill all the fields!!");
        exit();
    } else {
        $query = $con->prepare("SELECT * FROM users WHERE email = ? AND user_type = ?");
        $query->bind_param("ss", $email, $user_type);
        $query->execute();
        $result = $query->get_result();

        if ($result && $result->num_rows == 1) {
            $result_fetch = $result->fetch_assoc();
            if (password_verify($password, $result_fetch['password'])) {
                switch (strtolower($result_fetch['user_type'])) {
                    case 'admin':
                        $_SESSION['Aloggedin'] = true;
                        $_SESSION['Adminname'] = $result_fetch['fullname'];
                        $_SESSION['Adminemail'] = $result_fetch['email'];
                        header("Location: AdminDashboard/admindashboard.php");
                        break;
                    case 'donor':
                        $_SESSION['Dloggedin'] = true;
                        $_SESSION['donorname'] = $result_fetch['fullname'];
                        $_SESSION['donorid'] = $result_fetch['id'];
                        $_SESSION['donoremail'] = $result_fetch['email'];
                        header("Location: Donordashboard/dashboard.php");
                        break;
                    case 'bloodbank':
                        $_SESSION['Bloggedin'] = true;
                        $_SESSION['bankid'] = $result_fetch['id'];
                        $_SESSION['bankname'] = $result_fetch['fullname'];
                        $_SESSION['bankemail'] = $result_fetch['email'];
                        header("Location: Bankdashboard/Bbankdashboard.php");
                        break;
                    default:
                        $_SESSION['Uloggedin'] = true;
                        $_SESSION['userid'] = $result_fetch['id'];
                        $_SESSION['username'] = $result_fetch['fullname'];
                        $_SESSION['useremail'] = $result_fetch['email'];
                        header("Location: index.php");
                        break;
                }
                exit();
            } else {
                header("Location: login.php?error=Incorrect password");
                exit();
            }
        } else {
            header("Location: login.php?error=Email not registered for this user type");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-kQfUkAq5Bc+0WZsbR4m5bJb2nVUwTxkKiZgLttgFyInD2nKN/LyLo3Z2/0lNKl8LZwr7k9D5XG1vFRJ8A4KZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-white font-sans">
    <main class="flex items-center justify-center min-h-screen bg-gradient-to-br from-red-100 via-white to-red-50 p-4">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden border border-red-200">
            <div class="flex flex-col items-center p-10">
                <h2 class="text-4xl font-extrabold text-red-600 mb-6 tracking-wide">Welcome Back!</h2>
                <p class="text-gray-500 text-lg mb-6">Login to your blood donation account</p>

                <form action="login.php" method="post" class="w-full space-y-5">
                    <?php if (isset($_GET['error'])): ?>
                        <?php
                        $errorMessage = htmlspecialchars($_GET['error']);
                        $errorClass = ($errorMessage === 'Registration successful! You can now login!!') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                        ?>
                        <div class="p-4 rounded-lg text-center font-medium <?php echo $errorClass; ?> shadow">
                            <p><?php echo $errorMessage; ?></p>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="email" class="block mb-1 text-gray-700 font-semibold">Email Address</label>
                        <input id="email" type="email" name="email" placeholder="example@email.com" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-400 outline-none transition duration-300 shadow-sm">
                    </div>

                    <div>
                        <label for="password" class="block mb-1 text-gray-700 font-semibold">Password</label>
                        <input id="password" type="password" name="password" placeholder="********" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-400 outline-none transition duration-300 shadow-sm">
                    </div>

                    <div>
                        <label for="userType" class="block mb-1 text-gray-700 font-semibold">User Type</label>
                        <select name="user_type" id="userType" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 text-gray-700 focus:ring-2 focus:ring-red-400 outline-none shadow-sm transition">
                            <option value="" disabled selected>Select User Type</option>
                            <option value="User">User</option>
                            <option value="Donor">Donor</option>
                            <option value="BloodBank">Blood Bank</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <button type="submit" name="login"
                        class="w-full bg-red-500 text-white font-semibold py-3 rounded-xl hover:bg-red-600 transition duration-300 shadow-lg">
                        Login Now
                    </button>

                    <div class="text-center mt-4 text-sm text-gray-600">
                        Don't have an account?
                        <a href="userregister.php" class="text-red-500 hover:underline font-semibold">Register Here</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
