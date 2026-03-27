<?php
session_start();

// Ambil ralat dan data lama dari session jika ada
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old_input'] ?? [];

// Set nilai pembolehubah berdasarkan data lama atau kosong
$fullName = $old['fullName'] ?? '';
$studentID = $old['studentID'] ?? '';
$email = $old['email'] ?? '';
$loanDuration = $old['loanDuration'] ?? '';
$loanStartDate = $old['loanStartDate'] ?? ''; // Format: YYYY-MM-DD
$deviceType = $old['deviceType'] ?? '';
$webcam = $old['webcam'] ?? '';
$terms = $old['terms'] ?? '';
$reason = $old['reason'] ?? '';

// Padamkan ralat dan data lama dari session supaya tidak muncul pada 'fresh load'
unset($_SESSION['errors']);
unset($_SESSION['old_input']);
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

        <!-- Display errors using ternary and implode -->
        <?php echo !empty($errors) ? 
            '<div class="error-message"><h2>Please correct the following:</h2><ul><li>' . 
            implode('</li><li>', array_map('htmlspecialchars', $errors)) . 
            '</li></ul></div>' : ''; 
        ?>

        <form action="process.php" method="post" class="application-form">
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
                <input type="text" name="loanStartDate" id="loanStartDate" class="form-control" value="<?php echo htmlspecialchars($loanStartDate); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Preferred Device:</label>
                <select name="deviceType" class="form-control">
                    <option value="">--Select--</option>
                    <option value="Laptop" <?php echo ($deviceType == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                    <option value="Tablet" <?php echo ($deviceType == 'Tablet') ? 'selected' : ''; ?>>Tablet</option>
                </select>
            </div>

            <div class="form-group">
                <p class="form-label">Need a webcam?</p>
                <input type="radio" name="webcam" class="form-radio" value="Yes" <?php echo ($webcam == 'Yes') ? 'checked' : ''; ?>> Yes
                <input type="radio" name="webcam" class="form-radio" value="No" <?php echo ($webcam == 'No') ? 'checked' : ''; ?>> No
            </div>

            <div class="form-group">
                <input type="checkbox" name="terms" class="form-check" id="terms" value="agreed" <?php echo ($terms === 'agreed') ? 'checked' : ''; ?>>
                <label>I agree to the terms and conditions</label>
            </div>

            <div class="form-group">
                <label class="form-label">Reason (min. 25 chars):</label>
                <textarea name="reason" rows="4" class="form-control" placeholder="Explain why you need this equipment..."><?php echo htmlspecialchars($reason); ?></textarea>
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
            <?php echo !empty($loanStartDate) ? 
                "defaultDate: '" . htmlspecialchars($loanStartDate) . "'," : ""; ?>
        });
    });
</script>
</html>