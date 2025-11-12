<?php
header("Content-Type: application/json");
include 'db.php';

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$status = $_POST['status'] ?? 'enabled';

if ($title == '') {
  echo json_encode(["success" => false, "message" => "Title is required."]);
  exit;
}

// Directories
$pdfDir = "../uploads/pdfs/";
$thumbDir = "../uploads/thumbs/";
if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);
if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);

// --- PDF Upload ---
if (!isset($_FILES['file'])) {
  echo json_encode(["success" => false, "message" => "PDF file is required."]);
  exit;
}

$pdfName = time() . "_" . basename($_FILES["file"]["name"]);
$pdfPath = $pdfDir . $pdfName;
$pdfType = strtolower(pathinfo($pdfPath, PATHINFO_EXTENSION));

if ($pdfType != "pdf") {
  echo json_encode(["success" => false, "message" => "Only PDF files allowed."]);
  exit;
}
move_uploaded_file($_FILES["file"]["tmp_name"], $pdfPath);

// --- Thumbnail Upload (optional) ---
$thumbName = null;
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['size'] > 0) {
  $thumbExt = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
  if (in_array($thumbExt, ['jpg', 'jpeg', 'png', 'gif'])) {
    $thumbName = "thumb_" . time() . "." . $thumbExt;
    move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbDir . $thumbName);
  }
}

$stmt = $conn->prepare("INSERT INTO pdf_files (title, description, file_name, thumbnail, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $description, $pdfName, $thumbName, $status);
$stmt->execute();

echo json_encode(["success" => true, "message" => "PDF uploaded successfully."]);
?>
