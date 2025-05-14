<?php
if (isset($_GET['image'])) {
    $imagePath = $_GET['image'];

    // สร้างชื่อไฟล์ผลลัพธ์ที่คาดว่าจะมี
    $faceImage = str_replace(".jpg", "_face.jpg", $imagePath);
    $pixelGraph = str_replace(".jpg", "_pixel_graph.png", $imagePath);

    // ตรวจสอบว่าไฟล์ประมวลผลแล้วมีอยู่หรือไม่
    if (file_exists($faceImage) && file_exists($pixelGraph)) {
        // ถ้ามีอยู่แล้ว ส่ง path กลับทันที
        $response = [
            'success' => true,
            'face_image' => $faceImage,
            'pixel_graph' => $pixelGraph
        ];
    } else {
        // ใช้ path เต็มของ Python interpreter และ Python script
        $pythonPath = 'C:\\Users\\Lenovo\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';
        $scriptPath = 'D:\\xampp\\htdocs\\ez\\process_image.py';
        $command = escapeshellcmd("$pythonPath $scriptPath \"$imagePath\"");

        // รับ output จากการประมวลผล
        $output = shell_exec($command);
        
        // แยกข้อมูลที่ส่งกลับจาก Python
        $outputParts = explode('|', trim($output));
        if (count($outputParts) == 2) {
            $faceImage = $outputParts[0];
            $pixelGraph = $outputParts[1];

            $response = [
                'success' => true,
                'face_image' => $faceImage,
                'pixel_graph' => $pixelGraph
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'เกิดข้อผิดพลาดในการประมวลผลภาพ'
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
