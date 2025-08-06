<?php
include '../connection.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id"; 
    if ($con->query($sql) === TRUE) {
        header("Location: manageUser.php?deleted=1"); // Redirect with success flag
        exit();
    } else {
        echo "Error deleting user: " . $con->error;
    }
}

$sql = "SELECT * FROM users"; 
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Users</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <div class="max-w-7xl mx-auto p-6">
    <!-- Header Section -->
    <div class="bg-white shadow rounded-lg p-4 flex flex-col md:flex-row justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-red-600 mb-2 md:mb-0"> User Management</h2>
      <!-- <div class="flex items-center w-full md:w-auto bg-red-50 px-4 py-2 rounded-lg shadow-inner border border-red-200">
        <i class="fas fa-search text-red-400 mr-2"></i>
        <input type="text" placeholder="Search users..." class="bg-transparent outline-none w-full md:w-64 text-gray-700 placeholder-red-400"/>
      </div> -->
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="w-full table-auto text-sm">
        <thead class="bg-red-600 text-white">
          <tr>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">ID</th>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">Full Name</th>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">Email</th>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">Phone</th>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">User Type</th>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">Address</th>
            <th class="py-3 px-6 text-left font-semibold uppercase tracking-wider">Operation</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr class='hover:bg-red-50 transition'>
                          <td class='py-3 px-6'>" . $row["id"] . "</td>
                          <td class='py-3 px-6'>" . $row["fullname"] . "</td>
                          <td class='py-3 px-6'>" . $row["email"] . "</td>
                          <td class='py-3 px-6'>" . $row["phone"] . "</td>
                          <td class='py-3 px-6'>
                              <span class='inline-block px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold'>" . $row["user_type"] . "</span>
                          </td>
                          <td class='py-3 px-6'>" . $row["address"] . "</td>
                          <td class='py-3 px-6'>
                             <a href='manageUser.php?delete=" . $row["id"] . "' 
                            class='bg-red-500 hover:bg-red-700 text-white text-xs px-3 py-1 rounded-full transition duration-200'onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='7' class='py-4 px-6 text-center text-gray-500'>No users found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Alert Script -->
  <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
  <script>
    alert('Deleted successfully!');
  </script>
  <?php endif; ?>

</body>
</html>
