<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .summary-box {
            text-align: left;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .summary-item { margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .summary-label { font-weight: bold; color: #555; width: 150px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container" style="text-align: center;">
        <h1 style="color: #28a745;">Success!</h1>
        <?php 
        $details = $_SESSION['application_details'] ?? [];
        $name = $details['fullName'] ?? 'Applicant';
        ?>
        <p>Thank you, <strong><?php echo htmlspecialchars($name); ?></strong>.</p>
        <p>Your application has been submitted successfully.</p>

        <?php if (!empty($details)): ?>
            <div class="summary-box">
                <h3 style="margin-top: 0;">Application Summary:</h3>
                <div class="summary-item"><span class="summary-label">Student ID:</span> <?php echo htmlspecialchars($details['studentID']); ?></div>
                <div class="summary-item"><span class="summary-label">Email:</span> <?php echo htmlspecialchars($details['email']); ?></div>
                <div class="summary-item"><span class="summary-label">Loan Duration:</span> <?php echo htmlspecialchars($details['loanDuration']); ?> months</div>
                <div class="summary-item"><span class="summary-label">Start Date:</span> <?php echo htmlspecialchars($details['loanStartDate']); ?></div>
                <div class="summary-item"><span class="summary-label">Device Type:</span> <?php echo htmlspecialchars($details['deviceType']); ?></div>
                <div class="summary-item"><span class="summary-label">Webcam Needed:</span> <?php echo htmlspecialchars($details['webcam']); ?></div>
                <div class="summary-item"><span class="summary-label">Reason:</span><br><?php echo nl2br(htmlspecialchars($details['reason'])); ?></div>
            </div>
            <?php 
            // Clear the details after displaying so they don't persist indefinitely
            unset($_SESSION['application_details']); 
            ?>
        <?php endif; ?>
        <br>
        <a href="application.php" class="btn btn-submit" style="text-decoration: none; display: inline-block;">Back to Form</a>
    </div>
</body>
</html>