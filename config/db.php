<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");

$conn = pg_connect(
    "host=$host 
     port=$port 
     dbname=$dbname 
     user=$user 
     password=$pass 
     sslmode=require"
);

if (!$conn) {
    die("Database connection failed.");
}
?>
