document.addEventListener('DOMContentLoaded', () => {
    // --- Registration Form Validation ---
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let isValid = true;

            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            // Validate Username
            if (usernameInput.value.trim().length < 3) {
                showError(usernameInput, 'نام کاربری باید حداقل ۳ کاراکتر باشد.');
                isValid = false;
            } else {
                clearError(usernameInput);
            }

            // Validate Email
            if (!validateEmail(emailInput.value.trim())) {
                showError(emailInput, 'فرمت ایمیل نامعتبر است.');
                isValid = false;
            } else {
                clearError(emailInput);
            }

            // Validate Password
            if (passwordInput.value.length < 8) {
                showError(passwordInput, 'رمز عبور باید حداقل ۸ کاراکتر باشد.');
                isValid = false;
            } else {
                clearError(passwordInput);
            }

            // Validate Confirm Password
            if (passwordInput.value !== confirmPasswordInput.value) {
                showError(confirmPasswordInput, 'تکرار رمز عبور با رمز عبور مطابقت ندارد.');
                isValid = false;
            } else {
                clearError(confirmPasswordInput);
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    }

    // --- Login Form Validation ---
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let isValid = true;

            const usernameEmailInput = document.getElementById('username_email');
            const passwordInput = document.getElementById('password');

            // Validate Username/Email
            if (usernameEmailInput.value.trim() === '') {
                showError(usernameEmailInput, 'نام کاربری یا ایمیل نمی‌تواند خالی باشد.');
                isValid = false;
            } else {
                clearError(usernameEmailInput);
            }

            // Validate Password
            if (passwordInput.value.length === 0) {
                showError(passwordInput, 'رمز عبور نمی‌تواند خالی باشد.');
                isValid = false;
            } else {
                clearError(passwordInput);
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    }

    // --- Helper Functions ---
    function showError(inputElement, message) {
        const formGroup = inputElement.closest('.form-group');
        formGroup.classList.add('invalid');
        const errorMessageElement = formGroup.querySelector('.error-message');
        if (errorMessageElement) {
            errorMessageElement.textContent = message;
        }
    }

    function clearError(inputElement) {
        const formGroup = inputElement.closest('.form-group');
        formGroup.classList.remove('invalid');
        const errorMessageElement = formGroup.querySelector('.error-message');
        if (errorMessageElement) {
            errorMessageElement.textContent = '';
        }
    }

    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});