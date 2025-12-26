<?php
// config/db.php

$host = 'localhost';
$db_name = 'taskflow_db';
$username = 'root'; // نام کاربری پیش‌فرض زمپ
$password = '';     // پسورد پیش‌فرض زمپ خالی است

try {
    // ایجاد اتصال با استفاده از کلاس PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    
    // تنظیم حالت خطا برای نمایش استثناها
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "خطا در اتصال به دیتابیس: " . $e->getMessage();
    die();
}
?>