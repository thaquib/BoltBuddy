<?php

$db_file = __DIR__ . '/../data/mydb.sqlite';
if (file_exists($db_file)) {
    $db = new SQLite3($db_file);
}

// upload-form.php
// var_dump($_SERVER['REQUEST_METHOD']);
// var_dump($_FILES);

// --- CONFIG ---
$uploadDir = __DIR__ . '/../images/'; // Make sure this folder exists and is writable
$allowedTypes = [
    'image/jpeg',
    'image/jpg',
    'image/png',
];
$maxSize = 5 * 1024 * 1024; // 5MB

if (!is_dir($uploadDir)) {
    echo "Error: Upload directory does not exist.";
    exit;
}

// Initialize messages
$success = [];
$errors = [];

// --- HANDLE FORM File SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {






    if (isset($_FILES['files'])) {
        echo 'Uploading files...<br>';
        foreach ($_FILES['files']['tmp_name'] as $i => $tmp) {
            if ($_FILES['files']['error'][$i] !== UPLOAD_ERR_OK) {
                $errors[] = $_FILES['files']['name'][$i] . ' failed to upload.';
                continue;
            }

            $type = mime_content_type($tmp);
            if (!in_array($type, $allowedTypes)) {
                $errors[] = $_FILES['files']['name'][$i] . ' has invalid file type.';
                continue;
            }

            if ($_FILES['files']['size'][$i] > $maxSize) {
                $errors[] = $_FILES['files']['name'][$i] . ' exceeds maximum size.';
                continue;
            }

            $stmt = $db->prepare("INSERT INTO Listing (Seller_ID, Price, Brand, Model, Model_Year, Color, Battery_Range, Charging_Type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $_POST['seller'] ?? '', SQLITE3_FLOAT);
            $stmt->bindValue(2, $_POST['price'] ?? '', SQLITE3_FLOAT);
            $stmt->bindValue(3, $_POST['brand'] ?? '', SQLITE3_TEXT);
            $stmt->bindValue(4, $_POST['model'] ?? '', SQLITE3_TEXT);
            $stmt->bindValue(5, $_POST['model-year'] ?? '', SQLITE3_INTEGER);
            $stmt->bindValue(6, $_POST['color'] ?? '', SQLITE3_INTEGER);
            $stmt->bindValue(7, $_POST['battery-range'] ?? '', SQLITE3_INTEGER);
            $stmt->bindValue(8, $_POST['charging-type'] ?? '', SQLITE3_TEXT);

            $stmt->execute();

            // 2️⃣ Get the auto-incremented Listing_ID
            $newListingID = $db->lastInsertRowID();

            // Safe file name
            $name = basename($_FILES['files']['name'][$i]);
            $target = $uploadDir . date('d-F-Y-') . $name;

            if (move_uploaded_file($tmp, $target)) {
                $success[] = "$name uploaded successfully.";
                // echo $name;

                // Store info in SQLite
                $stmt = $db->prepare("INSERT INTO EV_Image (Listing_ID, Image_URL, is_main_image ) VALUES (?, ?, ?)");
                $stmt->bindValue(1, $newListingID, SQLITE3_INTEGER);
                $stmt->bindValue(2, '/images/' . date('d-F-Y-') . $name, SQLITE3_TEXT);
                $stmt->bindValue(3, '1', SQLITE3_INTEGER);

                $stmt->execute();
            } else {
                $errors[] = "$name failed to move to uploads folder.";
            }
        }
    }
} else {
    echo 'Nothing to upload.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>

<body>
    <h1>Upload Files</h1>

    <!-- Display success/errors -->
    <?php if (!empty($success)): ?>
        <ul style="color:green;">
            <?php foreach ($success as $msg): ?>
                <li><?= htmlspecialchars($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $msg): ?>
                <li><?= htmlspecialchars($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>