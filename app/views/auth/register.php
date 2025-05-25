<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت‌نام | نام اپلیکیشن شما</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap" rel="stylesheet">
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
                <a href="/login" class="btn btn-secondary">ورود</a>
            </div>
            <button class="menu-toggle" aria-label="Toggle navigation">
                <span class="hamburger"></span>
            </button>
        </div>
    </header>

    <main>
    <section class="auth-section">
            <div class="form-container">
                <h2>ثبت‌نام</h2>
                <?php
                // Display flash messages
                $errors = \App\Core\Session::getFlash('errors');
                $success = \App\Core\Session::getFlash('success');
                $old_input = \App\Core\Session::getFlash('old_input') ?? [];

                if ($success) {
                    echo '<div class="alert success">' . htmlspecialchars($success) . '</div>';
                }
                if ($errors) {
                    echo '<div class="alert error"><ul>';
                    foreach ($errors as $error) {
                        echo '<li>' . htmlspecialchars($error) . '</li>';
                    }
                    echo '</ul></div>';
                }
                ?>
                <form id="registerForm" action="/register" method="POST">
                    <div class="form-group">
                        <label for="username">نام کاربری:</label>
                        <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($old_input['username'] ?? ''); ?>">
                        <div class="error-message" id="usernameError"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>">
                        <div class="error-message" id="emailError"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور:</label>
                        <input type="password" id="password" name="password" required>
                        <div class="error-message" id="passwordError"></div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">تکرار رمز عبور:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">ثبت‌نام</button>
                    </div>
                    <div class="switch-form-link">
                        آیا حساب کاربری دارید؟ <a href="/login">وارد شوید</a>
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