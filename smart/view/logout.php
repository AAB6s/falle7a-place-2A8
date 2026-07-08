<?php
session_start();

// Clear the session data and destroy the session
session_unset();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '', 
        time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Set headers to avoid caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Send JavaScript to remove token from sessionStorage, localStorage and redirect
echo "<script>
        sessionStorage.removeItem('token');  // Remove 'token' from sessionStorage
        localStorage.removeItem('token');  // Remove 'token' from localStorage (if set)
        window.location.href = 'signin.php';  // Redirect to login page
      </script>";
exit;
?>