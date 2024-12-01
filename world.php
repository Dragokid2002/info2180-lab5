<?php
$host = '127.0.0.1';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

try {
    // Establish connection
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the country query parameter from the GET request
    $country = $_GET['country'] ?? '';

    // Prepare the SQL query based on the country parameter
    if (!empty($country)) {
        $query = "SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country";
        $statement = $connection->prepare($query);
        $statement->execute([':country' => '%' . $country . '%']);
    } else {
        $query = "SELECT name, continent, independence_year, head_of_state FROM countries";
        $statement = $connection->prepare($query);
        $statement->execute();
    }

    // Fetch results
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Output results as an HTML table
    if ($results) {
        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
              </thead>";
        echo "<tbody>";

        foreach ($results as $row) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['continent']}</td>
                    <td>" . ($row['independence_year'] ?? 'N/A') . "</td>
                    <td>" . ($row['head_of_state'] ?? 'N/A') . "</td>
                  </tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No results found.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
