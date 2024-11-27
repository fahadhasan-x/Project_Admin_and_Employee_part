<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('location: login.php');
    exit();
}

$employeeDetails = getEmployeeDetails($_SESSION['id']);

function getEmployeeDetails($employeeId)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abd";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT ID, Name FROM ab WHERE ID='$employeeId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employeeDetails = $result->fetch_assoc();
        return $employeeDetails;
    } else {
        return false;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h2 {
            margin-bottom: 20px;
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }

        .center {
            text-align: center;
        }

        .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 14px;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        button.database-button {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button.database-button:hover {
            background-color: #2980b9;
        }

        #content-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>



    <?php
    if ($employeeDetails && $employeeDetails['ID'] == 1) {
        echo '<div class="center">
                <a href="employee_home.php" style="text-decoration: none; color: #333;">
                    <h2>Welcome Admin Portal</h2>
                </a>
              </div>';
    } else {
        echo '<div class="center">
                <a href="employee_home.php" style="text-decoration: none; color: #333;">
                    <h2>Welcome Employee Portal</h2>
                </a>
              </div>';
    }
    ?>

    <hr>



    <div class="user-info">
        <?php
        if ($employeeDetails) {
            echo "ID: " . $employeeDetails['ID'] . " | ";
            echo "Name: " . $employeeDetails['Name'];
        } else {
            echo "Employee details not found";
        }
        ?>




    </div>

    <div class="logout-btn">
        <form method="get">
            <button type="submit" name="logout" class="database-button">Logout</button>
        </form>
    </div>

    <div class="center">
        <button class="database-button" onclick="loadContent('game_database.php')">Game Database Table</button>
    </div>

    <hr>

    <div class="center">
        <button class="database-button" onclick="loadContent('employee_Information.php')">Employee Information Table</button>
    </div>

    <hr>





    <?php
    if ($employeeDetails && $employeeDetails['ID'] == 1) {
        echo '<div class="center">
                <button class="database-button" onclick="loadContent(\'manage_pending_registrations.php\')">Manage Pending Registrations</button>
              </div><hr>';
    }
    ?>




    <div id="content-container"></div>

    <script>
        function loadContent(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", page, true);
            xhttp.send();
        }
    </script>

</body>

</html>
