<?php

require_once __DIR__ . '/../config/config.php';
// Autoloader
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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Gestion API
if (strpos($uri, '/api/') === 0) {
    $apiRoute = substr($uri, 5);

    switch ($apiRoute) {
        case 'user/findByEmail':
            $controller = new \App\Controllers\Api\UserController();
            $controller->findByEmail();
            break;

        case 'user/exists':
            $controller = new \App\Controllers\Api\UserController();
            $controller->exists();
            break;

        case 'user/create':
            $controller = new \App\Controllers\Api\UserController();
            $controller->create();
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'API endpoint not found']);
            break;
    }

    exit;
}

// Gestion Web (HTML)
switch ($uri) {
    case '/':
    case '/home':
        $controller = new \App\Controllers\HomeController();
        $controller->index();
        break;

    case '/login':
        $controller = new \App\Controllers\AuthController();
        $controller->login();
        break;

    case '/register':
        $controller = new \App\Controllers\AuthController();
        $controller->register();
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée.";
        break;
}
