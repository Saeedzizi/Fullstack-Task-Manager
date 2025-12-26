<?php
// api/get_tasks.php
session_start();
include_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die();
}

// فقط تسک‌های کاربری که لاگین کرده را انتخاب کن (امنیت داده)
$query = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['user_id']]);

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// خروجی به صورت JSON برای جاوااسکریپت
echo json_encode($tasks);
?>