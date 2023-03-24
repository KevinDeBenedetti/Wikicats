<?php
/**
 * @uses Users => Model utilisé pour toutes les intéractions avec les Users
 */
namespace Application\Model\Users;

/**
 * Appelle de la bdd
 */
require_once('./src/lib/database.php');

/**
 * Utilisation du namespace de la bdd
 */
use Application\Lib\Database\DatabaseConnection;

/**
 * Classe UsersRepository
 */
class UsersRepository 
{
    /** 
     * @property $connection => propriété de la bdd
     * 
     * @see accès à la bdd
     */
    public DatabaseConnection $connection;

    /**
     * @method createUser @param $pseudo, $email, $password, $certified / Créer un utilisateur
     * 
     * @see créer un utilisateur
     */ 
    public function createUser($pseudo, $email, $password, $certified)
    {
        $query = $this->connection->getConnection()->prepare(
            "INSERT INTO cats (pseudo, email, password, certified) VALUES (?, ?, ?, ?)"
        );
        $query->execute([$pseudo, $email, $password, $certified]);
    }

    /**
     * @method logintUser @param $email, $password / Connecter un utilisateur
     * 
     * @return $result / mot de passe utilisateur pour le vérifier
     * 
     * @return $_SESSION si l'utilisateur existe et le redirige vers la page profil
     * 
     * @see Connecter un utilisateur et le rediriger vers la page profil
     */ 
    public function logintUser($email, $password) {
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM cats WHERE email = ?"
        );
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

    /**
     * @method updateUser @param $pseudo, $email, $password, $catId / Modifier les informations d'un utilisateur
     * 
     * @see Modifier les informations d'un utilisateur et rediriger vers la page profil
     */ 
    public function updateUser($pseudo, $email, $password, $catId) 
    {
        $query = $this->connection->getConnection()->prepare(
            "UPDATE cats SET pseudo = ?, email = ?, password = ? WHERE id = ?"
        );
        $query->execute([$pseudo, $email, $password, $catId]);        
    }

    // Method to get user information
    /**
     * @method getUserInfo @param $catId / Récupérer les informations d'un utilisateur
     * 
     * @see Récupérer les informations d'un utilisateur
     */ 
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