<?php error_reporting(E_ALL);
$debug = false;

function debug($message) {
    global $debug;

    if ($debug) {
        echo $message . "<br>";
    }
}

ini_set("display_errors", "1");
debug("STEP 1 - PHP is running<br>");
session_start();
debug( "STEP 2 - Session started<br>");
require "db.php";
debug( "STEP 3 - Database loaded<br>");
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "STEP 4 - Not a POST request";
    exit();
}
debug( "STEP 4 - POST request received<br>");
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
debug( "STEP 5 - Form data received<br>");
debug( "Username: " . htmlspecialchars($username) . "<br>");
if ($username === "" || $password === "") {
    die("STEP 6 - Missing username or password");
}
debug( "STEP 6 - Username and password present<br>");
$stmt = $pdo->prepare(
    "SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1"
);
debug( "STEP 7 - SQL prepared<br>");
$stmt->execute([$username]);
debug( "STEP 8 - SQL executed<br>");
$user = $stmt->fetch();
debug( "STEP 9 - User lookup complete<br>");
if (!$user) {
    die("STEP 10 - User not found");
}
debug( "STEP 10 - User found<br>");
if (!password_verify($password, $user["password_hash"])) {
    die("STEP 11 - Password verification failed");
}
debug( "STEP 11 - Password verified<br>");
session_regenerate_id(true);
debug( "STEP 12 - Session regenerated<br>");
$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];
debug( "STEP 13 - Session variables created<br>");
debug( "<br><strong>STEP 14 - LOGIN SUCCESSFUL</strong>");
header("Location: dashboard.php");
exit(); ?>
