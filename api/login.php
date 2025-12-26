<?php
// api/login.php
session_start(); // شروع نشست کاربری (بسیار مهم)
include_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    
    // جستجوی کاربر بر اساس ایمیل
    $query = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$data->email]);
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // بررسی صحت رمز عبور (مقایسه رمز وارد شده با رمز هش شده در دیتابیس)
        if (password_verify($data->password, $user['password'])) {
            
            // اگر رمز درست بود، اطلاعات مهم را در سشن ذخیره می‌کنیم
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            echo json_encode(["success" => true, "message" => "ورود موفقیت‌آمیز بود."]);
        } else {
            echo json_encode(["success" => false, "message" => "رمز عبور اشتباه است."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "کاربری با این ایمیل یافت نشد."]);
    }
}
?>