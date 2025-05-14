<?php
include 'db.php';

// ดึงข้อมูลภาพทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM images ORDER BY upload_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ภาพทั้งหมด</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>ภาพทั้งหมดที่อัปโหลด</h1>
            <a href="upload.php" class="btn">อัปโหลดหรือถ่ายรูปใหม่</a>
        </header>
        <main>
            <div class="gallery">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="card">
                            <a href="#" class="process-image" data-image="images/<?= htmlspecialchars($row['filename']) ?>">
                                <img src="images/<?= htmlspecialchars($row['filename']) ?>" alt="Image">
                            </a>
                            <div class="info">
                                <p><strong>ชื่อผู้ถ่าย:</strong> <?= htmlspecialchars($row['person_name']) ?></p>
                                <p><strong>ชื่อไฟล์:</strong> <?= htmlspecialchars($row['filename']) ?></p>
                                <p><strong>วันที่และเวลา:</strong> <?= $row['upload_time'] ?></p>
                                <div class="actions">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">แก้ไข</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('คุณแน่ใจว่าต้องการลบรูปนี้?')">ลบ</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>ยังไม่มีภาพที่อัปโหลด</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Popup Template -->
    <div id="popup" class="popup" style="display: none;">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h2>ภาพที่ประมวลผล</h2>
            <img id="faceImage" src="" alt="Face Image">
            <h3>กราฟพิกเซลของใบหน้า</h3>
            <img id="pixelGraph" src="" alt="Pixel Graph">
        </div>
    </div>

    <script>
    // Function to open popup and show the processed image and pixel graph
    function openPopup(faceImageSrc, pixelGraphSrc) {
        document.getElementById('faceImage').src = faceImageSrc;
        document.getElementById('pixelGraph').src = pixelGraphSrc;
        document.getElementById('popup').style.display = 'flex';
    }

    // Close popup
    document.querySelector('.close-btn').addEventListener('click', function() {
        document.getElementById('popup').style.display = 'none';
        // เคลียร์ภาพและข้อมูลหลังจากปิด popup
        document.getElementById('faceImage').src = '';
        document.getElementById('pixelGraph').src = '';
    });

    // When the user clicks on an image, process the image and show the result
    document.querySelectorAll('.process-image').forEach(img => {
        img.addEventListener('click', function(e) {
            e.preventDefault();
            const imageUrl = this.getAttribute('data-image');

            // ส่งคำสั่งไปยัง PHP เพื่อเรียก Python script และรับผลลัพธ์
            fetch(`process_image.php?image=${encodeURIComponent(imageUrl)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // แสดงภาพที่ประมวลผลและกราฟพิกเซลใน popup
                        openPopup(data.face_image, data.pixel_graph);
                    } else {
                        alert('เกิดข้อผิดพลาดในการประมวลผลภาพ: ' + data.error);
                    }
                });
        });
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
