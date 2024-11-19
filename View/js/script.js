const wrapper = document.querySelector('.wrapper');
const registerLink = document.querySelector('.register-link');
const loginLink = document.querySelector('.login-link'); 
registerLink.onclick = () => {
    wrapper.classList.add('active');
}

loginLink.onclick = () => {
    wrapper.classList.remove('active');
}
// script.js
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector(".form-box.login form");
  
    loginForm.addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent default form submission
  
      const username = loginForm.querySelector('input[type="text"]').value;
      const password = loginForm.querySelector('input[type="password"]').value;
  
      // Simple check for demo purposes (replace with actual auth logic)
      if (username === "user" && password === "pass") {
        // Store login state in localStorage
        localStorage.setItem("loggedIn", "true");
        // Redirect to index.html
        window.location.href = "index.html";
      } else {
        alert("Invalid username or password");
      }
    });
  });

  function verif() {
    // Get input values by their IDs
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const address = document.getElementById('address').value.trim();

    // Define a regular expression for email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Clear any previous alerts
    let errors = [];

    // Validate name
    if (name === "") {
        errors.push("Name is required.");
    }

    // Validate email
    if (email === "") {
        errors.push("Email is required.");
    } else if (!emailRegex.test(email)) {
        errors.push("Enter a valid email address.");
    }

    // Validate password
    if (password === "") {
        errors.push("Password is required.");
    } else if (password.length < 6) {
        errors.push("Password must be at least 6 characters long.");
    }

    // Validate address
    if (address === "") {
        errors.push("Address is required.");
    }

    // Show error messages or proceed with form submission
    if (errors.length > 0) {
        alert(errors.join("\n")); // Display all errors in a single alert
        event.preventDefault(); // Prevent form submission
        return false;
    } else {
        alert("All fields are valid! Form submitted successfully.");
        return true;
    }
}