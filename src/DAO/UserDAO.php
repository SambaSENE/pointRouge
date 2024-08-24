<?php

namespace App\DAO;

use App\Core\Connexion;
use App\Models\UserModel;
use DateTime;
use PDO;

class UserDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../Core/Config.php';
        // Obtenir la connexion de PDO à la base de données
        $this->pdo = Connexion::getConnexion($config);
    }

    /**
     * Récupère tous les utilisateurs de la base de données.
     *
     * @return array Tableau d'objets UserModel.
     */
    public function getAllUsers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->mapToUser($row);
        }

        return $users;
    }

    /**
     * Récupère un utilisateur par son ID.
     *
     * @param integer $id L'identifiant de l'utilisateur.
     * @return UserModel|null L'objet UserModel ou null si non trouvé.
     */
    public function findById(int $id): ?UserModel
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id_user = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->mapToUser($row);
        }

        return null;
    }
    public function findByUsername(string $username): ?UserModel
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return $this->mapToUser($row);
        }
    
        return null;
    }
    
    /**
     * Crée un nouvel utilisateur dans la base de données.
     *
     * @param UserModel $user L'objet UserModel à créer.
     * @return bool True si l'utilisateur est créé avec succès, False sinon.
     */
    public function createUser(UserModel $user): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email_user, password_user, create_at) VALUES (:username, :email_user, :password_user, :create_at)");

        return $stmt->execute([
            'username' => $user->getUsername(),
            'email_user' => $user->getEmail_user(),
            'password_user' => $user->getPassword_user(),
            'create_at' => $user->getCreate_at()->format('Y-m-d')
        ]);
    }

    /**
     * Met à jour les informations d'un utilisateur existant.
     *
     * @param UserModel $user L'objet UserModel à mettre à jour.
     * @return bool True si la mise à jour est réussie, False sinon.
     */
    public function updateUser(UserModel $user): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET username = :username, email_user = :email_user, password_user = :password_user, create_at = :create_at WHERE id_user = :id_user");

        return $stmt->execute([
            'username' => $user->getUsername(),
            'email_user' => $user->getEmail_user(),
            'password_user' => $user->getPassword_user(),
            'create_at' => $user->getCreate_at()->format('Y-m-d'),
            'id_user' => $user->getId_user()
        ]);
    }

    /**
     * Supprime un utilisateur par son ID.
     *
     * @param int $id L'identifiant de l'utilisateur.
     * @return bool True si la suppression est réussie, False sinon.
     */
    public function deleteUser(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id_user = :id");

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Convertit un tableau associatif en objet UserModel.
     *
     * @param array $row Les données de l'utilisateur sous forme de tableau associatif.
     * @return UserModel L'objet UserModel correspondant.
     * @throws \Exception Si la conversion de la date échoue.
     */
    private function mapToUser(array $row): UserModel
    {
        return new UserModel(
            $row['id_user'],
            $row['username'],
            $row['email_user'],
            $row['password_user'],
            new DateTime($row['create_at']),
            $row['role_user']
        );
    }

    /**
     * Récupère un utilisateur par son adresse e-mail.
     *
     * @param string $email_user L'adresse e-mail de l'utilisateur.
     * @return UserModel|null L'objet UserModel correspondant ou null si aucun utilisateur n'est trouvé.
     */
    public function findByEmail(string $email_user): ?UserModel
    {
        // Préparer la requête SQL pour rechercher un utilisateur par e-mail
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email_user = :email_user");

        // Exécuter la requête avec le paramètre d'e-mail
        $stmt->execute(['email_user' => $email_user]);

        // Récupérer le résultat de la requête sous forme de tableau associatif
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un utilisateur a été trouvé
        if ($row) {
            // Mapper les données en un objet UserModel et le retourner
            return $this->mapToUser($row);
        }

        // Retourner null si aucun utilisateur n'a été trouvé
        return null;
    }
}
