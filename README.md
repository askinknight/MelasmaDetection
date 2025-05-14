# Facial Image Processing with Melasma Detection (PHP + Python + XAMPP)

โปรเจกต์นี้เป็นเว็บแอปพลิเคชันที่ให้ผู้ใช้สามารถอัปโหลดภาพใบหน้า ระบบจะใช้ Python วิเคราะห์ภาพเพื่อตรวจจับใบหน้า, วาดตำแหน่งจุดบนใบหน้า (landmarks) และแสดงผลผ่านเว็บไซต์ PHP ที่ทำงานร่วมกับฐานข้อมูล MySQL (ผ่าน XAMPP)


## 📂 โครงสร้างโปรเจกต์

```

.
├── db.php                 ← เชื่อมต่อฐานข้อมูล
├── index.php             ← หน้าเว็บหลัก
├── upload.php            ← ฟอร์มอัปโหลดภาพ
├── process\_upload.php    ← ประมวลผลข้อมูลจากฟอร์ม
├── process\_image.php     ← เรียกใช้งาน Python
├── process\_image.py      ← สคริปต์ Python สำหรับวิเคราะห์ภาพ
├── edit.php / delete.php ← แก้ไข/ลบข้อมูล
├── styles.css            ← ตกแต่ง UI
├── images.sql            ← ไฟล์สร้างตารางในฐานข้อมูล
├── images.sql            ← ไฟล์สร้างตารางในฐานข้อมูล
└── images/               ← เก็บรูปต้นฉบับและผลลัพธ์

```

---

## ⚙️ วิธีติดตั้งโปรเจกต์ (บน XAMPP)

### 1. ติดตั้ง XAMPP
- ดาวน์โหลด XAMPP ได้ที่: https://www.apachefriends.org/
- เปิดโปรแกรม XAMPP Control Panel แล้ว Start `Apache` และ `MySQL`

### 2. วางโฟลเดอร์โปรเจกต์
- แตกไฟล์ zip แล้ววางไว้ใน `htdocs` เช่น:
```

C:\xampp\htdocs\facial\_project\\

````

### 3. สร้างฐานข้อมูล
- เปิด `http://localhost/phpmyadmin`
- สร้างฐานข้อมูลใหม่ชื่อ `image_upload_db`
- นำเข้า `images.sql` ไปยังฐานข้อมูลที่สร้างไว้

### 4. ตั้งค่าการเชื่อมต่อฐานข้อมูล
เปิดไฟล์ `db.php` แล้วตั้งค่าตามนี้:
```php
<?php
$conn = new mysqli("localhost", "root", "", "image_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
````

### 5. ติดตั้ง Python และไลบรารีที่จำเป็น

* ดาวน์โหลด Python: [https://www.python.org/](https://www.python.org/)
* เปิด CMD แล้วรันคำสั่ง:

```bash
pip install facenet-pytorch mediapipe opencv-python pillow numpy
```

* ตรวจสอบ path ของ Python ในเครื่อง และแก้ไขใน `process_image.php`:

```php
$pythonPath = 'C:\\Path\\To\\Python\\python.exe';
```

---

## 🚀 การใช้งาน

1. เปิดเว็บเบราว์เซอร์แล้วเข้า `http://localhost/facial_project/`
2. อัปโหลดภาพใบหน้า
3. ระบบจะ:

   * บันทึกภาพลงใน `images/`
   * เรียกใช้ Python เพื่อวิเคราะห์และตรวจจับใบหน้า
   * บันทึกภาพใบหน้าพร้อม bounding box และจุด landmark
   * แสดงผลบนหน้าเว็บ

---

## 📌 ฟีเจอร์เด่น

* ตรวจจับใบหน้าด้วย **MTCNN**
* วาดจุด landmark ด้วย **MediaPipe**
* ตรวจสอบภาพซ้ำ: ถ้ามีการประมวลผลแล้วจะไม่รันซ้ำ
* มีฐานข้อมูลจัดเก็บข้อมูลภาพ
* UI เรียบง่าย พร้อมจัดการข้อมูล

---

## 📷 ตัวอย่างผลลัพธ์

ภายใต้โฟลเดอร์ `images/`:

* `ต้นฉบับ.jpg`
* `ต้นฉบับ_face.jpg` — มีกรอบแดงล้อมใบหน้า
* `ต้นฉบับ_pixel_graph.png` — วาดจุดบนใบหน้า (landmark)

---

## 🛠 รายการไลบรารีที่ใช้

### Python

* `facenet-pytorch`
* `mediapipe`
* `numpy`
* `opencv-python`
* `Pillow`

### PHP

* PHP 7+ (ใน XAMPP)
* MySQL (MariaDB)


