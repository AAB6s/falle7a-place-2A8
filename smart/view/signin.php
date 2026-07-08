<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <div class="form-container">
        <div class="form-box login">
            <h2>Sign In</h2>
            <form id="signinForm" autocomplete="off">
                <div class="input-box">
                    <input type="email" id="signinEmail" name="email" placeholder="Email" autocomplete="email" required>
                    <i class="fas fa-envelope"></i>
                    <div id="emailError" class="error-message"></div>
                </div>
                <div class="input-box">
                    <input type="password" id="signinPassword" name="password" placeholder="Password"
                        autocomplete="current-password" required>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePassword()"></i>
                    <div id="passwordError" class="error-message"></div>
                </div>
                <button type="submit">Sign In</button>
                <div class="logreg-link">
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                </div>
                <div class="forgot-password">
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    const token = localStorage.getItem('token') || localStorage.getItem('token');

    if (token) {
        alert('You are already logged in. Redirecting...');
        window.location.href = 'signin.php';
    }

    window.addEventListener('storage', function(event) {
        if (event.key === 'token' && event.newValue) {
            alert('You are already logged in on another tab.');
            window.location.href = 'signin.php';
        }
    });

    document.getElementById('signinForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const email = document.getElementById('signinEmail').value.trim();
        const password = document.getElementById('signinPassword').value.trim();
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';

        if (!email || !email.match(/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email.';
            return;
        }
        if (!password) {
            document.getElementById('passwordError').textContent = 'Password is required.';
            return;
        }

        try {
            const response = await fetch('/smart/view/log.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email,
                    password
                })
            });

            const result = await response.json();

            if (result.status === 'success') {
                sessionStorage.setItem('token', result.token);
                localStorage.setItem('token', result.token);
                window.location.href = result.redirect_url;
            } else {
                alert(result.message || 'Invalid credentials.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Connection error.');
        }
    });

    function togglePassword() {
        const passwordField = document.getElementById('signinPassword');
        passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>

</html>