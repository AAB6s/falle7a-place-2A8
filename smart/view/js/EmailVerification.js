function sendVerificationCode(event) {
    event.preventDefault();

    const verificationCode = Math.floor(100000 + Math.random() * 900000); // Generate 6-digit code
    const email = document.getElementById('signupEmail').value;

    if (!email) {
        alert("Please enter a valid email.");
        return;
    }

    document.getElementById('verificationCode').value = verificationCode; // Save code in hidden field

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_verification_email.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Verification code sent to your email.");
            document.getElementById('signupForm').submit(); // Submit the form
        } else {
            alert("Failed to send verification code.");
        }
    };
    xhr.send(`email=${encodeURIComponent(email)}&code=${verificationCode}`);
}

function togglePassword() {
    const passwordField = document.getElementById('signupPassword');
    const eyeIcon = document.getElementById('togglePassword');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
