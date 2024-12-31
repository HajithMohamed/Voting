<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    require("config.php");


    function verifyemail(){
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'user@example.com';                     //SMTP username
            $mail->Password   = 'secret';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

    $query = "INSERT INTO user(f_name, l_name, Nic, mobile, email, gender, dob, province, district, polling_div, address)
              VALUES('$fname', '$lname', '$NIC', '$mobile', '$email', '$gender', '$dob', '$province', '$district', '$pollingDivisionDetails', '$adr')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo 'Register Successful';
        exit;
    }
}

// Default response if accessed without POST data
echo 'Invalid request.';
exit;
?>
