<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container text-center">
        <h1 class="text-success">Success!</h1>
        <?php 
        $details = $_SESSION['application_details'] ?? [];
        $name = $details['fullName'] ?? 'Applicant';
        ?>
        <p>Thank you, <strong><?php echo htmlspecialchars($name); ?></strong>.</p>
        <p>Your application has been submitted successfully.</p>

        <?php echo !empty($details) ? '
            <div class="summary-box">
                <h3 class="mt-0">Application Summary:</h3>
                <div class="summary-item"><span class="summary-label">Student ID:</span> ' . htmlspecialchars($details['studentID']) . '</div>
                <div class="summary-item"><span class="summary-label">Email:</span> ' . htmlspecialchars($details['email']) . '</div>
                <div class="summary-item"><span class="summary-label">Loan Duration:</span> ' . htmlspecialchars($details['loanDuration']) . ' months</div>
                <div class="summary-item"><span class="summary-label">Start Date:</span> ' . htmlspecialchars($details['loanStartDate']) . '</div>
                <div class="summary-item"><span class="summary-label">Device Type:</span> ' . htmlspecialchars($details['deviceType']) . '</div>
                <div class="summary-item"><span class="summary-label">Webcam Needed:</span> ' . htmlspecialchars($details['webcam']) . '</div>
                <div class="summary-item"><span class="summary-label">Reason:</span><br>' . nl2br(htmlspecialchars($details['reason'])) . '</div>
            </div>' : ''; 
        
        unset($_SESSION['application_details']);
        ?>
        <br>
        <a href="application.php" class="btn btn-submit btn-inline">Back to Form</a>
    </div>
</body>
</html>