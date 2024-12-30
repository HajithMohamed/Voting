<?php
require("config.php");

$error_empty = false;
$error_mobile = false;

if (isset($_POST["fName"])) {
    $fname = trim($_POST["fName"]);
    $lname = trim($_POST["lName"]);
    $adr = trim($_POST["adr"]);
    $mobile = trim($_POST["mobile"]);
    $dob = trim($_POST["dob"]);
    $district = trim($_POST["pollingDivision"]);
    $NIC = trim($_POST["nic"]);

    if (empty($fname) || empty($lname) || empty($adr) || empty($mobile) || empty($dob) || empty($district) || empty($NIC)) {
        echo 'All fields are required!';
        $error_empty = true;
        exit;
    }
    if (!is_numeric($mobile) || strlen($mobile) !== 10) {
        echo 'Mobile number must be numeric and 10 digits!';
        $error_mobile = true;
        exit;
    }
    if (!preg_match('/^[0-9]{9}[VvXx]$/', $NIC)) {
        echo 'Invalid NIC format! Must be 9 digits followed by V, v, X, or x.';
        exit;
    }
    $query="INSERT INTO user(f_name,l_name,Nic,mobile,district,address)
    VALUES('$fname','$lname','$NIC','$mobile','$district','$adr')";
    $result=mysqli_query($conn,$query);
    if($result){
        // $row=mysqli_fetch_assoc($result);
        // $username=$fname . $lname;
        // $sql3 = mysqli_query($conn, "SELECT * FROM user_table WHERE email='{$email}'");
        // if (mysqli_num_rows($sql3) > 0) {
        //     $row = mysqli_fetch_assoc($sql3);
        //     $_SESSION['user_id'] = $row['user_id'];
        //     $_SESSION['email'] = $row['email'];
        //     $_SESSION['otp'] = $row['user_otp'];

        //     $receiver = $email;
        //     $subject = "Welcome, $username!";
        //     $body = "Name: $username\nEmail: $email\nOTP: $otp";
        //     $sender = "From: hanoufaatif@gmail.com";
        //     if (mail($receiver, $subject, $body, $sender)) {
        //         echo "Success";
        //     } else {
        //         echo "Email sending failed!";
        //     }
        // }
        // }
    
                            
    echo 'Register Successful ';
    exit;
    }
}

// Default response if accessed without POST data
echo 'Invalid request.';
exit;
?>
