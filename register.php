<?php
// Configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'mysql';
$dbName = 'portfolio_project';

// Start a session
session_start();

// Create a database connection
$connection = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to a welcome page or any other protected page
    header('Location: welcome.php');
    exit();
}

// Register a user
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Perform some basic validation on the input
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        echo 'Please fill in all the fields.';
    } elseif ($password !== $confirmPassword) {
        echo 'Passwords do not match.';
    } else {
        // Check if the username already exists
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = $connection->query($query);

        if (isset($result->num_rows) > 0) {
            echo 'Username already exists. Please choose a different username.';
        } else {
            // Insert the new user into the database
            $query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
            $insert = $connection->query($query);

            if ($insert) {
                // Fetch the user ID
                $user_id = $connection->insert_id;

                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;

                // Redirect to a welcome page or any other protected page
                header('Location: welcome.php');
                exit();
            } else {
                echo 'Error: ' . $connection->error;
            }
        }
    }
}


// Close the database connection
$connection->close();
?>


<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login page</title>
  <link rel="stylesheet" href="style.css" />
  <style>
	@import url("https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;1,600;1,700&display=swap");

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  display: grid;
  place-items: center;
  font-family: "Nunito", sans-serif;
  height: 100vh;
}
/* headings */
h1 {
  font-weight: bold;
  margin: 0;
  font-size: 20px;
}
/* headings */
/* paragraphs */
p {
  font-size: 0.9em;
  font-weight: 200;
  line-height: 1.3em;
  letter-spacing: 0.1em;
  margin: 20px 0;
}
/* paragraphs */
/* span tags */
span {
  font-size: 14px;
  color: #a9a9a9;
}
span .forgot {
  color: #c850c0;
  cursor: pointer;
}
/* span tags */
a {
  color: #333;
  font-size: 14px;
  text-decoration: none;
  margin: 15px 0;
}

/* form */
form {
  background-color: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 50px;
  height: 100%;
  text-align: center;
}
/* form */
/* input fields */
input {
  background-color: #ecececdd;
  border: none;
  font-size: 14px;
  padding: 10px 12px;
  margin: 8px 0;
  width: 100%;
  color: #333;
  outline: none;
  border-radius: 5px;
}
/* input fields */

/* button */
a {
  text-decoration: none;
  position: relative;
  border: none;
  font-size: 14px;
  font-weight: 500;
  color: #fff;
  width: 9em;
  height: 3em;
  line-height: 3em;
  text-align: center;
  background: linear-gradient(90deg, #4158d0, #f441a5, #ffcc70, #4158d0);
  background-size: 300%;
  border-radius: 30px;
  z-index: 1;
  margin-top: 30px;
  cursor: pointer;
}

a:hover {
  animation: ani 8s linear infinite;
  border: none;
}

@keyframes ani {
  0% {
    background-position: 0%;
  }

  100% {
    background-position: 200%;
  }
}

a:before {
  content: "";
  position: absolute;
  top: -5px;
  left: -5px;
  right: -5px;
  bottom: -5px;
  z-index: -1;
  background: linear-gradient(90deg, #4158d0, #f441a5, #ffcc70, #4158d0);
  background-size: 400%;
  border-radius: 35px;
  transition: 1s;
}

a:hover::before {
  filter: blur(10px);
}

a:active {
  background: linear-gradient(90deg, #4158d0, #f441a5, #ffcc70, #4158d0);
}

/* button */

/* container */
.container {
  background-color: #ffffff;
  border-radius: 2em;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  position: relative;
  overflow: hidden;
  width: 650px;
  max-width: 100%;
  min-height: 550px;
}
.form {
  position: absolute;
  top: 0;
  height: 100%;
  transition: all ease-in-out 0.6s;
}
.sign_up {
  left: 0;
  width: 50%;
  opacity: 0;
  z-index: 1;
}
.sign_in {
  left: 0;
  width: 50%;
  z-index: 2;
  opacity: 1;
}
/* container */

/* active container */
.container.right-panel-active .sign_in {
  transform: translateX(100%);
  opacity: 0;
}
.container.right-panel-active .sign_up {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: switch 0.5s;
}
@keyframes switch {
  0%,
  49.99% {
    opacity: 0;
    z-index: 1;
  }
  50%,
  100% {
    opacity: 1;
    z-index: 5;
  }
}

/* active container */

/* overlay container*/
.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}
.overlay {
  background-color: #4158d0;
  background-image: linear-gradient(
    43deg,
    #4158d0 0%,
    #c850c0 46%,
    #ffcc70 100%
  );
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 0 0;
  color: #fff;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}
.overlay-pannel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform -0.6s ease-in-out;
}
.overlay-left {
  transform: translateX(-20%);
}
.overlay-right {
  right: 0;
  transform: translateX(0);
}
/* container switch */
.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}
.container.right-panel-active .overlay {
  transform: translateX(50%);
}
.container.right-panel-active .overlay-left {
  transform: translateX(0);
}
.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}
/* container switch */

/* overlay container */

/* social container */
.social-container {
  margin: 20px 0;
}
.social-container a {
  border: 1px solid #dddd;
  border-radius: 50%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 0 5px;
  height: 40px;
  width: 40px;
  cursor: pointer;
}
/* social container */

  </style>
  <script src="https://kit.fontawesome.com/7b39153ed3.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container" id="container">



    <!-- sign in form section start-->
    <div class="form sign_up">

      <form method="POST" action="">
        <!-- heading -->
        <h1>Create An Account</h1>

        <span>Register New Account</span>
        <!-- input fields start -->
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
		<input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

		<input type="submit" name="register" value="Register">

     
    
        <!-- <span>Forgot your <span class="forgot">password?</span></span> -->
        
        <!-- input fields end -->
      </form>
    </div>
    <!-- sign in form section end-->

    <!-- overlay section start-->
    <div class="overlay-container">
      <div class="overlay">
		<div class="overlay-pannel overlay-left">
          <h1>Already have an account</h1>
          <p>Please Login</p>
          <a href="login.php" class="overBtn">Sign In</a>
        </div>
      </div>
    </div>
    <!-- overlay section start-->
  </div>
  <script>
	container.classList.add("right-panel-active");
	</script>
</body>

</html>




