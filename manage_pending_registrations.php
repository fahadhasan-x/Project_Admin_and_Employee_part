<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
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

        button {
            background-color: #2ecc71;
            color: #fff;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #27ae60;
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

    <div>
        <a href="manage_pending_registrations.php" style="text-decoration: none; color: #333;">
            <h2>Admin Dashboard</h2>
        </a>
    </div>

    <table border="1" align="center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Operation</th>
        </tr>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "abd";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if (isset($_POST['approve'])) {
            $id = $_POST['approve'];
            $sql = "UPDATE ab SET approvalStatus='Approved' WHERE ID='$id'";
            mysqli_query($conn, $sql);
        }

        if (isset($_POST['reject'])) {
            $id = $_POST['reject'];
            $sql = "UPDATE ab SET approvalStatus='Rejected' WHERE ID='$id'";
            mysqli_query($conn, $sql);
        }

        $sql = "SELECT * FROM ab WHERE approvalStatus='Pending'";
        $res = mysqli_query($conn, $sql);

        while ($r = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo $r["ID"]; ?></td>
                <td><?php echo $r["Name"]; ?></td>
                <td><?php echo $r["Email"]; ?></td>
                <td>
                    <form method="post">
                        <button type="Submit" name="approve" value="<?php echo $r["ID"]; ?>">Approve</button>
                    </form>
                    <form method="post">
                        <button type="Submit" name="reject" value="<?php echo $r["ID"]; ?>">Reject</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="back-btn">
        <a href="employee_home.php">Back to Employee Home</a>
    </div>

</body>

</html>
