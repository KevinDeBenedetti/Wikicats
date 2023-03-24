<?php

namespace Application\Model\Users;

require_once('./src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class UsersRepository 
{
    // Declare public property
    public DatabaseConnection $connection;

    // Méthode pour creér un utilisateur
    public function createUser($pseudo, $email, $password, $certified)
    {

        // Préparation de la requête pour créer un utilisateur
        $query = $this->connection->getConnection()->prepare(
            "INSERT INTO cats (pseudo, email, password, certified) VALUES (?, ?, ?, ?)"
        );
        // Exécution de la requête pour créer un utilisateur
        $query->execute([$pseudo, $email, $password, $certified]);

    }

    // Méthode pour connecter un utilisateur
    public function logintUser($email, $password) {
        // Requête pour chercher l'email dans la bdd
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM cats WHERE email = ?"
        );
        // Exécution de la requête pour connecter un utilisateur
        $query->execute([$email]);

        $result = $query->fetch();
        
        if ($query->rowCount() == 0) {
            throw new \Exception("The cat user do not exist !"); 
        } else {
            // if ($password ===  $result["password"]) {
            if (password_verify($password, $result["password"])) {
                session_start();
                $_SESSION['connecte'] = 1;
                $_SESSION['id'] = $result['id'];
                $_SESSION['pseudo'] = $result['pseudo'];
                $_SESSION['email'] = $result["email"];
            } else {
                throw new \Exception("Le mot de passe n'est pas valide.");
            }
        }
    }

    // Method to conenct a user
    public function updateUser($pseudo, $email, $password, $catId) 
    {
        // Request to modify user information
        $query = $this->connection->getConnection()->prepare(
            "UPDATE cats SET pseudo = ?, email = ?, password = ? WHERE id = ?"
        );
        // Execution of the request to connect a user
        $query->execute([$pseudo, $email, $password, $catId]);        
    }

    // Method to get user information
    public function getUserInfo($catId)
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM cats WHERE id = ?"
        );
        $query->execute([$catId]);
        $result = $query->fetch();
        return $result;
    }
}