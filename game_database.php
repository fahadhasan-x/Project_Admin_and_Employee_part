<!DOCTYPE html>
<html>

<head>
    <title>View Game Database</title>

    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            margin-top: 20px;
        }

        a.button {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        a.button:hover {
            background-color: #2980b9;
        }

        .back-btn {
            margin-top: 20px;
        }
    
    </style>
</head>

<body>

    <div>
        <a href="game_database.php" style="text-decoration: none; color: #333;">
            <h2>Game Database</h2>
        </a>
    </div>

    <br><br>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abd";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['action']) && isset($_GET['id'])) {
        // Handle edit and delete actions
        $action = $_GET['action'];
        $id = $_GET['id'];

        if ($action == 'edit') {
            // Redirect to the edit page with the game ID
            header("Location: edit_game.php?id=$id");
            exit();
        } elseif ($action == 'delete') {
            // Perform delete operation
            $sql = "DELETE FROM game_database WHERE No = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Record deleted successfully.</p>";
            } else {
                echo "<p>Error deleting record: " . $conn->error . "</p>";
            }
        }
    }

    $sql = "SELECT * FROM game_database";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo "<table>";
        echo "<tr><th>No</th><th>Title</th><th>Description</th><th>Image</th><th>Sold</th><th>Download</th><th>Edit</th><th>Delete</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['No']}</td>";
            echo "<td>{$row['Title']}</td>";
            echo "<td>{$row['Description']}</td>";



           // Display the image if the file type is an image
$fileType = strtolower(pathinfo($row['Filepath'], PATHINFO_EXTENSION));
if (in_array($fileType, array("png", "jpg", "jpeg", "gif"))) {
    echo "<td><img src='{$row['Filepath']}' alt='Game Image' style='width:100px; height:100px; object-fit: cover;'></td>";
} else {
    echo "<td>{$row['Filepath']}</td>";
}





            echo "<td>{$row['Sold']}</td>";
            // Add the Download button
            echo "<td><button class='download-button' data-file='{$row['Filepath']}'>Download</button></td>";
            // Add the Edit and Delete links
            echo "<td><a href='game_database.php?action=edit&id={$row['No']}'>Edit</a></td>";
            echo "<td><a href='game_database.php?action=delete&id={$row['No']}'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No games found in the database.</p>";
    }

    $conn->close();
    ?>

    <p >
        <a href="upload_game.php" >Upload a New Game</a>
    </p>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var downloadButtons = document.querySelectorAll('.download-button');

        downloadButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var filePath = this.getAttribute('data-file');
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'download.php?file=' + filePath, true);
                xhr.responseType = 'blob';

                xhr.onload = function () {
                    var blob = xhr.response;
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filePath.split('/').pop();
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                };

                xhr.send();
            });
        });
    });
    </script>

    <div class="back-btn">
        <a href="employee_home.php">Back to Employee Home</a>
    </div>
</body>

</html>
