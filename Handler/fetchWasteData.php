<?php
header('Content-Type: application/json');

// Example data (replace with actual data from your database)
$wasteData = [
    'January' => 65520,
    'February' => 0,
    'March' => 12390,
    'April' => 40230,
    'May' => 0,
    'June' => 0,
    'July' => 0,
    'August' => 15210,
    'September' => 0,
    'October' => 4400,
    'November' => 0,
    'December' => 17480,
];

echo json_encode(['success' => true, 'wasteData' => $wasteData]);
?>
