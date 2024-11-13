const wrapper = document.querySelector('.wrapper');
const registerLink = document.querySelector('.register-link');
const loginLink = document.querySelector('.login-link'); 
registerLink.onclick = () => {
    wrapper.classList.add('active');
}

loginLink.onclick = () => {
    wrapper.classList.remove('active');
}
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector(".form-box.login form");
  
    loginForm.addEventListener("submit", function(event) {
      event.preventDefault(); 
  
      const username = loginForm.querySelector('input[type="text"]').value;
      const password = loginForm.querySelector('input[type="password"]').value;
  
      
      if (username === "user" && password === "pass") {
        localStorage.setItem("loggedIn", "true");
        window.location.href = "index.html";
      } else {
        alert("Invalid username or password");
      }
    });
  });