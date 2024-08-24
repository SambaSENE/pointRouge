<?php

namespace App\Core;

use Exception;
use PDO;
use PDOException;

/**
 * Classe Connexion
 *
 * Gère la connexion à la base de données en utilisant PDO.
 */
class Connexion
{
    /**
     * @var PDO|null $connection Instance de PDO pour la connexion à la base de données.
     */
    private static ?PDO $connection = null;

    /**
     * Établit une connexion à la base de données en utilisant PDO si elle n'existe pas déjà.
     *
     * @param array $config Tableau associatif contenant les paramètres de connexion (hôte, nom de la base, utilisateur, mot de passe).
     * @return PDO L'objet de connexion PDO.
     * 
     * @throws Exception Si la connexion à la base de données échoue.
     */
    public static function getConnexion(array $config = []): PDO
    {
        if (self::$connection === null) {
            // Vérifier si la configuration est fournie
            if (empty($config)) {
                throw new Exception('Aucune configuration de base de données fournie.');
            }

            // Construire la chaîne de connexion DSN
            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";

            try {
                // Créer une nouvelle instance PDO
                self::$connection = new PDO($dsn, $config['db_user'], $config['db_pass']);
                // Configurer le mode de gestion des erreurs sur Exception
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Lever une exception générique en cas d'erreur de connexion
                throw new Exception('Erreur de connexion : ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
