<?php
// api/register.php
include_once '../config/db.php';

// گرفتن داده‌های ارسالی از جاوااسکریپت (JSON)
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username) && !empty($data->password) && !empty($data->email)) {
    
    // ۱. هش کردن پسورد برای امنیت (بسیار مهم)
    $hashed_password = password_hash($data->password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$data->username, $data->email, $hashed_password])) {
            echo json_encode(["success" => true, "message" => "کاربر با موفقیت ساخته شد."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "خطا: نام کاربری یا ایمیل تکراری است."]);
    }
}
?>