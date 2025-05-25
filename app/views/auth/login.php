<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود | نام اپلیکیشن شما</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="navbar">
        <div class="container">
            <div class="logo">
                <a href="/">نام اپلیکیشن شما</a>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="/">خانه</a></li>
                    <li><a href="/#features">امکانات</a></li>
                    <li><a href="/#how-it-works">روش کار</a></li>
                    <li><a href="/#privacy">حریم خصوصی</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <a href="/register" class="btn btn-primary">ثبت‌نام</a>
            </div>
            <button class="menu-toggle" aria-label="Toggle navigation">
                <span class="hamburger"></span>
            </button>
        </div>
    </header>

    <main>
        <section class="auth-section">
            <div class="form-container">
                <h2>ورود به حساب کاربری</h2>
                <form id="loginForm" action="/login" method="POST">
                    <div class="form-group">
                        <label for="username_email">نام کاربری یا ایمیل:</label>
                        <input type="text" id="username_email" name="username_email" required>
                        <div class="error-message" id="usernameEmailError"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور:</label>
                        <input type="password" id="password" name="password" required>
                        <div class="error-message" id="passwordError"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">ورود</button>
                    </div>
                    <div class="switch-form-link">
                        حساب کاربری ندارید؟ <a href="/register">ثبت‌نام کنید</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 نام اپلیکیشن شما. کلیه حقوق محفوظ است.</p>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/auth.js"></script>
</body>
</html>