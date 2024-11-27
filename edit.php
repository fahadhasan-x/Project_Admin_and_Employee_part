<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abd";
$conn = new mysqli($servername, $username, $password, $dbname);



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];

    
    $sql = "SELECT * FROM ab WHERE ID = $editId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $editName = $row['Name'];
        $editEmail = $row['Email'];
        $editPass = $row['Pass'];
    } else {
        echo "Employee not found!";
        exit();
    }
}

// Update operation
if (isset($_POST['update'])) {
    $editId = $_POST['editId'];
    $editName = $_POST['editName'];
    $editEmail = $_POST['editEmail'];
    $editPass = $_POST['editPass'];

    $sql = "UPDATE ab SET Name='$editName', Email='$editEmail', Pass='$editPass' WHERE ID='$editId'";
    $result = $conn->query($sql);

    if ($result) {
        echo "Employee information updated successfully!";
    } else {
        echo "Error updating employee information: " . $conn->error;
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html>

<head>
    <title>Edit Employee Information</title>
</head>

<body>

  <div style="text-align: center;">
        <a href="employee_home.php" style="text-decoration: none; color: #777;">
            <h2>Edit Employee Information</h2>
        </a>
    </div>    



    
    <form method="post">
        <input type="hidden" name="editId" value="<?php echo $editId; ?>">
        Name: <input type="text" name="editName" value="<?php echo $editName; ?>"><br>
        Email: <input type="text" name="editEmail" value="<?php echo $editEmail; ?>"><br>
        Pass: <input type="text" name="editPass" value="<?php echo $editPass; ?>"><br>
        <button type="Submit" name="update">Update</button>
    </form>

    <p><a href="employee_Information.php">Back to Employee List</a></p>
</body>

</html>
