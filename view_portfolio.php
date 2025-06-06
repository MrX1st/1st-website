<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if a query parameter is provided
    if (isset($_GET['id'])) {
        // Retrieve the value of the "name" parameter
        $id = $_GET['id'];

        // Output the result
    } else {
        // redirect to welcome
        header('Location: welcome.php');
        exit();
    }
} 
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

// Prepare the SQL query
$query = "SELECT * FROM portfolio WHERE user_id=$id";


$query2 = "SELECT * FROM project WHERE user_id=$id";
$query3 = "SELECT * FROM service WHERE user_id=$id";

// Execute the query
$result = mysqli_query($connection, $query);

$result2 = mysqli_query($connection, $query2);
$result3 = mysqli_query($connection, $query3);

// Check if the query was successful
if (!$result) {
    //die('Query error: ' . mysqli_error($connection));
    header('Location: welcome.php');
    exit();
}
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the row data
        $row = $result->fetch_assoc();

        // Access the data
        $firstname = $row["firstname"];
        $title = $row["title"];
        $description = $row["description"];
        $photo = $row["photo"];

        $phone = $row["phone"];
        $email = $row["email"];
        $age = $row["age"];

        // Output the data
        // echo "Column 1: " . $column1 . "<br>";
        // echo "Column 2: " . $column2 . "<br>";
    } else {
        echo "No matching rows found.";
    }
} else {
    // echo "Error executing query: " . $conn->error;
}


?>
<?php
// Logout the user
if (isset($_GET['logout'])) {
    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('Location: login.php');
    exit();
}
// Check if the user is not logged in
// if (!isset($_SESSION['user_id'])) {
//     echo '<h2>Welcome to the Website</h2>';
//     echo '<p>Please <a href="login.php">Login</a> or <a href="register.php">Register</a> to access the content.</p>';
// } else {
//     // User is logged in
//     $username = $_SESSION['username'];

//     echo '<h2>Welcome, ' . $username . '!</h2>';
//     echo '<p>Thank you for logging in. You can now access the content.</p>';
//     echo '<p><a href="portfolio.php">Edit Portfolio</a></p>';
//     echo '<p><a href="welcome.php?logout">Logout</a></p>';
// }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            .service .service-item .service-item-inner:hover .icon {
            background: white!important;
            }
            .typed-cursor{display:none}
        </style>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- ==== CSS Files ==== -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/skins/color-1.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- ==== Style Switcher ==== -->
        <link rel="stylesheet" href="css/skins/color-1.css" class="alternate-style" title="color-1" disabled>
        <link rel="stylesheet" href="css/skins/color-2.css" class="alternate-style" title="color-2" disabled>
        <link rel="stylesheet" href="css/skins/color-3.css" class="alternate-style" title="color-3" disabled>
        <link rel="stylesheet" href="css/skins/color-4.css" class="alternate-style" title="color-4" disabled>
        <link rel="stylesheet" href="css/skins/color-5.css" class="alternate-style" title="color-5" disabled>
        <link rel="stylesheet" href="css/style-switcher.css">
    </head>
    <body>
        <!-- ==== Main Container Start ==== -->
        <div class="main-container">
            <!-- ==== Aside Start ==== -->
            <div class="aside">
                <div class="logo">
                    
                    <a href="#"><?php echo $firstname;?></a>
                </div>
                <div class="nav-toggler">
                    <span></span>
                </div>
                <ul class="nav">
                    <li><a href="#home" class="active"><i class="fa fa-home"></i>Home</a></li>
                    <li><a href="#about"><i class="fa fa-user"></i> About</a></li>
                    <li><a href="#services"><i class="fa fa-list"></i>Services</a></li>
                    <li><a href="#portfolio"><i class="fa fa-briefcase"></i>Portfolio</a></li>
                    <li><a href="welcome.php"><i class="fa fa-arrow-left"></i>Go Back</a></li>
                    <!-- <li><a href="#contact"><i class="fa fa-comments"></i>Contact</a></li> -->
                </ul>
            </div>
            <!-- ==== Aside End ==== -->
            <!-- ==== Main Content Start ==== -->
            <div class="main-content">
                <!-- ==== Home Section Start ==== -->
                <section class="home active section" id="home">
                    <div class="container">
                        <div class="row">
                            <div class="home-info padd-15">
                                <h3 class="hello">Hello, my name is <span class="name"><?php echo $firstname;?></span></h3>
                                <h3 class="my-profession hello">I'm a <span class="typing"style="display:none;"><?php echo $title;?></span><span class="name"><?php echo $title;?></span></h3>
                                <p><?php echo $description;?></p>
                                <a href="#" class="btn">Download CV</a>
                            </div>
                            <div class="home-img padd-15">
                                <img src="images/<?php echo $photo;?>" alt="">
                            </div>
                        </div>
                    </div>
                </section>
                <!-- ==== Home Section End ==== -->
                <!-- ==== About Section Start ==== -->
                <section class="about section" id="about">
                    <div class="container">
                        <div class="row">
                            <div class="section-title padd-15">
                                <h2>About Me</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="about-content padd-15">
                                <div class="row">
                                    <div class="about-text padd-15">
                                        <h3>I'm <?php echo $firstname;?> and I'm a <span><?php echo $title;?></span></h3>
                                        <p><?php echo $description; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="personal-info padd-15">
                                        <div class="row">
                                            <div class="info-item padd-15">
                                                <p>Birthday : <span>17 sep 1999</span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>Age : <span><?php echo $age; ?></span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>Website : <span>www.domain.com</span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>Email : <span><?php echo $email; ?></span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>Degree : <span>CS</span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>Phone : <span><?php echo $phone; ?></span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>City : <span>Yekaterin</span></p>
                                            </div>
                                            <div class="info-item padd-15">
                                                <p>Freelance : <span>Available</span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="buttons">
                                                <a href="#contact" data-section-index="1" class="btn hire-me"> Hire Me</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="skills padd-15">
                                        <div class="row">
                                            <div class="skill-item padd-15">
                                                <h5>JS</h5>
                                                <div class="progress">
                                                    <div class="progress-in" style="width: 86%;"></div>
                                                    <div class="skill-percent">86%</div>
                                                </div>
                                            </div>
                                            <div class="skill-item padd-15">
                                                <h5>PHP</h5>
                                                <div class="progress">
                                                    <div class="progress-in" style="width: 66%;"></div>
                                                    <div class="skill-percent">66%</div>
                                                </div>
                                            </div>
                                            <div class="skill-item padd-15">
                                                <h5>HTML</h5>
                                                <div class="progress">
                                                    <div class="progress-in" style="width: 96%;"></div>
                                                    <div class="skill-percent">96%</div>
                                                </div>
                                            </div>
                                            <div class="skill-item padd-15">
                                                <h5>Bootstrap</h5>
                                                <div class="progress">
                                                    <div class="progress-in" style="width: 76%;"></div>
                                                    <div class="skill-percent">76%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="education padd-15">
                                        <h3 class="title">Education</h3>
                                        <div class="row">
                                            <div class="timeline-box padd-15">
                                                <div class="timeline shadow-dark">
                                                    <!-- ==== timeline item ==== -->
                                                    <div class="timeline-item">
                                                        <div class="circle-dot"></div>
                                                        <h3 class="timeline-date">
                                                            <i class="fa fa-calendar"></i> 2013 - 2015
                                                        </h3>
                                                        <h4 class="timeline-title">Master in computer science</h4>
                                                        <p class="timeline-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, delectus vitae eos facilis fugiat impedit quaerat quasi quam ipsa, possimus explicabo vel, cumque porro amet perferendis quia ut non mollitia!</p>
                                                    </div>
                                                    <!-- ==== timeline item ==== -->
                                                    <div class="timeline-item">
                                                        <div class="circle-dot"></div>
                                                        <h3 class="timeline-date">
                                                            <i class="fa fa-calendar"></i> 2013 - 2015
                                                        </h3>
                                                        <h4 class="timeline-title">Master in computer science</h4>
                                                        <p class="timeline-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, delectus vitae eos facilis fugiat impedit quaerat quasi quam ipsa, possimus explicabo vel, cumque porro amet perferendis quia ut non mollitia!</p>
                                                    </div>
                                                    <!-- ==== timeline item ==== -->
                                                    <div class="timeline-item">
                                                        <div class="circle-dot"></div>
                                                        <h3 class="timeline-date">
                                                            <i class="fa fa-calendar"></i> 2013 - 2015
                                                        </h3>
                                                        <h4 class="timeline-title">Master in computer science</h4>
                                                        <p class="timeline-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, delectus vitae eos facilis fugiat impedit quaerat quasi quam ipsa, possimus explicabo vel, cumque porro amet perferendis quia ut non mollitia!</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="experience padd-15">
                                        <h3 class="title">Experience</h3>
                                        <div class="row">
                                            <div class="timeline-box padd-15">
                                                <div class="timeline shadow-dark">
                                                    <!-- ==== timeline item ==== -->
                                                    <div class="timeline-item">
                                                        <div class="circle-dot"></div>
                                                        <h3 class="timeline-date">
                                                            <i class="fa fa-calendar"></i> 2013 - 2015
                                                        </h3>
                                                        <h4 class="timeline-title">Master in computer science</h4>
                                                        <p class="timeline-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, delectus vitae eos facilis fugiat impedit quaerat quasi quam ipsa, possimus explicabo vel, cumque porro amet perferendis quia ut non mollitia!</p>
                                                    </div>
                                                    <!-- ==== timeline item ==== -->
                                                    <div class="timeline-item">
                                                        <div class="circle-dot"></div>
                                                        <h3 class="timeline-date">
                                                            <i class="fa fa-calendar"></i> 2013 - 2015
                                                        </h3>
                                                        <h4 class="timeline-title">Master in computer science</h4>
                                                        <p class="timeline-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, delectus vitae eos facilis fugiat impedit quaerat quasi quam ipsa, possimus explicabo vel, cumque porro amet perferendis quia ut non mollitia!</p>
                                                    </div>
                                                    <!-- ==== timeline item ==== -->
                                                    <div class="timeline-item">
                                                        <div class="circle-dot"></div>
                                                        <h3 class="timeline-date">
                                                            <i class="fa fa-calendar"></i> 2013 - 2015
                                                        </h3>
                                                        <h4 class="timeline-title">Master in computer science</h4>
                                                        <p class="timeline-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, delectus vitae eos facilis fugiat impedit quaerat quasi quam ipsa, possimus explicabo vel, cumque porro amet perferendis quia ut non mollitia!</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- ==== About Section End ==== -->
                <!-- ==== Services Section Start ==== -->
                <section class="service section" id="services">
                    <div class="container">
                        <div class="row">
                            <div class="section-title padd-15">
                                <h2>Services</h2>
                            </div>
                        </div>
                        <div class="row">

                        <?php
                        // Fetch rows one by one
                        while ($row = mysqli_fetch_assoc($result3)) {
                            // Process each row here
                            // Access column values using the associative array syntax
                            // $id = $row['id'];
                            // $user_id = $row['user_id'];
                            $photo = $row['photo'];
                            $title = $row['title'];
                            $content = $row['content'];

                            // Perform any desired operations with the row data
                            //echo "Column 1: $column1Value, Column 2: $column2Value <br>";
                        ?>
                            <!-- ==== Service item Start ==== -->
                            <div class="service-item padd-15">
                                <div class="service-item-inner">
                                    <div class="icon">
                                    <img style="max-width: 60px;" src="images/service/<?php echo $photo;?>" alt="">
                                    </div>
                                    <h4><?php echo $title; ?></h4>
                                    <p><?php echo $content; ?></p>
                                </div>
                            </div>
                            <!-- ==== Service item End ==== -->

                            <?php

                            }
                            ?>


                            
                           
                        </div>
                    </div>
                </section>
                <!-- ==== Services Section End ==== -->
                <!-- ==== Portfolio Section Start ==== -->
                <section class="portfolio section" id="portfolio">
                    <div class="container">
                        <div class="row">
                            <div class="section-title padd-15">
                                <h2>Portfolio</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="portfolio-heading padd-15">
                                <h2>My Latest Projects :</h2>
                            </div>
                        </div>
                        <div class="row">
                        <?php
// Fetch rows one by one
while ($row = mysqli_fetch_assoc($result2)) {
    // Process each row here
    // Access column values using the associative array syntax
    $id = $row['id'];
    $title = $row['title'];
    $photo = $row['photo'];
    $link = $row['link'];

    // Perform any desired operations with the row data
    //echo "Column 1: $column1Value, Column 2: $column2Value <br>";
?>
<!-- ==== portfolio item Start ==== -->
<a target="_blank" href="<?php echo $link; ?>" class="portfolio-item padd-15">
                                <div class="portfolio-item-inner shadow-dark">
                                    <div class="portfolio-img">
                                        <img src="images/portfolio/<?php echo $photo; ?>" alt="">
                                        
                                    </div>
                                    <div class="portfolio-heading padd-15" style="margin: 0;
text-align: center;">
                                <h2><?php echo $title; ?></h2>
                            </div>
                                </div>
</a>
                            <!-- ==== portfolio item End ==== -->

<?php

}
?>
                            <!-- ==== portfolio item End ==== -->
                        </div>
                    </div>
                </section>
                <!-- ==== Portfolio Section End ==== -->
                <!-- ==== Contact Section Start ==== -->
                <section class="contact section" id="contact">
                    <div class="container">
                        <div class="row">
                            <div class="section-title padd-15">
                                <h2>Contact Me</h2>
                            </div>
                        </div>
                        <h3 class="contact-title padd-15">Have You Any Questions ?</h3>
                        <h4 class="contact-sub-title padd-15">I'M AT YOUR SERVICES</h4>
                        <div class="row">
                            <!-- ==== Contact info item start ==== -->
                            <div class="contact-info-item padd-15">
                                <div class="icon"><i class="fa fa-phone"></i></div>
                                <h4>Call Us On</h4>
                                <p>+7982*******</p>
                            </div>
                            <!-- ==== Contact info item end ==== -->
                            <!-- ==== Contact info item start ==== -->
                            <div class="contact-info-item padd-15">
                                <div class="icon"><i class="fa fa-map-marker-alt"></i></div>
                                <h4>Office</h4>
                                <p>NAME</p>
                            </div>
                            <!-- ==== Contact info item end ==== -->
                            <!-- ==== Contact info item start ==== -->
                            <div class="contact-info-item padd-15">
                                <div class="icon"><i class="fa fa-envelope"></i></div>
                                <h4>Email</h4>
                                <p>info@gmail.com</p>
                            </div>
                            <!-- ==== Contact info item end ==== -->
                            <!-- ==== Contact info item start ==== -->
                            <div class="contact-info-item padd-15">
                                <div class="icon"><i class="fa fa-globe-europe"></i></div>
                                <h4>Website</h4>
                                <p>www.domain.com</p>
                            </div>
                            <!-- ==== Contact info item end ==== -->
                        </div>
                        <h3 class="contact-title padd-15">SEND ME AN EMAIL</h3>
                        <h4 class="contact-sub-title padd-15">I'M VERY RESPONSIVE TO MESSAGES</h4>
                        <!-- ==== Contact Form ==== -->
                        <div class="row">
                            <div class="contact-form padd-15">
                                <div class="row">
                                    <div class="form-item col-6 padd-15">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-item col-6 padd-15">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-item col-12 padd-15">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Subject">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-item col-12 padd-15">
                                        <div class="form-group">
                                            <textarea name="" class="form-control" id="" placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-item col-12 padd-15">
                                        <button type="submit" class="btn">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- ==== Contact Section End ==== -->
            </div>
            <!-- ==== Main Content End ==== -->
        </div>
        <!-- ==== Main Container End ==== -->
        <!-- ==== Style Switcher Start ==== -->
        <div class="style-switcher">
        <div class="login-reg s-icon s-icon2 tooltip">        
            <?php
            if (!isset($_SESSION['user_id'])) {
                //echo '<h2>Welcome to the Website</h2>';
                echo '<a href="login.php" class="log fas fa-sign-in-alt"></a> <span class="tooltiptext">Log In</span></div><div class="login-reg s-icon tooltip"><a href="register.php" class="reg fas fa-user-plus"></a><span class="tooltiptext">Register</span>';
            } else {
                // User is logged in
                $username = $_SESSION['username'];
            
                //echo '<h2>Welcome, ' . $username . '!</h2>';
                //echo '<p>Thank you for logging in. You can now access the content.</p>';
                echo '<a href="portfolio.php" class="log fas fa-pen"></a><span class="tooltiptext">Edit</span></div><div class="login-reg s-icon tooltip">';
                echo '<a href="welcome.php?logout" class="reg fas fa-sign-out-alt"></a><span class="tooltiptext">Log Out</span>';
            }
            // Close the database connection $conn->close();
            $connection->close();


            ?>
            </div>
            <div class="style-switcher-toggler s-icon">
                <i class="fas fa-cog fa-spin"></i>
            </div>
            <div class="day-night s-icon">
                <i class="fas fa-moon"></i>
            </div>
            <h4>Theme Colors</h4>
            <div class="colors">
                <span class="color-1" onclick="setActiveStyle('color-1')"></span>
                <span class="color-2" onclick="setActiveStyle('color-2')"></span>
                <span class="color-3" onclick="setActiveStyle('color-3')"></span>
                <span class="color-4" onclick="setActiveStyle('color-4')"></span>
                <span class="color-5" onclick="setActiveStyle('color-5')"></span>
            </div>
        </div>
        <!-- ==== Style Switcher End ==== -->
        <!-- ==== JS Files ==== -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.16/typed.umd.js" integrity="sha512-+2pW8xXU/rNr7VS+H62aqapfRpqFwnSQh9ap6THjsm41AxgA0MhFRtfrABS+Lx2KHJn82UOrnBKhjZOXpom2LQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="js/script.js"></script>
        <script src="js/style-switcher.js"></script>
    </body>
</html>