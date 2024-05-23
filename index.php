<?php

$directories = [
    __DIR__ . "/app/Controller/",
    __DIR__ . "/app/Gateway/",
    __DIR__ . "/app/Handler/",
];
function autoload($className)
{
    global $directories;
    foreach ($directories as $directory) {
        $filePath = $directory . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
}

spl_autoload_register('autoload');

header("Content-type: application/json; charset=UTF-8");

set_error_handler(['ErrorHandler', 'handleError']);
set_exception_handler(['ErrorHandler', 'handleException']);

// database connection
$host = "127.0.0.1";
$username = "fh_user";
$password = "new_password";
$dbname = "fh_tripbuilder";
$port = 3306;
$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
$path = $parsedUrl['path'];

$gateway = null;
$controller = null;
switch ($path) {
    case "/airports":
        $gateway = new AirportGateway($pdo);
        $controller = new AirportController($gateway);
        $controller->processRequest($_SERVER['REQUEST_METHOD']);
        break;

    case "/airlines":
        $gateway = new AirlineGateway($pdo);
        $controller = new AirlineController($gateway);
        $controller->processRequest($_SERVER['REQUEST_METHOD']);
        break;

    case "/flights":
        $gateway = new FlightGateway($pdo);
        $controller = new FlightController($gateway);
        $controller->processRequest($_SERVER['REQUEST_METHOD']);
        break;

    case "/onewaytrip":
        $gateway = new OneWayTripGateway($pdo);
        $controller = new OneWayTripController($gateway);
        $controller->processRequest($_SERVER['REQUEST_METHOD']);
        break;

    case "/roundtrip":
        $gateway = new RoundTripGateway($pdo);
        $controller = new RoundTripController($gateway);
        $controller->processRequest($_SERVER['REQUEST_METHOD']);
        break;

    default:
        echo "The api route is unknown.";
        break;
}