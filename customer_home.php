<!DOCTYPE html>
<html>

<head>
    <title>Customer Home</title>
</head>

<body>
    <h2>Welcome to the Customer Portal</h2>

    <?php
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abd";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle the purchase logic if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $gameId = $_POST["gameId"];

        // Update the Sold column in the game_database table
        $sql = "UPDATE game_database SET Sold = Sold + 1 WHERE No = $gameId";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Thank you for your purchase!</p>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Query to select game information
    $sql = "SELECT No, Title, Description, Filepath, Sold FROM game_database";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>No</th><th>Title</th><th>Description</th><th>Filepath</th><th>Sold</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['No']}</td>";
            echo "<td>{$row['Title']}</td>";
            echo "<td>{$row['Description']}</td>";
            echo "<td>{$row['Filepath']}</td>";
            echo "<td>{$row['Sold']}</td>";
            echo "<td>";
            // Add a form for purchasing each game
            echo "<form method='post'>";
            echo "<input type='hidden' name='gameId' value='{$row['No']}'>";
            echo "<input type='submit' value='Buy'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No games found in the database.";
    }

    // Close the connection
    $conn->close();
    ?>

    <!-- Add more content or features as needed -->
</body>

</html>
