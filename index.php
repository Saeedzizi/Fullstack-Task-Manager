<?php
// index.php
session_start();

// اگر کاربر لاگین نکرده بود (سشن ست نشده بود)، برو به صفحه لاگین
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>داشبورد وظایف</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
</head>
<body>
    <header>
        <h1>سلام، <?php echo $_SESSION['username']; ?> خوش آمدی! 👋</h1>
        <a href="logout.php" class="btn-logout">خروج</a>
    </header>

<main class="dashboard-container">
    <div class="task-app">
        <div class="task-input-box">
            <input type="text" id="newTaskInput" placeholder="تسک جدید را بنویسید...">
            <button onclick="addNewTask()">افزودن +</button>
        </div>

        <div class="task-list-section">
            <h3>وظایف امروز شما</h3>
            <ul id="taskList"></ul>
        </div>
    </div>
</main>
<footer class="main-footer">
    <div class="footer-content">
        <p>طراحی و توسعه توسط <strong>SaeedAzizi</strong></p>
        <div class="tech-stack">
            <span>PHP</span> • <span>MySQL</span> • <span>JavaScript</span>
        </div>
        <p class="copyright">&copy; ۲۰۲۵ تمامی حقوق محفوظ است</p>
    </div>
</footer>
    <script src="assets/js/app.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>