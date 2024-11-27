<!DOCTYPE html>
<html>

<head>
    <title>Employee Information</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        form input {
            padding: 8px;
            margin: 5px;
        }

        form button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2980b9;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        table button {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
        }

        table button:hover {
            background-color: #c0392b;
        }

        .back-btn {
            margin-top: 20px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abd";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if (isset($_POST['del'])) {
        $a = $_POST['del'];
        $sql2 = "DELETE FROM ab WHERE ID='$a'";
        mysqli_query($conn, $sql2);
    }

    if (isset($_POST['add'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $approvalStatus = 'Pending';

        if (empty($id)) {
            echo "ID is empty";
        } else {
            $sql3 = "INSERT INTO ab (ID, Name, Email, Pass, approvalStatus) VALUES ('$id', '$name', '$email', '$pass', '$approvalStatus')";
            mysqli_query($conn, $sql3);
        }
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $approvalStatus = 'Pending';

        $sql4 = "UPDATE ab SET Name='$name', Email='$email', Pass='$pass', approvalStatus='$approvalStatus' WHERE ID='$id'";
        mysqli_query($conn, $sql4);
    }

    $sql = "SELECT * FROM ab";
    $res = mysqli_query($conn, $sql);
    ?>

    <div>
        <a href="employee_information.php" style="text-decoration: none; color: #777;">
            <h2>Employee Information</h2>
        </a>
    </div>

    <form method="post">
        ID: <input type="number" name="id">
        Name: <input type="text" name="name">
        Email: <input type="text" name="email">
        Pass: <input type="text" name="pass">
        <button type="Submit" name="add">Add</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Approval Status</th>
            <th>Operation</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($res)) {
            $isUpdatedOrDeleted = $r['approvalStatus'] === 'Approved' && (isset($r['operation']) && ($r['operation'] === 'Edit' || $r['operation'] === 'Delete'));
        ?>
            <tr>
                <td><?php echo $r["ID"]; ?></td>
                <td><?php echo $r["Name"]; ?></td>
                <td><?php echo $r["Email"]; ?></td>
                <td><?php echo $r["approvalStatus"]; ?></td>
                <td>
                    <?php if ($r["approvalStatus"] == 'Approved' && !$isUpdatedOrDeleted) { ?>
                        <form method="post">
                            <button type="Submit" name="del" value="<?php echo $r["ID"]; ?>">Delete</button>
                        </form>
                        <form method="get" action="edit.php">
                            <input type="hidden" name="edit" value="<?php echo $r["ID"]; ?>">
                            <button type="Submit">Edit</button>
                        </form>
                    <?php } else { ?>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $r["ID"]; ?>">
                            <input type="hidden" name="name" value="<?php echo $r["Name"]; ?>">
                            <input type="hidden" name="email" value="<?php echo $r["Email"]; ?>">
                            <input type="hidden" name="pass" value="<?php echo $r["Pass"]; ?>">
                            <button type="Submit" name="update">Update</button>
                        </form>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="back-btn">
        <a href="employee_home.php">Back to Employee Home</a>
    </div>

</body>

</html>
