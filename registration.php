<?php
    session_start();

    require('config.php');
    require('database.php');

    $success = false;

    $error_message_student_id = '';
    $error_message_first_name = '';
    $error_message_last_name = '';
    $error_message_email = '';
    $error_message_address = '';
    $error_message_phone_number = '';
    $error_message_parent_guardian = '';
    $error_message_captcha = '';

    if($_POST){
        $student_id = trim($_POST['student_id']);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone_number = $_POST['phone_number'];
        $parent_guardian = $_POST['parent_guardian'];
        $captcha = $_POST['captcha'];

        $is_error = false;

        if($student_id == ''){
            $error_message_student_id = 'Student ID is required.';
            $is_error = true;
        }

        if($first_name == ''){
            $error_message_first_name = 'First name is required.';
            $is_error = true;
        }

        if($last_name == ''){
            $error_message_last_name = 'Last name is required.';
            $is_error = true;
        }

        if($email == ''){
            $error_message_email = 'Email is required.';
            $is_error = true;
        }

        if($address == ''){
            $error_message_address = 'Address is required.';
            $is_error = true;
        }

        if($phone_number == ''){
            $error_message_phone_number = 'Phone number is required.';
        }

        if($parent_guardian == ''){
            $error_message_parent_guardian = 'Parent/Guardian is required.';
            $is_error = true;
        }

        if($captcha == ''){
            $error_message_captcha = 'Captcha is required.';
            $is_error = true;
        }

        if($_SESSION['captcha'] != $_POST['captcha']){
            $error_message_captcha = 'Invalid captcha!';
            $is_error = true;
        }

        if(!$is_error){
            $sql = "INSERT INTO students (
                        student_id,  
                        first_name, 
                        last_name, 
                        email, 
                        address, 
                        phone_number, 
                        parent_guardian
                    )
                    VALUES (
                        '$student_id', 
                        '$first_name', 
                        '$last_name',
                        '$email',
                        '$address',
                        '$phone_number', 
                        '$parent_guardian'
                    )";

            if ($conn->query($sql) === TRUE) {
                // echo "New record created successfully";
            } else {
                // echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

            $success = true;

            unset($_POST);
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Registration</title>
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="/">Bus Registration</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="announcement.php">Announcement</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="registration.php">Registration</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <section class="py-5">
                <div class="container px-5">
                    <!-- Contact form-->
                    <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                        <div class="text-center mb-5">
                            <h1 class="fw-bolder">Bus Registation</h1>
                            <p class="lead fw-normal text-muted mb-0">Fill up the form for registration</p>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                <form id="contactForm" method="POST" action="registration.php">

                                    <?php if($success): ?>
                                        <div class="alert alert-success" role="alert">
                                            Registration success! Thank you!
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="student_id" name="student_id" type="text" placeholder="Enter your Student ID..." value="<?php echo isset($_POST['student_id']) ? $_POST['student_id'] : ''; ?>" />
                                        <label for="student_id">Student ID</label>
                                        <div class="invalid-feedback"><?php echo $error_message_student_id; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter your first name..." value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>" />
                                                <label for="first_name">First Name</label>
                                                <div class="invalid-feedback"><?php echo $error_message_first_name; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter your last name..." value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>" />
                                                <label for="name">Last name</label>
                                                <div class="invalid-feedback"><?php echo $error_message_last_name; ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email..." value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" />
                                        <label for="email">Email address</label>
                                        <div class="invalid-feedback"><?php echo $error_message_email; ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="address" name="address" type="text" placeholder="Enter your address..." value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" />
                                        <label for="email">Address</label>
                                        <div class="invalid-feedback"><?php echo $error_message_address; ?></div>
                                    </div>
                                   
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="phone_number" name="phone_number" type="tel" placeholder="Enter your phone number..." value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>" />
                                        <label for="phone">Phone number</label>
                                        <div class="invalid-feedback"><?php echo $error_message_phone_number; ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="parent_guardian" name="parent_guardian" type="text" placeholder="Enter your parent/guardian..." value="<?php echo isset($_POST['parent_guardian']) ? $_POST['parent_guardian'] : ''; ?>" />
                                        <label for="email">Parent/Guardian</label>
                                        <div class="invalid-feedback"><?php echo $error_message_parent_guardian; ?></div>
                                    </div>

                                    <div class="form-floating text-center">
                                        <img src="captcha.php" />
                                    </div>

                                    <br>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="captcha" name="captcha" type="text" placeholder="Enter captcha..." />
                                        <label for="email">Enter captcha</label>
                                        <div class="invalid-feedback"><?php echo $error_message_captcha; ?></div>
                                    </div>

                                    <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Busko Bus Crew 2024</div></div>
                    <div class="col-auto">
                        <a class="link-light small" href="privacy.php">Privacy</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="terms.php">Terms</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="contact.php">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
