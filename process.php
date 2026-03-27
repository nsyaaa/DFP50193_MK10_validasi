<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Application Status</h1>
        </header>
        <?php
        $errors = [];

        // Assigning form inputs to variables
        $fullName = $_POST['fullName'] ?? '';
        $studentID = $_POST['studentID'] ?? '';
        $email = $_POST['email'] ?? '';
        $loanDuration = $_POST['loanDuration'] ?? '';
        $loanStartDate = $_POST['loanStartDate'] ?? '';
        $deviceType = $_POST['deviceType'] ?? '';
        $webcam = $_POST['webcam'] ?? '';
        $terms = $_POST['terms'] ?? '';
        $reason = $_POST['reason'] ?? '';

        // Validation for blank inputs
        if (empty($fullName)) {
            $errors[] = "Full Name is required.";
        }
        if (empty($studentID)) {
            $errors[] = "Student ID is required.";
        }
        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (empty($loanDuration)) {
            $errors[] = "Loan Duration is required.";
        }
        if (empty($loanStartDate)) {
            $errors[] = "Loan Start Date is required.";
        }
        if (empty($deviceType)) {
            $errors[] = "Please select a Device Type.";
        }
        if (empty($webcam)) {
            $errors[] = "Please select if you need a webcam.";
        }
        if (empty($terms)) {
            $errors[] = "You must agree to the terms and conditions.";
        }
        if (empty($reason)) {
            $errors[] = "Reason for Application is required.";
        } elseif (strlen($reason) < 25) {
            // Validation for the length of the reason
            $errors[] = "The reason for application must be at least 25 characters long.";
        }

        // Display errors or success message
        if (!empty($errors)) {
            echo '<div class="error-message">';
            echo '<h2>Please correct the following errors:</h2>';
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<div class="summary-box summary-success">';
            echo '<h2>Application Submitted Successfully!</h2>';
            echo '<p>Thank you, ' . htmlspecialchars($fullName) . '. Your application has been received and is under review.</p>';
            echo '</div>';
        }
        ?>
        <a href="application.php" class="back-link">Back to Application Form</a>
    </div>