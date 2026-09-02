<?php error_reporting(E_ALL);
ini_set("display_errors", "1");
$debug = false;
/* |-------------------------------------------------------------------------- | Debug Function |-------------------------------------------------------------------------- */ function debug(
    $message
) {
    global $debug;
    if ($debug) {
        echo $message . "<br>";
    }
}
/* |-------------------------------------------------------------------------- | Start Session |-------------------------------------------------------------------------- */ debug(
    "STEP 1 - PHP is running"
);
session_start();
debug("STEP 2 - Session started");
/* |-------------------------------------------------------------------------- | Database Connection |-------------------------------------------------------------------------- */ require "db.php";
debug("STEP 3 - Database loaded");
/* |-------------------------------------------------------------------------- | Make Sure This Is A POST Request |-------------------------------------------------------------------------- */ if (
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {
    if ($debug) {
        echo "STEP 4 - Not a POST request<br>";
    }
    exit();
}
debug("STEP 4 - POST request received");
/* |-------------------------------------------------------------------------- | Get Form Data |-------------------------------------------------------------------------- */ $username = trim(
    $_POST["username"] ?? ""
);
$password = $_POST["password"] ?? "";
debug("STEP 5 - Form data received");
debug("Username: " . htmlspecialchars($username, ENT_QUOTES, "UTF-8"));
/* |-------------------------------------------------------------------------- | Validate Form Data |-------------------------------------------------------------------------- */ if (
    $username === "" ||
    $password === ""
) {
    if ($debug) {
        die("STEP 6 - Missing username or password");
    }
    die("Please enter your username and password.");
}
debug("STEP 6 - Username and password present");
/* |-------------------------------------------------------------------------- | Look Up User |-------------------------------------------------------------------------- */ $stmt = $pdo->prepare(
    "SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1"
);
debug("STEP 7 - SQL prepared");
$stmt->execute([$username]);
debug("STEP 8 - SQL executed");
$user = $stmt->fetch();
debug("STEP 9 - User lookup complete");
/* |-------------------------------------------------------------------------- | Check User Exists |-------------------------------------------------------------------------- */ if (
    !$user
) {
    if ($debug) {
        die("STEP 10 - User not found");
    }
    die("Incorrect username or password.");
}
debug("STEP 10 - User found");
/* |-------------------------------------------------------------------------- | Verify Password |-------------------------------------------------------------------------- */ if (
    !password_verify($password, $user["password_hash"])
) {
    if ($debug) {
        die("STEP 11 - Password verification failed");
    }
    die("Incorrect username or password.");
}
debug("STEP 11 - Password verified");
/* |-------------------------------------------------------------------------- | Create Session |-------------------------------------------------------------------------- */ session_regenerate_id(
    true
);
debug("STEP 12 - Session regenerated");
$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];
debug("STEP 13 - Session variables created");
debug("<strong>STEP 14 - LOGIN SUCCESSFUL</strong>");
/* |-------------------------------------------------------------------------- | Login Successful |-------------------------------------------------------------------------- */ header(
    "Location: dashboard.php"
);
exit(); ?>
