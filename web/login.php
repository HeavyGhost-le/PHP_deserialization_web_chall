<?php
require_once 'includes/bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "guest";
    $token = bin2hex(random_bytes(16));

    $user = new User($username, $token);
    $serialized = serialize($user);

    // Debugging logs
    error_log("Serialized User: " . $serialized);
    
    // Set cookies for profile and token
    setcookie("profile", base64_encode($serialized), [
        'expires' => time() + 3600,
        'path' => '/',
        'secure' => false, // Set to false for testing in HTTP
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    error_log("Set cookie profile with value: " . base64_encode($serialized));
    
    setcookie("token", hash_hmac('sha256', $token, SECRET_KEY), [
        'expires' => time() + 3600,
        'path' => '/',
        'secure' => false, // Set to false for testing in HTTP
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    error_log("Set cookie token with value: " . hash_hmac('sha256', $token, SECRET_KEY));
    
    header("Location: user.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Idle Transfiguration v2</title>
  <style>
    @keyframes glitch {
      0%, 50%, 100% { text-shadow: 2px 0 #ff00ff, -2px 0 #00ffff; }
      25%, 75% { text-shadow: -2px 0 #ff00ff, 2px 0 #00ffff; }
    }
    body {
      background-color: #0f0f0f;
      color: #00ff88;
      font-family: 'Courier New', monospace;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }
    .login-box {
      border: 1px solid #00ff88;
      padding: 2rem;
      box-shadow: 0 0 20px #00ff8880;
    }
    input {
      background-color: #000;
      border: 1px solid #00ff88;
      color: #00ff88;
      padding: 10px;
      margin: 10px;
    }
    h2 {
      animation: glitch 1s linear infinite;
    }
  </style>
</head>
<body>
<div class="login-box">
  <h2>Idle Transfiguration v2</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Enter username" required>
    <input type="submit" value="Access">
  </form>
</div>
</body>
</html>
