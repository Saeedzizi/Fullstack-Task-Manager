const registerForm = document.getElementById('registerForm');

if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const userData = {
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        };

        // ارسال داده به PHP بدون رفرش صفحه
        const response = await fetch('api/register.php', {
            method: 'POST',
            body: JSON.stringify(userData),
            headers: { 'Content-Type': 'application/json' }
        });

        const result = await response.json();
        document.getElementById('message').innerText = result.message;
        
        if (result.success) {
            setTimeout(() => window.location.href = 'login.html', 2000);
        }
    });
}


const loginForm = document.getElementById('loginForm');

if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const loginData = {
            email: document.getElementById('loginEmail').value,
            password: document.getElementById('loginPassword').value
        };

        const response = await fetch('api/login.php', {
            method: 'POST',
            body: JSON.stringify(loginData),
            headers: { 'Content-Type': 'application/json' }
        });

        const result = await response.json();
        document.getElementById('loginMessage').innerText = result.message;
        
        if (result.success) {
            // اگر ورود موفق بود، کاربر را به داشبورد بفرست
            window.location.href = 'index.php';
        }
    });
}
// assets/js/app.js - ادامه کدها

// ۱. تابع دریافت و نمایش لیست تسک‌ها
async function loadTasks() {
    try {
        const response = await fetch('api/get_tasks.php');
        const tasks = await response.json();
        
        const list = document.getElementById('taskList');
        list.innerHTML = ''; // پاکسازی لیست برای بارگذاری مجدد

        tasks.forEach(task => {
            const li = document.createElement('li');
            li.className = 'task-item';
            
            // اضافه کردن کلاس done اگر تسک از قبل انجام شده باشد
            if(task.status === 'completed') li.classList.add('done');
            
            // بررسی وضعیت چک‌باکس
            const isChecked = task.status === 'completed' ? 'checked' : '';
            
            li.innerHTML = `
                <div class="task-info">
                    <input type="checkbox" 
                           onchange="toggleTask(${task.id}, this.checked)" 
                           ${isChecked}>
                    <span>${task.title}</span>
                </div>
                
                <button class="btn-delete" onclick="deleteTask(${task.id})" title="حذف وظیفه">
                    <ion-icon name="trash-outline" class="trash-icon"></ion-icon>
                </button>
            `;
            list.appendChild(li);
        });
    } catch (error) {
        console.error("خطا در بارگذاری تسک‌ها:", error);
    }
}


async function addNewTask() {
    const input = document.getElementById('newTaskInput');
    const title = input.value;

    if (!title) return alert("لطفا عنوان تسک را وارد کنید");

    const response = await fetch('api/add_task.php', {
        method: 'POST',
        body: JSON.stringify({ title: title }),
        headers: { 'Content-Type': 'application/json' }
    });

    const result = await response.json();
    
    if (result.success) {
        input.value = ''; // خالی کردن اینپوت
        loadTasks(); // رفرش کردن لیست بدون رفرش صفحه!
    }
}

// وقتی کاربر وارد داشبورد شد، لیست را لود کن (فقط اگر در صفحه ایندکس هستیم)
if (document.getElementById('taskList')) {
    loadTasks();
}

// assets/js/app.js

// ۱. تابع نمایش لیست (نسخه پیشرفته با دکمه‌ها)
async function loadTasks() {
    const response = await fetch('api/get_tasks.php');
    const tasks = await response.json();
    
    const list = document.getElementById('taskList');
    list.innerHTML = '';

    tasks.forEach(task => {
        const li = document.createElement('li');
        li.className = 'task-item';
        if (task.status === 'completed') li.classList.add('done');

        // چک‌باکس برای وضعیت
        const isChecked = task.status === 'completed' ? 'checked' : '';

        li.innerHTML = `
            <div class="task-info">
                <input type="checkbox" onchange="toggleTask(${task.id}, this.checked)" ${isChecked}>
                <span>${task.title}</span>
            </div>
            <button class="btn-delete" onclick="deleteTask(${task.id})">🗑️</button>
        `;
        list.appendChild(li);
    });
}

// ۲. تابع تغییر وضعیت (Update)
async function toggleTask(id, isChecked) {
    const newStatus = isChecked ? 'completed' : 'pending';

    await fetch('api/update_task.php', {
        method: 'POST',
        body: JSON.stringify({ id: id, status: newStatus }),
        headers: { 'Content-Type': 'application/json' }
    });

    loadTasks(); // رفرش لیست برای اعمال استایل‌ها
}

// ۳. تابع حذف (Delete)
async function deleteTask(id) {
    if(!confirm("آیا مطمئن هستید؟")) return; // تاییدیه قبل از حذف

    await fetch('api/delete_task.php', {
        method: 'POST',
        body: JSON.stringify({ id: id }),
        headers: { 'Content-Type': 'application/json' }
    });

    loadTasks();
}

