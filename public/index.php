<?php
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts = $path === '' ? [] : explode('/', $path);

// remove "artisphere" folder name from URL parts
if (!empty($parts) && $parts[0] === 'artisphere') {
    array_shift($parts);
}

// if URL is like /catalogue/page/2 or /catalogue/category/3/page/2
if (!empty($parts)) {
    $_GET['controller'] = $parts[0];
    $_GET['action'] = 'index';

    for ($i = 1; $i < count($parts); $i += 2) {
        if (isset($parts[$i + 1])) {
            // page/2  => $_GET['page']=2
            // category/3 => $_GET['category']=3 (we convert it to cat below)
            $_GET[$parts[$i]] = $parts[$i + 1];
        }
    }

    // map "category" token to your existing "cat" parameter
    if (isset($_GET['category']) && !isset($_GET['cat'])) {
        $_GET['cat'] = $_GET['category'];
    }
}







/*
IMPORTANT : ce fichier ne sert que de routeur entre les différentes pages du site
*/

// Sessions (roles / login simulation, etc.)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$root = dirname(__DIR__);

// core
require_once $root . '/app/core/base_controller.php';
require_once $root . '/app/core/database.php';

// paramètres de l'URL
$controllerParam = $_GET['controller'] ?? 'index';   // ex: index, FAQ…
$action          = $_GET['action'] ?? 'index';       // ex: index, listePersonnes…

// nom de la classe de contrôleur
$controllerClass = $controllerParam . '_controller';     // ex: index_controller
$controllerFile  = $root . '/app/controller/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "Controller $controllerClass introuvable.";
    exit;
}

require_once $controllerFile;

if (!class_exists($controllerClass)) {
    http_response_code(500);
    echo "Classe $controllerClass non trouvée dans $controllerFile.";
    exit;
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo "Action $action introuvable dans $controllerClass.";
    exit;
}

// méthode du contrôleur
$controller->$action();