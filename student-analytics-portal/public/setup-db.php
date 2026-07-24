<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS student_analytics");
    echo "Database created.\n";
    
    // run migrations
    $output = shell_exec('cd .. && php artisan migrate:fresh --seed 2>&1');
    echo "<pre>$output</pre>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
