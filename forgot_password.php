<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        form {
            margin: 20px auto;
            max-width: 300px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
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
            margin-top: 10px;
        }

        a {
            color: #3498db;
        }
    </style>
</head>

<body>
    <h2>Reset Password</h2>

    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abd";
    $conn = new mysqli($servername, $username, $password, $dbname);






    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $newPass = $_POST["newPass"];

        $sql = "SELECT * FROM ab WHERE ID='$id'";
        $res = mysqli_query($conn, $sql);






        if ($res->num_rows > 0) {
            $updateSql = "UPDATE ab SET Pass='$newPass' WHERE ID='$id'";
            if (mysqli_query($conn, $updateSql)) {
                echo "Password updated successfully. You can now <a href='login.php'>login</a> with your new password.";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid ID. Please check your ID and try again.";
        }
    }
    ?>
    




    <form method="post">
        ID: <input type="number" name="id" required><br>
        New Password: <input type="password" name="newPass" required><br>
        <button type="submit">Reset Password</button>
    </form>

    <p><a href="login.php">Back to Employee login </a></p>
</body>

</html>
