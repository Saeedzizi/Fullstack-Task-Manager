<?php
// api/delete_task.php
session_start();
include_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die();
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    try {
        // امنیت: فقط تسک خود کاربر حذف شود
        $query = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$data->id, $_SESSION['user_id']])) {
            echo json_encode(["success" => true]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
?>