<?php
// api/update_task.php
session_start();
include_once '../config/db.php';

// امنیت: فقط کاربر لاگین شده
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die();
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->status)) {
    try {
        // امنیت پیشرفته: فقط تسکی را آپدیت کن که مال همین کاربر است (AND user_id = ?)
        $query = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$data->status, $data->id, $_SESSION['user_id']])) {
            echo json_encode(["success" => true]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
?>