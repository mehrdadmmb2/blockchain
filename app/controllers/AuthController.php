<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Session; // We'll create this simple Session class next

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Handles user registration form submission.
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Should not happen if routed correctly, but good for safety
            header('Location: /register');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        // Server-side Validation
        if (empty($username) || strlen($username) < 3) {
            $errors[] = 'نام کاربری باید حداقل ۳ کاراکتر باشد.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'فرمت ایمیل نامعتبر است.';
        }
        if (empty($password) || strlen($password) < 8) {
            $errors[] = 'رمز عبور باید حداقل ۸ کاراکتر باشد.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'تکرار رمز عبور با رمز عبور مطابقت ندارد.';
        }
        // Check if username or email already exists
        if ($this->userModel->exists($username, $email)) {
            $errors[] = 'نام کاربری یا ایمیل از قبل وجود دارد.';
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userId = $this->userModel->create($username, $email, $hashedPassword);

            if ($userId) {
                // Registration successful. Store message in session.
                Session::setFlash('success', 'ثبت‌نام شما با موفقیت انجام شد. پس از تایید مدیر، می‌توانید وارد شوید.');
                header('Location: /login'); // Redirect to login page
                exit;
            } else {
                $errors[] = 'خطایی در ثبت‌نام رخ داد. لطفا دوباره تلاش کنید.';
            }
        }

        // If there are errors, redirect back to register with error messages
        Session::setFlash('errors', $errors);
        Session::setFlash('old_input', $_POST); // Keep old input for user convenience
        header('Location: /register');
        exit;
    }

    /**
     * Handles user login form submission.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $identifier = trim($_POST['username_email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        // Server-side Validation
        if (empty($identifier)) {
            $errors[] = 'نام کاربری یا ایمیل نمی‌تواند خالی باشد.';
        }
        if (empty($password)) {
            $errors[] = 'رمز عبور نمی‌تواند خالی باشد.';
        }

        if (empty($errors)) {
            $user = $this->userModel->findByIdentifier($identifier);

            if ($user && password_verify($password, $user['password'])) {
                // User found and password matches
                if ($user['status'] === 'active') {
                    // Login successful, set session variables
                    Session::set('user_id', $user['id']);
                    Session::set('username', $user['username']);
                    Session::set('is_admin', (bool)$user['is_admin']);
                    Session::set('user_status', $user['status']);

                    // Redirect to dashboard or admin panel
                    if ($user['is_admin']) {
                        header('Location: /admin/dashboard'); // Create this route later
                    } else {
                        header('Location: /user/dashboard'); // Create this route later
                    }
                    exit;
                } else {
                    $errors[] = 'حساب کاربری شما هنوز فعال نشده است. لطفاً منتظر تایید مدیر بمانید.';
                }
            } else {
                $errors[] = 'نام کاربری/ایمیل یا رمز عبور اشتباه است.';
            }
        }

        // If there are errors, redirect back to login with error messages
        Session::setFlash('errors', $errors);
        Session::setFlash('old_input', $_POST);
        header('Location: /login');
        exit;
    }

    /**
     * Handles user logout.
     */
    public function logout()
    {
        Session::destroy();
        header('Location: /');
        exit;
    }
}