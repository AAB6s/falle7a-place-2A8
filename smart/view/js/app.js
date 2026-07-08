function verif(event) {
    event.preventDefault(); // Prevent form submission for validation

    let isValid = true; // Assume form is valid initially

    // Clear previous errors
    document.querySelectorAll('.input-box input').forEach(input => {
        input.classList.remove('error');
        const errorMessageDiv = document.getElementById(input.id + 'Error');
        if (errorMessageDiv) {
            errorMessageDiv.textContent = ''; // Clear previous error messages
        }
    });

    // Validate Username
    let name = document.getElementById('name');
    if (name.value.trim() === '') {
        isValid = false;
        const nameError = document.getElementById('nameError');
        if (nameError) {
            nameError.textContent = 'Username is required';
        }
        name.classList.add('error');
    }

    // Validate Email
    

    // Validate Password
    let password = document.getElementById('signupPassword');
    if (password.value.trim() === '') {
        isValid = false;
        const passwordError = document.getElementById('passwordError');
        if (passwordError) {
            passwordError.textContent = 'Password is required';
        }
        password.classList.add('error');
    } else if (password.value.length < 8) {
        isValid = false;
        const passwordError = document.getElementById('passwordError');
        if (passwordError) {
            passwordError.textContent = 'Password must be at least 8 characters long';
        }
        password.classList.add('error');
    }

    // Validate Address
    let address = document.getElementById('address');
    if (address.value.trim() === '') {
        isValid = false;
        const addressError = document.getElementById('addressError');
        if (addressError) {
            addressError.textContent = 'Address is required';
        }
        address.classList.add('error');
    }

    // Final Validation Check
    if (isValid) {
        console.log("Form is valid. Submitting...");
        document.getElementById('signupForm').submit(); // Submit the form to PHP
    } else {
        console.log("Form validation failed.");
        alert("Please fix the errors before submitting the form.");
    }
}

// Toggle Password Visibility
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
