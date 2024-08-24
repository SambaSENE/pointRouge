<?php

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
// Route pour afficher le formulaire de mise à jour de l'utilisateur (GET)
$router->get('/user/(\d+)/update', function($id) {
    $controller = new UserController();
    $controller->edit($id);  // Méthode pour afficher le formulaire de mise à jour
});

// Route pour traiter la mise à jour de l'utilisateur (POST)
$router->post('/user/(\d+)/update', function($id) {
    $controller = new UserController();
    $data = $_POST;  // Récupérer les données envoyées par le formulaire
    $controller->update($id, $data);  // Méthode pour traiter la mise à jour
});

// Route pour supprimer un utilisateur
$router->get('/user/(\d+)/delete', function($id) {
    $controller = new UserController();
    $controller->delete($id);
});

// Route pour afficher le formulaire d'inscription
$router->get('/register', function() {
    $controller = new UserController();
    $controller->register();
});

// Route pour traiter la soumission du formulaire d'inscription
$router->post('/register', function() {
    $controller = new UserController();
    $controller->register();
});
// Route pour afficher le formulaire de connexion
$router->get('/login', function() {
    $controller = new UserController();
    $controller->login();
});

// Route pour traiter la soumission du formulaire de connexion
$router->post('/login', function() {
    $controller = new UserController();
    $controller->login();
});

// Lancer le routeur
$router->run();
