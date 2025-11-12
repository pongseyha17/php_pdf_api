<?php
header("Content-Type: application/json");
include 'db.php';

$res = $conn->query("SELECT * FROM pdf_files ORDER BY id DESC");
$files = [];
while ($row = $res->fetch_assoc()) {
  $row['pdf_url'] = "../uploads/pdfs/" . $row['file_name'];
  $row['thumb_url'] = $row['thumbnail'] ? "../uploads/thumbs/" . $row['thumbnail'] : null;
  $files[] = $row;
}
echo json_encode($files);
?>
