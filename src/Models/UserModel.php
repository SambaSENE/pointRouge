<?php

namespace App\Models;

use DateTime;

/**
 * Class UserModel
 *
 * Modèle représentant un utilisateur dans l'application.
 */
class UserModel
{
    /**
     * @var int $id_user L'identifiant unique de l'utilisateur.
     */
    private int $id_user;

    /**
     * @var string $username Le nom d'utilisateur.
     */
    private string $username;

    /**
     * @var string $email_user L'adresse e-mail de l'utilisateur.
     */
    private string $email_user;

    /**
     * @var string $password_user Le mot de passe de l'utilisateur.
     */
    private string $password_user;

    /**
     * @var DateTime $create_at La date de création de l'utilisateur.
     */
    private DateTime $create_at;

    private string $role_user;
    /**
     * Constructeur de la classe UserModel.
     *
     * @param int $id_user L'identifiant unique de l'utilisateur.
     * @param string $username Le nom d'utilisateur.
     * @param string $email_user L'adresse e-mail de l'utilisateur.
     * @param string $password_user Le mot de passe de l'utilisateur.
     * @param DateTime $create_at La date de création de l'utilisateur.
     * @param string $role_user La date de création de l'utilisateur.
     */
    public function __construct(int $id_user, string $username, string $email_user, string $password_user, DateTime $create_at , string $role_user)
    {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->email_user = $email_user;
        $this->password_user = $password_user;
        $this->create_at = $create_at;
        $this->role_user = $role_user;
        
    }


    /**
     * Get $id_user L'identifiant unique de l'utilisateur.
     *
     * @return  int
     */ 
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set $id_user L'identifiant unique de l'utilisateur.
     *
     * @param  int  $id_user  $id_user L'identifiant unique de l'utilisateur.
     *
     * @return  self
     */ 
    public function setId_user(int $id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get $username Le nom d'utilisateur.
     *
     * @return  string
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set $username Le nom d'utilisateur.
     *
     * @param  string  $username  $username Le nom d'utilisateur.
     *
     * @return  self
     */ 
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get $email_user L'adresse e-mail de l'utilisateur.
     *
     * @return  string
     */ 
    public function getEmail_user()
    {
        return $this->email_user;
    }

    /**
     * Set $email_user L'adresse e-mail de l'utilisateur.
     *
     * @param  string  $email_user  $email_user L'adresse e-mail de l'utilisateur.
     *
     * @return  self
     */ 
    public function setEmail_user(string $email_user)
    {
        $this->email_user = $email_user;

        return $this;
    }

    /**
     * Get $password_user Le mot de passe de l'utilisateur.
     *
     * @return  string
     */ 
    public function getPassword_user()
    {
        return $this->password_user;
    }

    /**
     * Set $password_user Le mot de passe de l'utilisateur.
     *
     * @param  string  $password_user  $password_user Le mot de passe de l'utilisateur.
     *
     * @return  self
     */ 
    public function setPassword_user(string $password_user)
    {
        $this->password_user = $password_user ;

        return $this;
    }

    /**
     * Get $create_at La date de création de l'utilisateur.
     *
     * @return  DateTime
     */ 
    public function getCreate_at()
    {
        return $this->create_at;
    }

    /**
     * Set $create_at La date de création de l'utilisateur.
     *
     * @param  DateTime  $create_at  $create_at La date de création de l'utilisateur.
     *
     * @return  self
     */ 
    public function setCreate_at(DateTime $create_at)
    {
        $this->create_at = $create_at;

        return $this;
    }

    /**
     * Get the value of role_user
     */ 
    public function getRole_user()
    {
        return $this->role_user;
    }

    /**
     * Set the value of role_user
     *
     * @return  self
     */ 
    public function setRole_user($role_user)
    {
        $this->role_user = $role_user;

        return $this;
    }
}
