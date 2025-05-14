<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM images WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูล";
        exit;
    }
} else {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $personName = $conn->real_escape_string($_POST['person_name']);
    $sql = "UPDATE images SET person_name = '$personName' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลภาพ</title>
    <link href="https://cdn.tailwindcss.com/3.4.5" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">แก้ไขข้อมูลภาพ</h1>
        <form action="" method="post" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="person_name" class="block text-sm font-medium text-gray-700">ชื่อของผู้ถ่าย</label>
                <input type="text" id="person_name" name="person_name" value="<?= htmlspecialchars($row['person_name']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">บันทึกการเปลี่ยนแปลง</button>
        </form>
        <a href="index.php" class="mt-4 inline-block text-indigo-600 hover:text-indigo-900">กลับไปยังหน้ารูปภาพทั้งหมด</a>
    </div>
</body>
</html>
