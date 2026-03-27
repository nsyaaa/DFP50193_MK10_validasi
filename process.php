<?php
session_start();

// Guard clause using short-circuiting instead of 'if'
(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] === "POST") or die(header("Location: application.php"));

// Pastikan semua kunci wujud dan bersihkan input
$fields = ['fullName', 'studentID', 'email', 'loanDuration', 'loanStartDate', 'deviceType', 'webcam', 'terms', 'reason'];
$data = array_merge(array_fill_keys($fields, ''), array_map('trim', $_POST));

// Pemetaan Label untuk mesej ralat yang spesifik
$labels = [
    'fullName'      => 'Nama Penuh',
    'studentID'     => 'ID Pelajar',
    'email'         => 'Alamat Emel',
    'loanDuration'  => 'Tempoh Pinjaman',
    'loanStartDate' => 'Tarikh Mula Pinjaman',
    'deviceType'    => 'Jenis Peranti',
    'webcam'        => 'Keperluan Webcam',
    'terms'         => 'Persetujuan Terma',
    'reason'        => 'Sebab Permohonan'
];

// 1. Sahkan butiran yang kosong (Hanya semak field yang kita mahu)
$missingFields = array_filter($fields, fn($f) => empty($data[$f]));
$requiredErrors = array_map(
    fn($k) => "Butiran '{$labels[$k]}' wajib diisi dan tidak boleh dibiarkan kosong.",
    $missingFields
);

// 2. Sahkan format (Hanya jika input tidak kosong)
$formatRules = [
    'email'  => [empty($data['email']) || filter_var($data['email'], FILTER_VALIDATE_EMAIL), "Format '{$labels['email']}' tidak sah."],
    'reason' => [empty($data['reason']) || strlen($data['reason']) >= 25, "Butiran '{$labels['reason']}' mestilah sekurang-kurangnya 25 aksara."]
];
$formatErrors = array_values(array_map(fn($r) => $r[1], array_filter($formatRules, fn($r) => !$r[0])));

$errors = array_merge($requiredErrors, $formatErrors);

// Prepare sessions
$_SESSION['errors'] = $errors;
$_SESSION['old_input'] = $data;

// If errors exist, target application, otherwise success
$is_valid = empty($errors);
$_SESSION['application_details'] = $is_valid ? $data : null;

$target = $is_valid ? "success.php" : "application.php";
header("Location: $target");
exit();