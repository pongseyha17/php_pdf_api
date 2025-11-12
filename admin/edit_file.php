<?php
$id = $_GET['id'];
$files = json_decode(file_get_contents("http://localhost/php_pdf_api/api/get_files.php"), true);
$file = array_filter($files, fn($f) => $f['id'] == $id);
$file = reset($file);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit PDF</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Edit PDF File</h2>
  <form id="editForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $file['id'] ?>">
    <div class="mb-3"><label>Title</label><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($file['title']) ?>"></div>
    <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"><?= htmlspecialchars($file['description']) ?></textarea></div>
    <div class="mb-3"><label>Replace PDF (optional)</label><input type="file" name="file" accept="application/pdf" class="form-control"></div>
    <div class="mb-3"><label>Thumbnail (optional)</label><input type="file" name="thumbnail" accept="image/*" class="form-control">
      <?php if ($file['thumb_url']): ?><p>Current: <img src="<?= $file['thumb_url'] ?>" width="80"></p><?php endif; ?>
    </div>
    <div class="mb-3"><label>Status</label>
      <select name="status" class="form-select">
        <option value="enabled" <?= $file['status']=='enabled'?'selected':'' ?>>Enabled</option>
        <option value="disabled" <?= $file['status']=='disabled'?'selected':'' ?>>Disabled</option>
      </select>
    </div>
    <button class="btn btn-success">Update</button>
    <a href="index.php" class="btn btn-secondary">Back</a>
  </form>
</div>
<script>
document.getElementById('editForm').addEventListener('submit', e => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fetch('../api/update.php', { method: 'POST', body: fd })
    .then(r => r.json()).then(res => {
      alert(res.message);
      if (res.success) location.href = 'index.php';
    });
});
</script>
</body>
</html>
