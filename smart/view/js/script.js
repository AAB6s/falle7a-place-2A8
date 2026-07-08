function verif(event) {
    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.input-box input').forEach(input => {
        input.classList.remove('error');
        const errorMessageDiv = document.getElementById(input.id + 'Error');
        if (errorMessageDiv) {
            errorMessageDiv.textContent = '';
        }
    });

    // Validate email
    let email = document.getElementById('loginUsername');
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email.value)) {
        isValid = false;
        const emailError = document.getElementById('loginEmailError');
        if (emailError) {
            emailError.textContent = 'Enter a valid email';
        }
        email.classList.add('error');
    }

    // Validate password
    let password = document.getElementById('loginPassword');
    if (password.value.trim() === '') {
        isValid = false;
        const passwordError = document.getElementById('loginPasswordError');
        if (passwordError) {
            passwordError.textContent = 'Password is required';
        }
        password.classList.add('error');
    }

    // If invalid, prevent form submission
    if (!isValid) {
        event.preventDefault();
        return false;
    }

    // Allow form submission
    return true;
}


function togglePassword() {
    const passwordField = document.getElementById('loginPassword');
    const eyeIcon = document.getElementById('togglePassword');
    
    if (passwordField.type === "password") {
        passwordField.type = "text"; // Show password
        eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password"; // Hide password
        eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
