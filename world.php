<?php
$host = '127.0.0.1';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

try {
    // Establish connection
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the country and lookup query parameters
    $country = $_GET['country'] ?? '';
    $lookup = $_GET['lookup'] ?? '';

    if ($lookup === 'cities') {
        // Query to get cities in the country
        $query = "SELECT cities.name AS city_name, cities.district, cities.population 
                  FROM cities 
                  JOIN countries ON cities.country_code = countries.code 
                  WHERE countries.name LIKE :country";
        $statement = $connection->prepare($query);
        $statement->execute([':country' => '%' . $country . '%']);

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Output cities as an HTML table
        if ($results) {
            echo "<table border='1'>";
            echo "<thead>
                    <tr>
                        <th>Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            foreach ($results as $row) {
                echo "<tr>
                        <td>{$row['city_name']}</td>
                        <td>{$row['district']}</td>
                        <td>{$row['population']}</td>
                      </tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No cities found for the specified country.</p>";
        }
    } else {
        // Query to get country information (existing functionality)
        $query = "SELECT name, continent, independence_year, head_of_state 
                  FROM countries 
                  WHERE name LIKE :country";
        $statement = $connection->prepare($query);
        $statement->execute([':country' => '%' . $country . '%']);

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Output countries as an HTML table
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
            echo "<p>No results found for the specified country.</p>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
