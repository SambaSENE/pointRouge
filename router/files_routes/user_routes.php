<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;

$router = new Router();

// Route pour la page d'accueil
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

// Route pour la page "À propos"
$router->get('/about', function() {
    $controller = new HomeController();
    $controller->about();
});

// Route pour afficher un utilisateur spécifique par ID
$router->get('/user/(\d+)', function($id) {
    $controller = new UserController();
    $controller->show($id);
});

// Route pour afficher la liste des utilisateurs
$router->get('/users', function() {
    $controller = new UserController();
    $controller->index();
});

// Route pour créer un nouvel utilisateur (exemple POST)
$router->post('/user/create', function() {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    $controller = new UserController();
    $controller->create($data);
});

// Route pour mettre à jour un utilisateur existant (exemple POST)
$router->post('/user/(\d+)/update', function($id) {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    $controller = new UserController();
    $controller->update($id, $data);
});

// Route pour supprimer un utilisateur
$router->get('/user/(\d+)/delete', function($id) {
    $controller = new UserController();
    $controller->delete($id);
});

// Lancer le routeur
$router->run();
