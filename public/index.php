<?php

// Initialisation
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers généraux
header('Content-Type: text/html; charset=utf-8');

// Chargement config
require_once __DIR__ . '/../config/config.php';

// Autoloader PSR-4 simple
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }


    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Récupération de l’URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// === Gestion API ===
if (strpos($uri, '/api/') === 0) {
    $apiRoute = substr($uri, 5);

    switch ($apiRoute) {
        case 'users/find':
            (new \App\Controllers\Api\UserController())->findByEmail();
            break;
        case 'users/exists':
            (new \App\Controllers\Api\UserController())->exists();
            break;
        case 'users/create':
            (new \App\Controllers\Api\UserController())->create();
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'API endpoint not found']);
            break;
    }

    exit;
}

// === Gestion Web ===
switch ($uri) {
    case '/':
    case '/home':
        (new \App\Controllers\HomeController())->index();
        break;
    case '/login':
        (new \App\Controllers\AuthController())->login();
        break;
    case '/register':
        (new \App\Controllers\AuthController())->register();
        break;
    case '/logout':
        (new \App\Controllers\AuthController())->logout();
        break;
    case '/forgotPassword':
        (new \App\Controllers\AuthController())->forgotPassword();
        break;
    case '/contact':
        (new \App\Controllers\ContactController())->render();
        break;
    case '/messagerie':
        (new \App\Controllers\MessagerieController())->showAllConversations();
        break;
    default:
        http_response_code(404);
        include __DIR__ . '/../app/Views/default/notFound.php';
        break;
    
}
