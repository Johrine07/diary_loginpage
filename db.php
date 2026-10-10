<?php
$host = "localhost";
$dbname = "diary_db";
$username = "root";
$password = ""; // Default XAMPP password is empty

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    exit("Database connection failed. Check db.php and make sure MySQL is running.");
}
?>