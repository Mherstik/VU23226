<?php 
$host = "localhost"; 
$dbname = "login_system"; 
$dbuser = "login_app"; 
$dbpass = "strongpass"; 
try { 
	$pdo = new PDO( 
		"mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
		$dbuser, 
		$dbpass, 
		[ 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
			PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

} catch (PDOException $e) {

    die("Database connection failed.");

}