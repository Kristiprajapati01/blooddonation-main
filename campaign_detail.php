<?php
require('connection.php');

if (!isset($_GET['id'])) {
    echo "No campaign specified.";
    exit();
}

$campaignId = $_GET['id'];

$sql = "SELECT * FROM campaigns WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $campaignId);
$stmt->execute();
$result = $stmt->get_result();
$campaign = $result->fetch_assoc();

if (!$campaign) {
    echo "Campaign not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-img {
            background-image: url('img/type.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        
    </style>
</head>

<body class="bg-gray-100">
    <?php @include('header.php'); ?>

    <section class="container mx-auto pt-32 bg-img">
        <h1 class="text-3xl font-bold mb-8 text-center text-red-600"><?php echo htmlspecialchars($campaign['campaign_name']); ?></h1>
        <div class="bg-white p-8 rounded-lg shadow-lg border border-red-600">
            <p class="text-lg text-gray-800 mb-4"><strong class="text-red-600">Contact Number:</strong> <?php echo htmlspecialchars($campaign['contact_number']); ?></p>
            <p class="text-lg text-gray-800 mb-4"><strong class="text-red-600">Campaign Date:</strong> <?php echo htmlspecialchars($campaign['campaign_date']); ?></p>
            <p class="text-lg text-gray-800 mb-4"><strong class="text-red-600">Description:</strong> <?php echo htmlspecialchars($campaign['description']); ?></p>
            <p class="text-lg text-gray-800 mb-4"><strong class="text-red-600">Location:</strong> <?php echo htmlspecialchars($campaign['location']); ?></p>
        </div>
        <a href="index.php" class="mt-4 inline-block bg-red-600 hover:bg-red-700 transition-colors duration-300 text-white py-2 px-4 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            Back to Campaigns
        </a>
    </section>
</body>


</html>

<?php
$con->close();
?>
