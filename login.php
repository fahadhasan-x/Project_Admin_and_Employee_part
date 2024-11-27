<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('back.gif'); 
            background-size: cover;
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #fff;
        }

        form {
            text-align: center;
            margin: 20px auto;
            max-width: 300px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
            color: #fff; /* Set the input text color to white */
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
        }

        p {
            text-align: center;
            margin-top: 10px;
            color: #fff;
        }

        a {
            color: #3498db;
        }
    </style>

    <script>
        function showNotification() {
            alert("Invalid User. Please check your ID and Password.");
        }

        function validateForm() {
            var id = document.forms["loginForm"]["id"].value;
            var pass = document.forms["loginForm"]["pass"].value;

            if (id === "" || pass === "") {
                alert("Please fill in both ID and Password.");
                return false;
            }
        }
    </script>

</head>

<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abd";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $pass = $_POST["pass"];

    $sql = "SELECT * FROM ab WHERE ID='$id' AND Pass='$pass'";
    $res = mysqli_query($conn, $sql);

    if ($res->num_rows > 0) {
        while ($r = mysqli_fetch_assoc($res)) {
            $_SESSION['id'] = $r["ID"];
            header("location: employee_home.php");
        }
    } else {
        echo '<script>showNotification();</script>';
    }
}
?>

<body>
    <h2>Indie Game Store</h2>

    <h2>Login</h2>
    <form name="loginForm" method="post" onsubmit="return validateForm()">
        ID: <input type="number" name="id"><br>
        Password: <input type="password" name="pass"><br>
        <button type="submit">Login</button>
    </form>

    
    <p>Forgot your password? <a href="forgot_password.php">Reset Password</a></p>

    <p>Don't have an account? <a href="registration.php">Register here</a></p>
</body>

</html>
