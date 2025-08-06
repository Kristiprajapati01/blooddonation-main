<?php
require('connection.php');
session_start();

$bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-','A+','B+','C+','D+'];
$donorCounts = [];

// Prepare the SQL statement
$stmt = $con->prepare("
    SELECT donor_blood_type, COUNT(*) as count
    FROM donor
    GROUP BY donor_blood_type
");

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch donor counts
while ($row = $result->fetch_assoc()) {
    $donorCounts[$row['donor_blood_type']] = $row['count'];
}

// Check if the user is logged in as a donor
$isDonor = false;
if (isset($_SESSION['user_id'])) {
    // Fetch user details from the database
    $user_id = $_SESSION['user_id'];
    $stmt = $con->prepare("SELECT * FROM donor WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $donorResult = $stmt->get_result();

    if ($donorResult->num_rows > 0) {
        $isDonor = true; // User is a donor
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blood Connect</title>
  <link rel="icon" href="favIcon.png" type="image/png" />
  <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
    }

    .glass {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .bg-hero {
      background: linear-gradient(to right, #ffcccc, #ffe6e6);
    }

    .btn-fancy {
      transition: all 0.3s ease-in-out;
    }

    .btn-fancy:hover {
      transform: scale(1.05) translateY(-2px);
      box-shadow: 0 10px 15px rgba(255, 0, 0, 0.3);
    }
  </style>
</head>

<body class="bg-gray-100">

  <!-- Hero Section -->
  <section class="bg-hero h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 md:px-20 flex flex-col md:flex-row items-center justify-between">
      
      <!-- Left Text -->
      <div class="text-center md:text-left mb-10 md:mb-0 max-w-lg">
        <h1 class="text-5xl md:text-6xl font-bold text-red-600 mb-6 leading-tight">
          Save Lives <br /> One Drop at a Time
        </h1>
        <p class="text-lg text-gray-700 mb-8">
          Join the mission. Be a hero. Your blood donation can give someone another chance at life.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
          <a href="donorregister.php"
            class="btn-fancy inline-block px-6 py-3 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700">
            <i class="fas fa-tint mr-2"></i> Become a Donor
          </a>
          <a href="searchresult.php"
            class="btn-fancy inline-block px-6 py-3 bg-white text-red-600 border-2 border-red-600 rounded-full font-semibold hover:bg-red-100">
            <i class="fas fa-search mr-2"></i> Find Blood
          </a>
        </div>
      </div>

      <!-- Right Image -->
      <div class="w-full md:w-1/2 flex justify-center">
        <img src="img/hero.gif" alt="Blood Donation" class="max-h-[400px] rounded-2xl shadow-lg" />
      </div>
    </div>
  </section>

  <!-- Blood Types Section -->
  <section class="py-20 bg-gradient-to-b from-white to-pink-100">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
      Choose Your Blood Type
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 px-8 max-w-6xl mx-auto">

      <?php foreach ($bloodTypes as $bloodType): ?>
        <form method="POST" action="bloodTypeResult.php">
          <input type="hidden" name="blood_type" value="<?= htmlspecialchars($bloodType) ?>">
          <button type="submit"
            class="glass w-full h-24 flex items-center justify-center text-xl font-bold text-red-600 hover:bg-red-100 transition rounded-2xl shadow">
            <?= htmlspecialchars($bloodType) ?>
          </button>
        </form>
      <?php endforeach; ?>

    </div>
  </section>

</body>

</html>
