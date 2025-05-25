<?php

// Initialisation
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers généraux
header('Content-Type: text/html; charset=utf-8');

// Chargement config
require_once __DIR__ . '/../config/config.php';

require_once __DIR__ . '/../vendor/autoload.php';


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
        case 'users/update':
            (new \App\Controllers\Api\UserController())->update();
            break;
        case 'users/findAll':
            (new \App\Controllers\Api\UserController())->findAll();
            break;
        case 'users/delete':
            (new \App\Controllers\Api\UserController())->delete();
            break;

        case 'animal':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new \App\Controllers\Api\AnimalController())->findByProprietaireId();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new \App\Controllers\Api\AnimalController())->create();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                (new \App\Controllers\Api\AnimalController())->update();
            } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE'){
                (new \App\Controllers\Api\AnimalController())->delete();
            } else {
                http_response_code(405); 
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        case 'animal/id':
            (new \App\Controllers\Api\AnimalController()) -> findById();
            break;
        case 'animal/exists':
            (new \App\Controllers\Api\AnimalController())->exists();
            break;

        case 'annonce':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new \App\Controllers\Api\AnnonceController())->findById();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new \App\Controllers\Api\AnnonceController())->create();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                (new \App\Controllers\Api\AnnonceController())->delete();

            }else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;

        case 'annonce/all':
            (new \App\Controllers\Api\AnnonceController())->findAll();
            break;

        case 'annonce/search':
            (new \App\Controllers\Api\AnnonceController())->search();
            break;
        
        case 'annonce/me':
            (new \App\Controllers\Api\AnnonceController())->me();
            break;

        case 'auth/refreshToken':
            (new \App\Controllers\Api\TokenController())->refreshToken();
            break;

        case 'message/create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new \App\Controllers\Api\MessageController())->create();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;

        case 'message/create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new \App\Controllers\Api\MessageController())->create();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        
        case 'message/conversation':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new \App\Controllers\Api\MessageController())->findByConversationId();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
            break;
        
        case 'message/conversations':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new \App\Controllers\Api\MessageController())->findAllConversations();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
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
    case '/profile':
        (new \App\Controllers\ProfileController())->profile();
        break;
    case '/faq':
        include __DIR__ . '/../app/Views/pages/faq.php';
        break;
    case '/creerAnnonces':
        (new \App\Controllers\AnnoncesController())->showForm();
        break;
    case '/annonces':
        (new \App\Controllers\AnnoncesController())->showAnnonces();
        break;

    case '/admin/users':
        (new \App\Controllers\AdminController())->showUsers();
        break;

    case '/admin/annonces':
        (new \App\Controllers\AdminController())->annonces();
        break;

    // Route : Ajouter un animal
    case '/ajouter-animal':
        (new \App\Controllers\AnimalController())->ajouterAnimal();
        break;

    // Route : Mes animaux (utilisateur)
    case '/mes-animaux':
        require_once __DIR__ . '/../app/Views/pages/mes-animaux.php';
        break;

    // Route : Editer un animal
   case '/edit-animal':
        require_once __DIR__ . '/../app/Views/pages/edit-animal.php';
        break;

    // Route : Supprimer un animal
    if (preg_match('#^/delete-animal$#', $_SERVER['REQUEST_URI'])) {
        (new \App\Controllers\DeleteAnimalController())->handle();
        exit;
    }

    // Route : Admin - voir tous les animaux
    if (preg_match('#^/admin/animaux$#', $_SERVER['REQUEST_URI'])) {
        require_once __DIR__ . '/../app/Views/admin/animaux.php';
        exit;
    }

    case '/mes-annonces':
        require_once __DIR__ . '/../app/Views/pages/mes-annonces.php';
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../app/Views/default/notFound.php';
        break;
}