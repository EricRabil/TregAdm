<?php

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", "1");

session_start();
header('Content-type: text/html; charset=utf8');

$paypalEndpoint = "api.sandbox.paypal.com";
$paypalClientId = "";
$paypalSecret = "";

$dsn = 'mysql:dbname=tregmine;host=localhost;port=3306';
$user = 'root';
$password = '';

define('TREGMINE_API_KEY', '8x5nAX4J5qfp0Emzi214dxWhm43nn3vi');

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $conn->exec("SET NAMES utf8");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
