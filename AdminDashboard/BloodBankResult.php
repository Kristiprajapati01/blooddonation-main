<?php
require('../connection.php');
session_start();

// Step 1: Get blood bank ID from URL
$bloodBankId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize variables
$bloodBank = null;
$bloodDetailsResult = null;

if ($bloodBankId > 0) {
    // Step 2: Fetch blood bank info
    $bloodBankQuery = "SELECT * FROM bloodbank WHERE id = $bloodBankId";
    $bloodBankResult = $con->query($bloodBankQuery);

    if (!$bloodBankResult) {
        echo "Error fetching blood bank: " . $con->error;
    } elseif ($bloodBankResult->num_rows > 0) {
        $bloodBank = $bloodBankResult->fetch_assoc();
    } else {
        echo "<p style='color: red;'>No blood bank found with ID: $bloodBankId</p>";
    }

    // Step 3: Fetch blood details if bank is valid
    if ($bloodBank) {
        $bloodDetailsQuery = "SELECT bloodgroup, bloodqty FROM blood_details WHERE bloodbank_id = $bloodBankId";
        $bloodDetailsResult = $con->query($bloodDetailsQuery);

        if (!$bloodDetailsResult) {
            echo "Error fetching blood details: " . $con->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Details for <?php echo htmlspecialchars($bloodBank['fullname']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    
    </style>
</head>

<body class="bg-gray-200 font-sans">
    <!-- <?php @include('header.php'); ?> -->
    <section class="container max-w-5xl mx-auto pt-32 pb-16">
    <title>Blood Details for <?php echo isset($bloodBank['fullname']) ? htmlspecialchars($bloodBank['fullname']) : 'Unknown'; ?></title>

    <h1 class="text-4xl font-bold mb-8 text-gray-900 text-center">
        Available Blood Details of <?php echo isset($bloodBank['fullname']) ? htmlspecialchars($bloodBank['fullname']) : 'Unknown'; ?>
    </h1>
        <?php if ($bloodDetailsResult->num_rows > 0) { ?>
            <div class="bg-white rounded-lg overflow-hidden shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-md font-lg">Blood Group</th>
                            <th class="px-6 py-3 text-left text-md font-lg">Total Blood Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white ">
                        <?php while ($row = $bloodDetailsResult->fetch_assoc()) { ?>
                            <tr>
                                <td class="px-6 py-4  text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['bloodgroup']); ?></td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['bloodqty']); ?></td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p class="text-center text-lg font-semibold text-red-600">currently No blood available for this blood bank.</p>
        <?php } ?>
    </section>
</body>

</html>
