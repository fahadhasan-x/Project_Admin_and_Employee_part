<!DOCTYPE html>
<html>

<head>
    <title>Game Upload</title>
</head>

<body>
    <div style="text-align: center;">
        <a href="employee_home.php" style="text-decoration: none; color: #777;">
            <h2> Upload Game</h2>
        </a>
    </div>

    

    <?php
   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $description = $_POST["description"];

        
        $targetDirectory = 'C:\xampp\htdocs\Employee';

      
        $targetFile = $targetDirectory . basename($_FILES["gameFile"]["name"]);

        
        $uploadOk = 1;

       
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        
        if (file_exists($targetFile)) {
            echo "Sorry, the file already exists.";
            $uploadOk = 0;
        }

      
        $allowedFileTypes = array("zip", "rar", "7z", "png");
        if (!in_array($fileType, $allowedFileTypes)) {
            echo "Sorry, only ZIP, RAR, 7z, and PNG files are allowed.";
            $uploadOk = 0;
        }

       
        if ($uploadOk == 1 && move_uploaded_file($_FILES["gameFile"]["tmp_name"], $targetFile)) {
           
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "abd";
            $conn = new mysqli($servername, $username, $password, $dbname);

         
            $sqlMaxGameNo = "SELECT MAX(No) as maxGameNo FROM game_database";
            $resultMaxGameNo = $conn->query($sqlMaxGameNo);

            if ($resultMaxGameNo->num_rows > 0) {
                $rowMaxGameNo = $resultMaxGameNo->fetch_assoc();
                $newGameNo = $rowMaxGameNo['maxGameNo'] + 1;

            
                $sql = "INSERT INTO game_database (No, Title, Description, Filepath) VALUES ('$newGameNo', '$title', '$description', '$targetFile')";
                if ($conn->query($sql) === TRUE) {
                    echo "The game has been uploaded and added to the database.";

                   
                    $conn->close();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error fetching maximum game number.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    ?>

   
    <form method="post" enctype="multipart/form-data">
        Title: <input type="text" name="title" required><br>
        Description: <textarea name="description" required></textarea><br>
        Select Game File (ZIP, RAR, 7z, PNG only): <input type="file" name="gameFile" accept=".zip, .rar, .7z, .png" required><br>
        <input type="submit" value="Upload Game">
    </form>
</body>

</html>
