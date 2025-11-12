<?php
$files = json_decode(file_get_contents("http://localhost/php_pdf_api/api/get_files.php"), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - PDF Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .thumb { width: 60px; height: 80px; object-fit: cover; border-radius: 6px; }
  </style>
</head>
<body class="p-4">
<div class="container">
  <h2 class="mb-4">📚 PDF File Management</h2>
  <a href="add_file.php" class="btn btn-primary mb-3">➕ Add PDF</a>

  <table class="table table-bordered align-middle text-center">
    <thead class="table-dark">
      <tr><th>ID</th><th>Thumbnail</th><th>Title</th><th>Status</th><th>Date</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php foreach ($files as $f): ?>
      <tr>
        <td><?= $f['id'] ?></td>
        <td>
          <?php if ($f['thumb_url']): ?>
            <img src="<?= $f['thumb_url'] ?>" class="thumb">
          <?php else: ?>
            <span class="text-muted">No image</span>
          <?php endif; ?>
        </td>
        <td><a href="<?= $f['pdf_url'] ?>" target="_blank"><?= htmlspecialchars($f['title']) ?></a></td>
        <td><?= $f['status'] ?></td>
        <td><?= $f['created_at'] ?></td>
        <td>
          <a href="edit_file.php?id=<?= $f['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
          <button class="btn btn-danger btn-sm" onclick="deleteFile(<?= $f['id'] ?>)">🗑️ Delete</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
function deleteFile(id) {
  if (confirm("Delete this file?")) {
    const fd = new FormData();
    fd.append("id", id);
    fetch("../api/delete.php", { method: "POST", body: fd })
      .then(r => r.json()).then(res => { alert(res.message); location.reload(); });
  }
}
</script>
</body>
</html>
