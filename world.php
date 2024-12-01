<?php
$host = '127.0.0.1';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

// Establish connection
$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if 'country' is passed in the GET request
$country = $_GET['country'] ?? '';

// Prepare the SQL query
if (!empty($country)) {
    $query = "SELECT * FROM countries WHERE name LIKE :country";
    $statement = $connection->prepare($query);
    $statement->execute([':country' => '%' . $country . '%']);
} else {
    $query = "SELECT * FROM countries";
    $statement = $connection->prepare($query);
    $statement->execute();
}

// Fetch results
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

// Output results as HTML
foreach ($results as $row) {
    echo "<p><strong>{$row['name']}</strong> - Head of State: {$row['head_of_state']}</p>";
}
?>
