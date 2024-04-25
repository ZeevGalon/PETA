<?php
    session_start();

    require('config.php');
    require('database.php');

    $success = false;

    $error_message_full_name = '';
    $error_message_email = '';  
    $error_message_phone_number = '';
    $error_message_message = '';
    $error_message_captcha = '';

    if($_POST){
        $full_name = trim($_POST['full_name']);
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $message = $_POST['message'];
        $captcha = $_POST['captcha'];

        $is_error = false;

        if($full_name == ''){
            $error_message_full_name = 'Full name is required.';
            $is_error = true;
        }

        if($email == ''){
            $error_message_email = 'Email is required.';
            $is_error = true;
        }

        if($phone_number == ''){
            $error_message_phone_number = 'Phone number is required.';
        }

        if($message == ''){
            $error_message_message = 'Message is required.';
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
            $sql = "INSERT INTO contacts (
                        full_name, 
                        email, 
                        phone_number, 
                        message
                    )
                    VALUES (
                        '$full_name', 
                        '$email',
                        '$phone_number', 
                        '$message'
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
        <title>Contact Us</title>
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
                            <h1 class="fw-bolder">Get in touch</h1>
                            <p class="lead fw-normal text-muted mb-0">We'd love to hear from you</p>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                            <form id="contactForm" method="POST" action="contact.php">

                                <?php if($success): ?>
                                        <div class="alert alert-success" role="alert">
                                            Contact success! Thank you!
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="full_name" name="full_name" type="text" placeholder="Enter your Full Name..." value="<?php echo isset($_POST['full_name']) ? $_POST['full_name'] : ''; ?>" />
                                        <label for="full_name">Full Name</label>
                                        <div class="invalid-feedback"><?php echo $error_message_full_name; ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email..." value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" />
                                        <label for="email">Email address</label>
                                        <div class="invalid-feedback"><?php echo $error_message_email; ?></div>
                                    </div>

                                     <div class="form-floating mb-3">
                                        <input class="form-control" id="phone_number" name="phone_number" type="tel" placeholder="Enter your phone number..." value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>" />
                                        <label for="phone">Phone number</label>
                                        <div class="invalid-feedback"><?php echo $error_message_phone_number; ?></div>
                                    </div>
                                    
                                    <div class="form-floating mb-3">
                                    <textarea rows="10" style="height:100%;" class="form-control" id="message" name="message" type="text" placeholder="Enter your message..." /><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                                        <label for="contact">Message</label>
                                        <div class="invalid-feedback"><?php echo $error_message_message; ?></div>
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

                                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                                    <!-- Submit Button-->
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
