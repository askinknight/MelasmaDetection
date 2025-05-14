<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $personName = $conn->real_escape_string($_POST['person_name']);
    $targetDir = "images/";
    $filename = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $filename;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ตรวจสอบว่าคือไฟล์รูปภาพจริง
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO images (filename, person_name) VALUES ('$filename', '$personName')";
            if ($conn->query($sql) === TRUE) {
                header("Location: index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์.";
        }
    } else {
        echo "ไฟล์นี้ไม่ใช่รูปภาพ.";
    }
}

$conn->close();
?>
