<?php
session_start();

require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/ContactController.php';

// Récupère l'URI sans les paramètres GET
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routeur basique
switch ($uri) {
    case '/':
    case '/home':
        $controller = new HomeController();
        $controller->index();
        break;

    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;

    case '/register':
        $controller = new AuthController();
        $controller->register();
        break;

    case '/contact':
        $controller = new ContactController();
        $controller->render();
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée.";
        break;
}
