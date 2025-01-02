<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    require("config.php");

    function verifyemail($name, $email, $otp) {
        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Disable verbose debug output
            $mail->isSMTP();                                         // Use SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Gmail SMTP server
            $mail->SMTPAuth   = true;                                // Enable SMTP authentication
            $mail->Username   = SMTP_USERNAME;                       // Your Gmail address from config.php
            $mail->Password   = SMTP_PASSWORD;                       // Your app-specific password from config.php
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Use implicit TLS encryption
            $mail->Port       = 465;                                 // SMTP port for TLS encryption

            // Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);         // Sender's email and name from config.php
            $mail->addAddress($email, $name);                        // Add recipient
            $mail->addReplyTo(SMTP_REPLY_TO_EMAIL, SMTP_REPLY_TO_NAME); // Reply-to email and name from config.php

            // Email content
            $mail->isHTML(true);                                     // Set email format to HTML
            $mail->Subject = 'Email Verification';
            $mail->Body    = "Dear $name,<br><br>Your OTP for email verification is: <b>$otp</b><br><br>Thank you!";
            $mail->AltBody = "Dear $name,\n\nYour OTP for email verification is: $otp\n\nThank you!";

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            // Handle error
        }
    }

    $error_empty = false;
    $error_mobile = false;

    if (isset($_POST["fName"])) {
        $fname = trim($_POST["fName"]);
        $lname = trim($_POST["lName"]);
        $adr = trim($_POST["adr"]);
        $mobile = trim($_POST["mobile"]);
        $email = trim($_POST["email"]);
        $gender = isset($_POST["gender"]) ? trim($_POST["gender"]) : ''; // Get value from radio button
        $dob = trim($_POST["dob"]);
        $province = trim($_POST["province"]);
        $district = trim($_POST["pollingDivision"]);
        $pollingDivisionDetails = trim($_POST["pollingDivisionDetails"]);
        $NIC = trim($_POST["nic"]);
        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        if (empty($fname) || empty($lname) || empty($adr) || empty($mobile) || empty($email) || empty($gender) || empty($dob) || empty($province) || empty($district) || empty($pollingDivisionDetails) || empty($NIC)) {
            echo 'All fields are required!';
            $error_empty = true;
            exit;
        }
        if (!is_numeric($mobile) || strlen($mobile) !== 10) {
            echo 'Mobile number must be numeric and 10 digits!';
            $error_mobile = true;
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email format!';
            exit;
        }
        if (!preg_match('/^[0-9]{9}[VvXx]$/', $NIC)) {
            echo 'Invalid NIC format! Must be 9 digits followed by V, v, X, or x.';
            exit;
        }
        $duplicate = mysqli_query($conn, "SELECT * FROM user WHERE Nic='$NIC'");

        if (mysqli_num_rows($duplicate) == 0) {
            $query = "INSERT INTO user(f_name, l_name, Nic, mobile, email, gender, dob, province, district, polling_div, address, otp)
                      VALUES('$fname', '$lname', '$NIC', '$mobile', '$email', '$gender', '$dob', '$province', '$district', '$pollingDivisionDetails', '$adr', '$otp')";
            $result = mysqli_query($conn, $query);
            $name = $fname . ' ' . $lname;
            if ($result) {
                verifyemail($name, $email, $otp);
                echo "Register Successful";
            }
        } else {
            echo "This Record Already Exists!";
        }
    }
    else{
        // Default response if accessed without POST data
        echo 'Invalid request.';
    }
    
    exit;
?>
