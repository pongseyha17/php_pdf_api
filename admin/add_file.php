<!DOCTYPE html>
<html>
<head>
  <title>Add PDF File</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Add PDF File</h2>
  <form id="uploadForm" enctype="multipart/form-data">
    <div class="mb-3"><label>Title</label><input type="text" name="title" class="form-control" required></div>
    <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
    <div class="mb-3"><label>PDF File</label><input type="file" name="file" accept="application/pdf" class="form-control" required></div>
    <div class="mb-3"><label>Thumbnail (optional)</label><input type="file" name="thumbnail" accept="image/*" class="form-control"></div>
    <div class="mb-3"><label>Status</label>
      <select name="status" class="form-select"><option value="enabled">Enabled</option><option value="disabled">Disabled</option></select>
    </div>
    <button class="btn btn-success">Upload</button>
    <a href="index.php" class="btn btn-secondary">Back</a>
  </form>
</div>
<script>
document.getElementById('uploadForm').addEventListener('submit', e => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fetch('../api/upload.php', { method: 'POST', body: fd })
    .then(r => r.json()).then(res => {
      alert(res.message);
      if (res.success) location.href = 'index.php';
    });
});
</script>
</body>
</html>
