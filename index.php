<?php
session_start();
ob_start(); //Zapnutí vyrovnávací paměti - zachrání nás před "headers already sent" chybou - poradil bot

require_once 'includes/db.php';     //připojení k databázi

require_once 'models/UserModel.php';
require_once 'controllers/UserController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/AuthController.php';

$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'dashboard';     //získání URL od .htaccess


$urlParts = explode('/', $url);         //parsování URL adresy podle lomítek
$page = $urlParts[0];                   //Zjistíme hlavní sekci

if (!isset($_SESSION['user_id']) && $page !== 'login') {        // Globální ochrana přístupu: Pokud uživatel není přihlášený a nejde na login stránku, přesměruj ho na login
    header("Location: index.php?url=login");
    exit;
}


switch ($page) {                        //switch rozhodce, co se má stát
    case 'users':
        $userModel = new UserModel($pdo);                       // Vytvoříme Model a předáme mu spojení s databází ($pdo pochází z db.php)
        $userController = new UserController($userModel);       // Vytvoříme Controller a předáme mu Model
        $userController->index();                               // Zavoláme hlavní metodu Controlleru pro zobrazení tabulky
        break;
    
    case 'others':
        require_once 'controllers/OthersController.php';
        $controller = new OthersController();
        $controller->index();
        break;

    case 'login':
        $auth = new AuthController($pdo);
        $auth->login();
        break;

    case 'logout':
        $auth = new AuthController($pdo);
        $auth->logout();
        break;
            
    case 'dashboard':
        $userModel = new UserModel($pdo);
        $dash = new DashboardController($userModel);
        $dash->index();
        break;
            
    default:
        http_response_code(404);                // Stránka nenalezena
        echo "Chyba 404: Stránka nenalezena.";
        break;
}



