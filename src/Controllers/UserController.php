<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;
use DateTime;
use Exception;

/**
 * Classe UserController
 *
 * Gère les opérations CRUD pour les utilisateurs.
 */
class UserController
{
    /**
     * @var UserDAO $userDAO Instance de UserDAO pour accéder aux données utilisateur.
     */
    private UserDAO $userDAO;

    /**
     * Constructeur de UserController.
     *
     * Initialise l'instance de UserDAO pour les opérations sur les données utilisateur.
     */
    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    /**
     * Affiche les détails d'un utilisateur spécifique.
     *
     * Cette méthode récupère les informations d'un utilisateur par son ID et affiche une vue correspondante.
     *
     * @param int $id L'identifiant de l'utilisateur.
     * @return void
     */
    public function show(int $id): void
    {
        try {
            $user = $this->userDAO->findById($id);

            if ($user !== null) {
                // Inclure la vue HTML pour afficher les détails de l'utilisateur
                include __DIR__ . '/../views/user/show.php';
            } else {
                // Inclure une vue pour l'utilisateur non trouvé
                include __DIR__ . '/../../views/user/not_found.php';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Affiche la liste de tous les utilisateurs.
     *
     * Cette méthode récupère tous les utilisateurs de la base de données et affiche une vue avec la liste des utilisateurs.
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $users = $this->userDAO->getAllUsers();
            var_dump($users);
            include __DIR__ . '/../Views/User/index.php';
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * Cette méthode traite les données fournies, crée un nouvel utilisateur, et le sauvegarde dans la base de données.
     *
     * @param array $data Les données de l'utilisateur.
     * @return void
     */
    public function create(array $data): void
    {
        try {
            $user = new UserModel($data['id_user'], $data['username'], $data['email_user'], $data['password_user'], new DateTime($data['create_at']));
            $this->userDAO->createUser($user);
            header('Location: /user');
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour un utilisateur existant.
     *
     * Cette méthode met à jour les informations d'un utilisateur existant avec les nouvelles données fournies.
     *
     * @param int $id L'identifiant de l'utilisateur.
     * @param array $data Les nouvelles données de l'utilisateur.
     * @return void
     */
    public function update(int $id, array $data): void
    {
        try {
            $user = $this->userDAO->findById($id);

            if ($user !== null) {
                // Vérifier si les clés existent avant de les utiliser
                if (isset($data['username'])) {
                    $user->setUsername($data['username']);
                }

                if (isset($data['email_user'])) {
                    $user->setEmail_user($data['email_user']);
                }

                if (isset($data['password']) && !empty($data['password_user'])) {
                    $user->setPassword_user(password_hash($data['password_user'], PASSWORD_ARGON2I));
                }

                $this->userDAO->updateUser($user);
                header('Location: /user/' . $id);
                exit;  // Ajoutez un exit après la redirection
            } else {
                echo 'Utilisateur non trouvé.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }



    /**
     * Supprime un utilisateur.
     *
     * Cette méthode supprime un utilisateur de la base de données en utilisant son ID.
     *
     * @param int $id L'identifiant de l'utilisateur.
     * @return void
     */
    public function delete(int $id): void
    {
        try {
            $user = $this->userDAO->findById($id);

            if ($user !== null) {
                $this->userDAO->deleteUser($id);
                header('Location: /user');
            } else {
                echo 'Utilisateur non trouvé.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    public function edit(int $id): void
    {
        $user = $this->userDAO->findById($id);

        if ($user !== null) {
            include __DIR__ . '/../views/user/edit.php';  // Chemin vers votre fichier de vue
        } else {
            echo 'Utilisateur non trouvé.';
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                echo 'Tous les champs sont requis.';
                return;
            }

            if ($this->userDAO->findByEmail($email)) {
                echo 'Cet e-mail est déjà utilisé.';
                return;
            }

            // Hacher le mot de passe ici, dans le contrôleur
            $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
            $user = new UserModel(0, $username, $email, $hashedPassword, new DateTime());

            if ($this->userDAO->createUser($user)) {
                echo 'Inscription réussie !';
                header('Location: /login');
                exit();
            } else {
                echo 'Erreur lors de l\'inscription.';
            }
        } else {
            include __DIR__ . '/../views/user/register.php';
        }
    }

    /**
     * Affiche le formulaire de connexion ou traite la soumission du formulaire de connexion.
     *
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user'; // Par défaut 'user'
    
            // Valider les données d'entrée
            if (empty($email) || empty($password)) {
                echo 'Veuillez remplir tous les champs.';
                return;
            }
    
            // Rechercher l'utilisateur par email
            $user = $this->userDAO->findByEmail($email);
    
            if ($user && password_verify($password, $user->getPassword_user()) && $user->getRole_user() === $role) {
                // L'utilisateur est authentifié avec succès
                session_start();
                $_SESSION['user_id'] = $user->getId_user();
                $_SESSION['user_role'] = $user->getRole_user();
    
                // Redirection en fonction du rôle de l'utilisateur
                if ($user->getRole_user() === 'admin') {
                    header('Location: /dashboard');
                } else {
                    header('Location: /profile');
                }
                exit();
            } else {
                echo 'E-mail, mot de passe ou rôle incorrect.';
            }
        } else {
            // Afficher le formulaire de connexion
            include __DIR__ . '/../views/user/login.php';
        }
    }
    
}
