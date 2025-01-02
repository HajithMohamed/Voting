<?php
    $conn = new mysqli("localhost", "root", "", "Voting_System", "3307");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    define('SMTP_USERNAME', 'hanoufaatif@gmail.com');       // Your Gmail address
    define('SMTP_PASSWORD', 'lnpt wnmq equu zaqj');         // Your Gmail app-specific password
    define('SMTP_FROM_EMAIL', 'hanoufaatif@gmail.com');     // Sender's email
    define('SMTP_FROM_NAME', 'ELECTION DEPARTMENT');        // Sender's name
    define('SMTP_REPLY_TO_EMAIL', 'info@example.com');      // Reply-to email
    define('SMTP_REPLY_TO_NAME', 'Information');            // Reply-to name
?>