<?php

// app/bootstrap.php

// 1. Basic Autoloader for our project classes
// این بخش به PHP میگه که چطور کلاس‌ها رو پیدا کنه.
// مثلا وقتی App\Core\Router رو صدا می‌زنید، دنبال app/core/Router.php می‌گرده.
spl_autoload_register(function ($class) {
    // تبدیل Namespace به مسیر دایرکتوری (مثلا App\Core\Router به App/Core/Router)
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    // حذف Base Namespace 'App' از ابتدای مسیر (مثلا App/Core/Router به Core/Router)
    $class = str_replace('App' . DIRECTORY_SEPARATOR, '', $class);
    // ساخت مسیر کامل فایل (مثلا /path/to/app/Core/Router.php)
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

    // اگر فایل وجود داشت، اون رو Require کن
    if (file_exists($file)) {
        require_once $file;
    }
});

// 2. Start the Session Manager
// شروع سشن (Session) برای نگهداری وضعیت کاربر (مثلا ورود یا عدم ورود) و پیام‌های فلش (Flash Messages)
use App\Core\Session;
Session::start(); // این تابع سشن رو شروع می‌کنه اگر از قبل شروع نشده باشه

// 3. Include Database Configuration
// فراخوانی تنظیمات دیتابیس
// مطمئن بشید که فایل database.php رو قبلا در app/config/ ساختید و مقادیرش رو درست تنظیم کردید.
require_once __DIR__ . '/config/database.php';


// 4. Initialize the Router
// ایجاد نمونه‌ای از کلاس Router برای مدیریت مسیرها
use App\Core\Router;
$router = new Router();


// 5. Define Application Routes
// در اینجا تمام مسیرهای (Routes) وب‌اپلیکیشن خودمون رو تعریف می‌کنیم.
// هر مسیر یک URL و یک اکشن (نمایش یک صفحه یا فراخوانی یک متد در کنترلر) داره.

// GET Routes (برای نمایش صفحات)
// مسیر ریشه سایت (صفحه لندینگ)
$router->get('/', 'index.php');

// مسیر صفحه ورود
$router->get('/login', 'auth/login.php');

// مسیر صفحه ثبت‌نام
$router->get('/register', 'auth/register.php');

// مسیر خروج از حساب کاربری
// وقتی کاربر روی دکمه خروج کلیک می‌کنه، این مسیر اجرا میشه و متد logout در AuthController فراخوانی میشه.
$router->get('/logout', 'AuthController@logout');

// Placeholder Routes for User and Admin Dashboards (به زودی این صفحات رو ایجاد خواهیم کرد)
// مسیر داشبورد کاربر عادی
$router->get('/user/dashboard', 'user/dashboard.php');
// مسیر داشبورد مدیر
$router->get('/admin/dashboard', 'admin/dashboard.php');


// POST Routes (برای پردازش فرم‌ها و ارسال داده‌ها)
// وقتی فرم ثبت‌نام ارسال میشه، داده‌ها به این مسیر POST میشن و متد register در AuthController اون رو مدیریت می‌کنه.
$router->post('/register', 'AuthController@register');

// وقتی فرم ورود ارسال میشه، داده‌ها به این مسیر POST میشن و متد login در AuthController اون رو مدیریت می‌کنه.
$router->post('/login', 'AuthController@login');


// 6. 404 Error Page
// تعریف مسیر برای خطای 404 (صفحه پیدا نشد)
// اگر هیچکدوم از مسیرهای بالا با URL درخواستی مطابقت نداشت، این صفحه نمایش داده میشه.
$router->get('/404', 'errors/404.php');


// 7. Global Helper Function for Views (اختیاری اما کارآمد)
// این یک تابع کمکی ساده هست که به شما اجازه میده صفحات View رو راحت‌تر فراخوانی کنید.
// مثلا به جای `require __DIR__ . '/views/auth/login.php';` می‌تونید بنویسید `view('auth/login.php', $data);`
function view($name, $data = []) {
    // متغیرهای داخل آرایه $data رو به متغیرهای محلی تبدیل می‌کنه که در فایل View قابل دسترسی باشن
    // مثال: اگر $data = ['user' => 'Ali'] باشه، در View می‌تونید از $user استفاده کنید.
    extract($data);
    // مسیر کامل فایل View رو مشخص می‌کنه
    require __DIR__ . '/views/' . $name;
}