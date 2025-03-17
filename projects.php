<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/7b39153ed3.js" crossorigin="anonymous"></script>
    <title>My Projects</title>
</head>
<body class="container mt-4 bg-light">
    <?php
    // Establish database connection
    $servername = 'localhost';
    $username = 'root';
    $password = 'mysql';
    $database = 'portfolio_project';
    
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    session_start();

    $user_id = $_SESSION['user_id'];

    // Check if form data is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Add a new row to the table
        // $user_id = $_SESSION['user_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $photo = time().basename($_FILES["photo"]["name"]);
        $photoPath = 'images/portfolio/'.$photo;
        $link = $_POST['link'];


        $sql = "INSERT INTO project (user_id, title, content, photo, link) VALUES ('$user_id', '$title', '$content', '$photo', '$link')";
        $insertResult = $conn->query($sql);

            if ($insertResult) {
                move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath);
                echo '<div class="alert alert-success" role="alert">
                    User data inserted successfully!
                </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Error: Unable to insert user data.
                    </div>';
            }

        // if ($conn->query($sql) === FALSE) {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }
    }

    // Check if delete button is clicked
    if (isset($_GET['delete'])) {
        // Delete the row from the table
        $deleteIndex = $_GET['delete'];
        $sql = "DELETE FROM project WHERE id = '$deleteIndex'";

        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Retrieve table data
    $sql = "SELECT * FROM project WHERE user_id=$user_id";
    $result = $conn->query($sql);
    $tableData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tableData[] = $row;
        }
    }

    // Close the database connection
    $conn->close();
    ?>

<div class="text-center mb-4">
        <h2>My Projects</h2>
        <div class="btn-group">
            <a class="btn btn-primary" href="welcome.php">Home</a>
            <a class="btn btn-secondary" href="services.php">My services</a>
            <a class="btn btn-dark" href="portfolio.php">My Portfolio</a>
            <a class="btn btn-warning" href="welcome.php?logout">Logout</a>
        </div>
    </div>
    <form method="post" enctype="multipart/form-data">
      
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" id="title" name="title" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input class="form-control" type="file" id="photo" name="photo" accept="image/jpeg, image/png" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="content">Content</label><br>
            <textarea class="form-control" id="content" name="content" rows="4" cols="50"></textarea>
        </div>
        <div class="form-group">
            <label for="link">Link</label><br>
            <input class="form-control" placeholder="https://www.google.com/" type="url" name="link" id="link" required>
        </div>

        <input type="submit" class="btn btn-success btn-block"value="Add">
    </form>
    

    <table  class="table table-striped table-dark mt-4" border="1">
        <thead>
        <tr>
                <th width="10%">Photo</th>
                <th>Title</th>
                <th>content</th>
                <th width="5%">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display table rows with data
            foreach ($tableData as $row) {
                $id = $row['id'];
                $title = $row['title'];
                $content = $row['content'];
                $photo = $row['photo'];
                echo "<tr>";
                echo "<td><img style='max-width: 60px;' src='images/portfolio/".$photo."' alt=''></td>";
                echo "<td>$title</td>";
                echo "<td>$content</td>";
                echo "<td class='text-center'><a class='fas fa-times btn btn-danger' href='projects.php?delete=$id'></a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
