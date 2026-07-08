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