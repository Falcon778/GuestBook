<?php
session_start();
define("HOST", "localhost");
define("USER", "Falcon");
define("PASSWORD", "Zhjckfdrbpzr44");
define("DBNAME", "guestbook");
define("CHARSET", "utf8");
define("SALT", "webDEVblog");

$dsn = "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=" . CHARSET;
try {
    $dbConn = new PDO($dsn, USER, PASSWORD);
} catch (PDOException $e) {
    die('Connection lost:' . $e->getMessage());
}