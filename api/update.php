<?php
header("Content-Type: application/json");
include 'db.php';

$id = $_POST['id'] ?? 0;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$status = $_POST['status'] ?? 'enabled';

if ($id == 0 || $title == '') {
  echo json_encode(["success" => false, "message" => "Invalid input."]);
  exit;
}

// Get current record
$result = $conn->query("SELECT * FROM pdf_files WHERE id=$id");
if ($result->num_rows == 0) {
  echo json_encode(["success" => false, "message" => "File not found."]);
  exit;
}
$old = $result->fetch_assoc();

$pdfDir = "../uploads/pdfs/";
$thumbDir = "../uploads/thumbs/";
if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);
if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);

// Update PDF if new one uploaded
$newPdf = $old['file_name'];
if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
  $newPdf = time() . "_" . basename($_FILES["file"]["name"]);
  move_uploaded_file($_FILES["file"]["tmp_name"], $pdfDir . $newPdf);
  if (file_exists($pdfDir . $old['file_name'])) unlink($pdfDir . $old['file_name']);
}

// Update thumbnail if new one uploaded
$newThumb = $old['thumbnail'];
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['size'] > 0) {
  $thumbExt = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
  if (in_array($thumbExt, ['jpg', 'jpeg', 'png', 'gif'])) {
    $newThumb = "thumb_" . time() . "." . $thumbExt;
    move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbDir . $newThumb);
    if ($old['thumbnail'] && file_exists($thumbDir . $old['thumbnail'])) unlink($thumbDir . $old['thumbnail']);
  }
}

$stmt = $conn->prepare("UPDATE pdf_files SET title=?, description=?, file_name=?, thumbnail=?, status=? WHERE id=?");
$stmt->bind_param("sssssi", $title, $description, $newPdf, $newThumb, $status, $id);
$stmt->execute();

echo json_encode(["success" => true, "message" => "File updated successfully."]);
?>
