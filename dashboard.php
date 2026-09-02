<?php session_start(); // Make sure the user is logged in if (!isset($_SESSION["user_id"])) { header("Location: index.html"); exit; } $username = htmlspecialchars( $_SESSION["username"], ENT_QUOTES, "UTF-8" ); ?> <!DOCTYPE html> <html lang="en"> <head>
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Dashboard</title>

<link rel="stylesheet" href="style.css">

<style>

    .dashboard-card {
        text-align: center;
    }

    .dashboard-card h1 {
        margin-bottom: 10px;
    }

    .welcome {
        color: #666;
        margin-bottom: 30px;
    }

    .logout-button {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 10px;
        background: #667eea;
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .logout-button:hover {
        background: #5568d8;
        transform: translateY(-2px);
    }

</style>

</head> <body>
<div class="login-container">

    <div class="login-card dashboard-card">

        <h1>Welcome!</h1>

        <p class="welcome">
            You are logged in as
            <strong><?php echo $username; ?></strong>.
        </p>

        <a
            href="logout.php"
            class="logout-button"
        >
            Log Out
        </a>

    </div>

</div>

</body> </html>