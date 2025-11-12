<?php
header("Content-Type: application/json");
include 'db.php';

$id = $_POST['id'] ?? 0;
if ($id == 0) {
  echo json_encode(["success" => false, "message" => "Invalid ID."]);
  exit;
}

$res = $conn->query("SELECT file_name, thumbnail FROM pdf_files WHERE id=$id");
if ($res->num_rows > 0) {
  $row = $res->fetch_assoc();
  $pdfPath = "../uploads/pdfs/" . $row['file_name'];
  $thumbPath = "../uploads/thumbs/" . $row['thumbnail'];

  if (file_exists($pdfPath)) unlink($pdfPath);
  if ($row['thumbnail'] && file_exists($thumbPath)) unlink($thumbPath);

  $conn->query("DELETE FROM pdf_files WHERE id=$id");
  echo json_encode(["success" => true, "message" => "File deleted successfully."]);
} else {
  echo json_encode(["success" => false, "message" => "File not found."]);
}
?>
