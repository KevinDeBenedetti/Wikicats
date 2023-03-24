<?php
/**
 * @uses Users => Controller utilisé pour toutes les intéractions avec les users
 */
namespace Application\Controllers\Users;

/**
 * Appelle du modèle Users et de la database.
 */
require_once('./src/lib/database.php');
require_once('./src/models/users.php');
require_once('./src/models/topics.php');

/**
 * Utilisation des namespaces pour appeler les méthodes à exécuter dans le controlleur Users.
 */
use Application\Lib\Database\DatabaseConnection;
use Application\Model\Users\UsersRepository;
use Application\Model\Topics\TopicsRepository;

/**
 * Classe Users
 */
class Users 
{
    /**
     * @method account() => pour afficher les informations de l'utisateur à la connexion
     */
    public function account()
    {
        $catId = htmlspecialchars($_SESSION["id"]);

        $usersRepository = new usersRepository();
        $usersRepository->connection = new DatabaseConnection();
        $result = $usersRepository->getUserInfo($catId);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        $topics = $topicsRepository->getTopicsByUser($catId);

        require_once('./templates/account.php');
    }

    /**
     * @method login() => redirection vers la page se connecter
     */
    public function login()
    {
        require('./templates/login.php');
    }

    /**
     * @method register() => redirection vers la page se s'enregistrer
     */
    public function register()
    {
        require('./templates/register.php');

    }

    /**
     * @method register() => créer un nouvel utilisateur
     */
    public function createUser() {
        /**
         * @uses vérification des input avec les sécurités nécessaires avec hash du mot de passe et message d'erreur si tous les champs ne sont pas remplis
         */
        if (empty(htmlspecialchars($_POST['pseudo']))) {
            throw new \Exception("Le miaou pseudo est requis");
        } else {
            $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if (empty(htmlspecialchars($_POST['email']))) {
            throw new \Exception("Le miaou email est requis");
        } else {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        }
        if (empty(htmlspecialchars($_POST['password']))) {
            throw new \Exception("Le miaou mot de passe est requis");
        } else {
            if (htmlspecialchars($_POST['password']) === htmlspecialchars($_POST['passwordConfirm'])) {
                $password = htmlspecialchars($_POST['password']);
                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                throw new \Exception("Les miaous mots de passes ne sont pas les mêmes.");
            }
        }
        if (isset($_POST['certified']) === true) {
            $certified = "1";
            var_dump($certified);
        } else {
            throw new \Exception("Tu dois être un chat !");
        }
        
        $usersRepository = new UsersRepository();

        $usersRepository->connection = new DatabaseConnection();

        /**
         * @method createUser @param $pseudo, $email, $password, $certified
         * Envoie des champs pour créer l'utilisateur dans la bdd
         */
        $usersRepository->createUser($pseudo, $email, $password, $certified);

        header("Location: ./index.php?action=login");
        exit;
    }

    /**
     * @method register() => connecter un utilisateur
     */
    public function loginUser()
    {
        /**
         * @uses vérification des input avec les sécurités nécessaires et message d'erreur si tous les champs ne sont pas remplis
         */
        if (empty(htmlspecialchars($_POST['email']))) {
            throw new \Exception("Le miaou email est requis");
        } else {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        }
        if (empty(htmlspecialchars($_POST['password']))) {
            throw new \Exception("Le miaou mot de passe est requis");
        } else {
            $password = htmlspecialchars($_POST['password']);
        }

        $usersRepository = new UsersRepository();
        $usersRepository->connection = new DatabaseConnection();

        /**
         * @method logintUser @param $email, $password
         * Envoie des champs au model pour connecter l'utilisateur dans la bdd
         */
        $usersRepository->logintUser($email, $password);

        header("Location: ./index.php?action=account");
        exit;
    }

    /**
     * @method modifyUser() => modifier un utilisateur
     */
    public function modifyUser() 
    {
        /**
         * @uses vérification des input avec les sécurités nécessaires et on récupère l'id de l'utilisateur connecté
         */
        $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $catId = $_SESSION['id'];

        $usersRepository = new UsersRepository();
        $usersRepository->connection = new DatabaseConnection();

        /**
         * @method getUserInfo @param $catId
         * Envoie des champs au model pour vérifier si le mot de passe correspond à la base de données
         */
        $result = $usersRepository->getUserInfo($catId);
        $password = $result['password'];

        /**
         * @uses vérification du changement de mot de passe
         */
        if (!empty(htmlspecialchars($_POST['password'])) && !empty(htmlspecialchars($_POST['passwordConfirm']))) {
            if (htmlspecialchars($_POST['password']) === htmlspecialchars($_POST['passwordConfirm'])) {
                // Check if password are the same
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    throw new \Exception("Les miaous mots de passes ne sont pas les mêmes.");
                }
        }

        /**
         * @method updateUser @param $pseudo, $email, $password, $catId
         * Envoie des champs au model pour modifier les informations de l'utilisateur
         */
        $usersRepository->updateUser($pseudo, $email, $password, $catId);
        
        header("Location: ./index.php?action=account");
        exit;
    }

    /**
     * @method logout() => déconnecter un utilisateur
     */
    public function logout()
    {
        session_destroy();
        header('Location: index.php?action=forum');
        exit;
    }

    
}