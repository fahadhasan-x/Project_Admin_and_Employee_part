<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abd";
$conn = new mysqli($servername, $username, $password, $dbname);

$message = ''; 
$lastInsertedId = null;





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO ab (Name, Email, Pass) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $lastInsertedId = $conn->insert_id;
        $message = "Registration successful! Your Auto-Incremented ID is: $lastInsertedId";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <title>Registration Page</title>
    <script>
        function validateForm() {
            var name = document.getElementsByName("name")[0].value;
            var email = document.getElementsByName("email")[0].value;
            var password = document.getElementsByName("password")[0].value;

            if (name === "" || email === "" || password === "") {
                alert("Please fill in all fields.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <h2>Registration</h2>
    <form method="post" onsubmit="return validateForm();">
        
        ID: <input type="number" name="id" placeholder="<?php echo $lastInsertedId ?? ''; ?>" readonly><br>
        Name: <input type="text" name="name"><br>
        Email: <input type="email" name="email"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Register">
    </form>
    
    <?php
    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    ?>

    <p><a href="login.php">Back to Employee login </a></p>
</body>

</html>
