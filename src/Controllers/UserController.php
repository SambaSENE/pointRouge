<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;
use DateTime;
use Exception;

class UserController
{
    private UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    /**
     * Affiche le formulaire d'inscription et gère l'inscription d'un nouvel utilisateur.
     *
     * @return void
     */
    public function register(): void
    {
        $message = ''; // Initialiser le message

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation des données d'entrée
            if (empty($username) || empty($email) || empty($password)) {
                $message = 'Tous les champs sont requis.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Adresse e-mail invalide.';
            } elseif ($this->userDAO->findByUsername($username) || $this->userDAO->findByEmail($email)) {
                $message = 'Le nom d\'utilisateur ou l\'e-mail est déjà utilisé.';
            } else {
                // Hacher le mot de passe ici, dans le contrôleur
                $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
                $user = new UserModel(0, $username, $email, $hashedPassword, new DateTime(), 'user');

                try {
                    if ($this->userDAO->createUser($user)) {
                        $message = 'Inscription réussie !';
                        header('Location: /login');
                        exit();
                    } else {
                        $message = 'Erreur lors de l\'inscription.';
                    }
                } catch (Exception $e) {
                    $message = 'Une erreur est survenue : ' . $e->getMessage();
                }
            }
        }

        // Afficher le formulaire d'inscription avec les messages
        include __DIR__ . '/../views/user/register.php';
    }


    /**
     * Affiche le formulaire de connexion et gère l'authentification de l'utilisateur.
     *
     * @return void
     */
    public function login(): void
    {
        $message = ''; // Initialiser le message

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $message = 'Tous les champs sont requis.';
            } else {
                $user = $this->userDAO->findByEmail($email);

                if ($user && password_verify($password, $user->getPassword_user())) {
                    // Démarrer la session et stocker les informations utilisateur
                    session_start();
                    $_SESSION['user_id'] = $user->getId_user();
                    $_SESSION['user_role'] = $user->getRole_user();

                    if ($user->getRole_user() === 'admin') {
                        header('Location: /dashboard');
                    } else {
                        header('Location: /profile');
                    }
                    exit();
                } else {
                    $message = 'Email ou mot de passe incorrect.';
                }
            }
        }

        // Afficher le formulaire de connexion avec les messages
        include __DIR__ . '/../views/user/login.php';
    }

    /**
     * Met à jour les informations de l'utilisateur.
     *
     * @param int $id L'identifiant de l'utilisateur.
     * @param array $data Les données à mettre à jour.
     *
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $message = ''; // Initialiser le message

        try {
            $user = $this->userDAO->findById($id);

            if ($user !== null) {
                $user->setUsername($data['username']);
                $user->setEmail_user($data['email']);

                if (!empty($data['password'])) {
                    $user->setPassword_user(password_hash($data['password'], PASSWORD_ARGON2I));
                }

                if ($this->userDAO->updateUser($user)) {
                    $message = 'Mise à jour réussie !';
                    header('Location: /user/' . $id);
                    exit();
                } else {
                    $message = 'Erreur lors de la mise à jour.';
                }
            } else {
                $message = 'Utilisateur non trouvé.';
            }
        } catch (Exception $e) {
            $message = 'Erreur : ' . $e->getMessage();
        }

        // Afficher le formulaire de mise à jour avec les messages
        include __DIR__ . '/../views/user/edit.php';
    }

    /**
     * Supprime un utilisateur par son ID.
     *
     * @param int $id L'identifiant de l'utilisateur à supprimer.
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $message = ''; // Initialiser le message

        try {
            if ($this->userDAO->deleteUser($id)) {
                $message = 'Utilisateur supprimé avec succès.';
            } else {
                $message = 'Erreur lors de la suppression de l\'utilisateur.';
            }
        } catch (Exception $e) {
            $message = 'Erreur : ' . $e->getMessage();
        }

        // Afficher la liste des utilisateurs avec les messages
        include __DIR__ . '/../views/user/list.php';
    }

    /**
     * Affiche le profil de l'utilisateur.
     *
     * @param int $id L'identifiant de l'utilisateur.
     *
     * @return void
     */
    public function show(int $id): void
    {
        $message = ''; // Initialiser le message
        $user = $this->userDAO->findById($id);

        if ($user !== null) {
            include __DIR__ . '/../views/user/show.php';
        } else {
            $message = 'Utilisateur non trouvé.';
            include __DIR__ . '/../views/user/list.php';
        }
    }
}
