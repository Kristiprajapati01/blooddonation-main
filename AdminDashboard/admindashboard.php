<?php
require('../connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['Adminemail'])) {
    header("Location: ../login.php?error=Login first");
    exit(); // Ensure script execution stops after redirection
}
?>
<?php
$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = htmlspecialchars($_GET['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans h-screen">

  <div class="flex h-full">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r shadow-md flex flex-col items-center p-6">
    <div class="mb-12 w-full flex justify-center">
  <img src="../img/Bloodlink.png" alt="Logo" class="w-40 h-20 object-contain drop-shadow" />
</div>
      <ul class="w-full space-y-3">
        <li>
          <a href="#" data-content="dashboard"
             class="flex items-center justify-center gap-2 py-3 bg-red-500 rounded-md text-white font-medium hover:bg-red-600 transition">
            <i class="fas fa-tachometer-alt text-lg"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="#" data-content="users"
             class="flex items-center justify-center gap-2 py-3 bg-red-500 rounded-md text-white font-medium hover:bg-red-600 transition">
            <i class="fas fa-users text-lg"></i> Manage User
          </a>
        </li>
        <li>
          <a href="#" data-content="bloodbank"
             class="flex items-center justify-center gap-2 py-3 bg-red-500 rounded-md text-white font-medium hover:bg-red-600 transition">
            <i class="fas fa-tint text-lg"></i> Add BBank
          </a>
        </li>
        <li>
          <a href="#" data-content="view"
             class="flex items-center justify-center gap-2 py-3 bg-red-500 rounded-md text-white font-medium hover:bg-red-600 transition">
            <i class="fas fa-user text-lg"></i> View BloodBanks
          </a>
        </li>
      </ul>
      <button id="logout-btn"
              class="mt-auto w-full mt-10 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition text-sm flex justify-center items-center gap-2">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow p-8 overflow-y-auto bg-gray-100">
      <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-2xl font-semibold text-red-700">Welcome, Admin </h2>
      </div>
      <div id="dynamic-content" class="space-y-6">
        <!-- Content loads here -->
      </div>
    </main>
  </div>

  <!-- Scripts -->
  <script>
    $(document).ready(function () {
      $('.w-full a').on('click', function (e) {
        e.preventDefault();
        const content = $(this).data('content');
        let url = '';
        if (content === 'dashboard') url = 'Dashboards.php';
        else if (content === 'users') url = 'manageUser.php';
        else if (content === 'bloodbank') url = 'bankregister.php';
        else if (content === 'view') url = 'ViewBloodBank.php';

        if (url) {
          $.get(url, function (data) {
            $('#dynamic-content').html(data);
          });
        }
      });

      $('#logout-btn').on('click', function () {
        window.location.href = '../logout.php';
      });

      $(document).on('click', '.view-details', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        $.get(url, function (data) {
          $('#dynamic-content').html(data);
        });
      });
    });
  </script>
  <?php if (!empty($successMessage)) : ?>
<script>
    alert("<?php echo $successMessage; ?>");
</script>
<?php endif; ?>

</body>
</html>

