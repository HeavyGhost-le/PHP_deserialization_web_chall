<?php
require_once 'includes/bootstrap.php';

if (!isset($_COOKIE['profile']) || !isset($_COOKIE['token'])) {
    header("Location: login.php");
    exit;
}

try {
    // Log the raw cookie values
    error_log("Profile Cookie: " . $_COOKIE['profile']);
    error_log("Token Cookie: " . $_COOKIE['token']);

    $user = unserialize(base64_decode($_COOKIE['profile']));

    // Log the unserialized user object
    error_log("Unserialized User: " . print_r($user, true));

    if (!($user instanceof User)) {
        throw new Exception("Invalid user object");
    }

    $expectedToken = hash_hmac('sha256', $user->getToken(), SECRET_KEY);

    // Log the expected token and the received token
    error_log("Expected Token: " . $expectedToken);
    error_log("Received Token: " . $_COOKIE['token']);

    if (!hash_equals($expectedToken, $_COOKIE['token'])) {
        throw new Exception("Invalid token");
    }

    echo $user->getWelcomeMessage();

} catch (Exception $e) {
    error_log("User  error: " . $e->getMessage());
    echo "<p>Error processing your request</p>";
}
