<?php error_reporting(E_ALL);
ini_set("display_errors", "1");
echo "STEP 1 - PHP is running<br>";
session_start();
echo "STEP 2 - Session started<br>";
require "db.php";
echo "STEP 3 - Database loaded<br>";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "STEP 4 - Not a POST request";
    exit();
}
echo "STEP 4 - POST request received<br>";
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
echo "STEP 5 - Form data received<br>";
echo "Username: " . htmlspecialchars($username) . "<br>";
if ($username === "" || $password === "") {
    die("STEP 6 - Missing username or password");
}
echo "STEP 6 - Username and password present<br>";
$stmt = $pdo->prepare(
    "SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1"
);
echo "STEP 7 - SQL prepared<br>";
$stmt->execute([$username]);
echo "STEP 8 - SQL executed<br>";
$user = $stmt->fetch();
echo "STEP 9 - User lookup complete<br>";
if (!$user) {
    die("STEP 10 - User not found");
}
echo "STEP 10 - User found<br>";
if (!password_verify($password, $user["password_hash"])) {
    die("STEP 11 - Password verification failed");
}
echo "STEP 11 - Password verified<br>";
session_regenerate_id(true);
echo "STEP 12 - Session regenerated<br>";
$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];
echo "STEP 13 - Session variables created<br>";
echo "<br><strong>STEP 14 - LOGIN SUCCESSFUL</strong>";
exit(); ?>
