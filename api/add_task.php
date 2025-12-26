<?php
// api/add_task.php
session_start();
include_once '../config/db.php';

// اگر کاربر لاگین نکرده باشد، اجازه دسترسی نداریم
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die(json_encode(["error" => "دسترسی غیرمجاز"]));
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title)) {
    try {
        $query = "INSERT INTO tasks (user_id, title) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        
        // از سشن آیدی کاربر را می‌گیریم تا تسک به نام خودش ثبت شود
        if ($stmt->execute([$_SESSION['user_id'], $data->title])) {
            echo json_encode(["success" => true, "id" => $conn->lastInsertId()]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
?>