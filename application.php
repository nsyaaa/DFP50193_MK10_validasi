<?php
session_start();
$errors = [];
$fullName = $studentID = $email = $loanDuration = $loanStartDate = $deviceType = $webcam = $terms = $reason = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['fullName'] ?? '');
    $studentID = trim($_POST['studentID'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $loanDuration = trim($_POST['loanDuration'] ?? '');
    $loanStartDate = trim($_POST['loanStartDate'] ?? '');
    $deviceType = $_POST['deviceType'] ?? '';
    $webcam = $_POST['webcam'] ?? '';
    $terms = $_POST['terms'] ?? '';
    $reason = trim($_POST['reason'] ?? '');

    // Validation Logic

    if (empty($fullName)) $errors[] = "Full Name is required.";
    if (empty($studentID)) $errors[] = "Student ID is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($loanDuration)) $errors[] = "Loan Duration is required.";
    if (empty($loanStartDate)) $errors[] = "Loan Start Date is required.";
    if (empty($deviceType)) $errors[] = "Please select a Device Type.";
    if (empty($webcam)) $errors[] = "Please select if you need a webcam.";
      if (empty($terms)) {
            $errors[] = "You must agree to the terms.";
        }
    
    if (empty($reason)) {
        $errors[] = "Reason for Application is required.";
    } elseif (strlen($reason) < 25) {
        $errors[] = "The reason must be at least 25 characters long.";
    }

    if (empty($errors)) {
        $_SESSION['application_details'] = [
            'fullName' => $fullName,
            'studentID' => $studentID,
            'email' => $email,
            'loanDuration' => $loanDuration,
            'loanStartDate' => $loanStartDate,
            'deviceType' => $deviceType,
            'webcam' => $webcam,
            'reason' => $reason
        ];
         header("Location: success.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laptop Loan Application</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Laptop Loan Scheme Application</h1>
        </header>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <h2>Please correct the following:</h2>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="application.php" method="post" class="application-form">
            <div class="form-group">
                <label class="form-label">Full Name:</label>
                <input type="text" name="fullName" class="form-control" value="<?php echo htmlspecialchars($fullName); ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Student ID:</label>
                <input type="text" name="studentID" class="form-control" value="<?php echo htmlspecialchars($studentID); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Email:</label>
                <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Loan Duration (months):</label>
                <input type="number" name="loanDuration" class="form-control" value="<?php echo htmlspecialchars($loanDuration); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Loan Start Date:</label>
                <?php
                $displayLoanStartDate = '';
                if (!empty($loanStartDate)) {
                    // The input's value should be YYYY-MM-DD for Flatpickr's internal handling
                    // and for server-side processing. Flatpickr will display DD/MM/YYYY to the user.
                    $displayLoanStartDate = $loanStartDate;
                } ?>
                <input type="text" name="loanStartDate" id="loanStartDate" class="form-control" value="<?php echo htmlspecialchars($displayLoanStartDate); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Preferred Device:</label>
                <select name="deviceType" class="form-control">
                    <option value="">--Select--</option>
                    <option value="Laptop" <?php if($deviceType=='Laptop') echo 'selected'; ?>>Laptop</option>
                    <option value="Tablet" <?php if($deviceType=='Tablet') echo 'selected'; ?>>Tablet</option>
                </select>
            </div>

            <div class="form-group">
                <p class="form-label">Need a webcam?</p>
                <input type="radio" name="webcam" class="form-radio" value="Yes" <?php if($webcam=='Yes') echo 'checked'; ?>> Yes
                <input type="radio" name="webcam" class="form-radio" value="No" <?php if($webcam=='No') echo 'checked'; ?>> No
            </div>

            <div class="form-group">
                <input type="checkbox" name="terms" class="form-check" id="terms" value="agreed" <?php if($terms=='agreed') echo 'checked'; ?>>
                <label>I agree to the terms and conditions</label>
            </div>

            <div class="form-group">
                <label class="form-label">Reason (min. 25 chars):</label>
                <textarea name="reason" rows="4" class="form-control"><?php echo htmlspecialchars($reason); ?></textarea>
            </div>

            <div class="form-buttons">
                <button type="submit" name="submit" class="btn btn-submit">Submit Application</button>
                <a href="application.php" class="btn btn-reset btn-no-decor">Reset Form</a>
            </div>
        </form>
    </div>
</body>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#loanStartDate", {
            dateFormat: "Y-m-d", // The format for the actual input value (sent to server)
            altInput: true,      // Enable an alternate input for display
            altFormat: "d/m/Y",  // The format for the displayed input (user sees this)
            // Optional: Set default date if $loanStartDate is present from PHP
            <?php if (!empty($loanStartDate)): ?>
            defaultDate: "<?php echo htmlspecialchars($loanStartDate); ?>",
            <?php endif; ?>
        });
    });
</script>
</html>