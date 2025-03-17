<?php
// Start a session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header('Location: welcome.php');
    exit();
}

// Configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'mysql';
$dbName = 'portfolio_project';

// Create a database connection
$connection = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Get the user ID
$user_id = $_SESSION['user_id'];
// Retrieve user data from the database
$query = "SELECT * FROM portfolio WHERE user_id='$user_id'";
$result = $connection->query($query);

// Initialize variables
$firstName = '';
$lastName = '';
$title = '';
$email = '';
$phone = '';
$age = '';
$gender = '';

// Check if user data exists
$new=0;
if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();
    $firstName = $row['firstname'];
    $title = $row['title'];
    $lastName = $row['lastname'];
    $email = $row['email'];
    $phone = $row['phone'];
    $age = $row['age'];
    $gender = $row['gender'];
    $description = $row['description'];
    $photo = $row['photo'];
}else{
    $new=1;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = $_POST['firstname'];
    $title = $_POST['title'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $photo = time().basename($_FILES["photo"]["name"]);
    $description = $_POST['description'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email address.';
    }
    // Validate phone number (assuming a 10-digit format)
    elseif (!preg_match('/^\d{10}$/', $phone)) {
        echo 'Invalid phone number.';
    } else {
        // Process form data
        // Save the photo to a desired location
        $photoPath = 'images/'.$photo;

        // Check if user data already exists
        $existingQuery = "SELECT * FROM portfolio WHERE user_id='$user_id'";
        $existingResult = $connection->query($existingQuery);
        if ($existingResult->num_rows > 0) {
            // Update existing user data
            $updateQuery = "UPDATE portfolio SET firstname='$firstName', lastname='$lastName', email='$email', phone='$phone', age='$age', gender='$gender', photo='$photo', description='$description', title='$title' WHERE user_id='$user_id'";
            $updateResult = $connection->query($updateQuery);
            
            if ($updateResult) {
                move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath);
                echo '<div class="alert alert-success" role="alert">
                        User data updated successfully!
                    </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Error: Unable to update user data.
                    </div>';
            }
        } else {
            // Insert new user data
            $insertQuery = "INSERT INTO portfolio (user_id, firstname, lastname, email, phone, age, gender, photo, description, title) VALUES ('$user_id', '$firstName', '$lastName', '$email', '$phone', '$age', '$gender', '$photo', '$description', '$title')";
            $insertResult = $connection->query($insertQuery);

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
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
    <title>My Portfolio</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/7b39153ed3.js" crossorigin="anonymous"></script>
</head>
<body class="container mt-4 bg-light">
    <div class="text-center mb-4">
        <h2>My Portfolio</h2>
        <div class="btn-group">
            <a class="btn btn-primary" href="welcome.php">Home</a>
            <a class="btn btn-secondary" href="services.php">My services</a>
            <a class="btn btn-dark" href="projects.php">My projects</a>
            <a class="btn btn-warning" href="welcome.php?logout">Logout</a>
        </div>
    </div>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input class="form-control"  aria-describedby="firstname" type="text" id="firstname" name="firstname" value="<?php echo isset($firstName)?$firstName:''; ?>" required>
                    <!-- <small id="firstname" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input class="form-control"  aria-describedby="lastname" type="text" id="lastname" name="lastname" value="<?php echo isset($lastName)?$lastName:''; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" id="title" name="title" value="<?php echo isset($title)?$title:''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="age">Age</label>
                    <input class="form-control"  aria-describedby="age" type="number" id="age" name="age" value="<?php echo isset($age)?$age:''; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" id="email" name="email" value="<?php echo isset($email)?$email:''; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input class="form-control" type="tel" id="phone" name="phone" pattern="[0-9]{10}" value="<?php echo isset($phone)?$phone:''; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 m-auto text-center">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php echo ($gender === 'male') ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="male">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php echo ($gender === 'female') ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="female">
                            Female
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input class="form-control" type="file" id="photo" name="photo" accept="image/jpeg, image/png" <?php if (!isset($photo)){ echo "required"; } ?>><br>
                    <?php if (isset($photo)){ ?>
                    <?php $imageURL='images/'.$photo; ?>
                    <img src="<?php echo $imageURL; ?>" alt="" style="max-width:200px;width:100%"/>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label><br>
            <textarea class="form-control" id="description" name="description" rows="4" cols="50"><?php echo (isset($description))?$description:''; ?></textarea>
        </div>
        <input type="submit" class="btn btn-success btn-block"value="Submit">
    </form>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="js/bootstrap.bundle.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      
</body>
</html>