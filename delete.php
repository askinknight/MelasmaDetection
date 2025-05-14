<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT filename FROM images WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = 'images/' . $row['filename'];
        $filePath2 = 'images/' . str_replace(".jpg","",($row['filename'])) . '_face.jpg';
        $filePath3 = 'images/' . str_replace(".jpg","",($row['filename'])) . '_pixel_graph.png';

        // ลบไฟล์ภาพ
        if (file_exists($filePath)) {
            unlink($filePath);
            unlink($filePath2);
            unlink($filePath3);
        }

        // ลบข้อมูลในฐานข้อมูล
        $sql = "DELETE FROM images WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "ไม่พบข้อมูล";
    }
} else {
    header("Location: index.php");
}

$conn->close();
?>
