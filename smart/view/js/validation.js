// Validation for Login and Sign-Up Forms
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    // Function to validate email format
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Function to validate non-empty fields
    function isValid(input) {
        return input.value.trim() !== '';
    }

    // Login Form Validation
    loginForm.addEventListener('submit', function(event) {
        let isValidForm = true;

        const email = document.getElementById('email');
        const password = document.getElementById('password');

        // Validate email
        if (!isValid(email) || !validateEmail(email.value)) {
            document.getElementById('emailError').textContent = "Please enter a valid email.";
            email.style.borderBottomColor = "red";
            isValidForm = false;
        } else {
            document.getElementById('emailError').textContent = "";
            email.style.borderBottomColor = "#fff";
        }

        // Validate password
        if (!isValid(password)) {
            document.getElementById('passwordError').textContent = "Password cannot be empty.";
            password.style.borderBottomColor = "red";
            isValidForm = false;
        } else {
            document.getElementById('passwordError').textContent = "";
            password.style.borderBottomColor = "#fff";
        }

        if (!isValidForm) {
            event.preventDefault();  // Prevent form submission if invalid
        }
    });

    // Sign-Up Form Validation
    signupForm.addEventListener('submit', function(event) {
        let isValidForm = true;

        const name = document.getElementById('name');
        const signupEmail = document.getElementById('signupEmail');
        const signupPassword = document.getElementById('signupPassword');
        const address = document.getElementById('address');

        // Validate name
        if (!isValid(name)) {
            document.getElementById('nameError').textContent = "Name cannot be empty.";
            name.style.borderBottomColor = "red";
            isValidForm = false;
        } else {
            document.getElementById('nameError').textContent = "";
            name.style.borderBottomColor = "#fff";
        }

        // Validate email
        if (!isValid(signupEmail) || !validateEmail(signupEmail.value)) {
            document.getElementById('signupEmailError').textContent = "Please enter a valid email.";
            signupEmail.style.borderBottomColor = "red";
            isValidForm = false;
        } else {
            document.getElementById('signupEmailError').textContent = "";
            signupEmail.style.borderBottomColor = "#fff";
        }

        // Validate password
        if (!isValid(signupPassword)) {
            document.getElementById('signupPasswordError').textContent = "Password cannot be empty.";
            signupPassword.style.borderBottomColor = "red";
            isValidForm = false;
        } else {
            document.getElementById('signupPasswordError').textContent = "";
            signupPassword.style.borderBottomColor = "#fff";
        }

        // Validate address
        if (!isValid(address)) {
            document.getElementById('addressError').textContent = "Address cannot be empty.";
            address.style.borderBottomColor = "red";
            isValidForm = false;
        } else {
            document.getElementById('addressError').textContent = "";
            address.style.borderBottomColor = "#fff";
        }

        if (!isValidForm) {
            event.preventDefault();  // Prevent form submission if invalid
        }
    });
});
