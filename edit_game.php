<!DOCTYPE html>
<html>

<head>
    <title>Edit Game</title>
</head>

<body>

    <div style="text-align: center;">
        <a href="employee_home.php" style="text-decoration: none; color: #777;">
            <h2> Employee Portal</h2>
        </a>
    </div>
    <hr>

    <h2>Edit Game</h2>
    <br>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abd";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission for updating game details
        $id = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];

        $sql = "UPDATE game_database SET Title='$title', Description='$description' WHERE No=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if (isset($_GET['id'])) {
        // Retrieve the game details based on the provided ID
        $id = $_GET['id'];
        $sql = "SELECT * FROM game_database WHERE No=$id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
    ?>

            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['No']; ?>">
                Title: <input type="text" name="title" value="<?php echo $row['Title']; ?>" required><br>
                Description: <textarea name="description" required><?php echo $row['Description']; ?></textarea><br>
                <input type="submit" value="Update">
            </form>

    <?php
        } else {
            echo "Game not found.";
        }
    }

    $conn->close();
    ?>

    <p><a href="game_database.php">Back to Game Database</a></p>

</body>

</html>
