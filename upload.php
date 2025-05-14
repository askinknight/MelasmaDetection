<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload or Capture Photo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>อัปโหลดหรือถ่ายรูป</h1>
            <form action="process_upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="person_name">ชื่อของผู้ถ่าย</label>
                    <input type="text" id="person_name" name="person_name" placeholder="ชื่อของผู้ถ่าย" required>
                </div>
                <div class="form-group">
                    <label for="image">เลือกรูปภาพ</label>
                    <input type="file" id="image" name="image" accept="image/*" capture="camera" required>
                </div>
                <button type="submit" class="btn btn-submit">อัปโหลดรูป</button>
            </form>
            <a href="index.php" class="btn btn-back">กลับไปยังหน้ารูปภาพทั้งหมด</a>
        </div>
    </div>
</body>
</html>
