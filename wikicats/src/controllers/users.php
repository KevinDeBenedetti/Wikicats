<?php

namespace Application\Controllers\Users;

require_once('./src/lib/database.php');
require_once('./src/models/users.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Users\UsersRepository;
use Application\Model\Topics\TopicsRepository;


class Users 
{

    public function account()
    {
        $catId = htmlspecialchars($_SESSION["id"]);

        // Fill out the modify user form
        $usersRepository = new usersRepository();
        $usersRepository->connection = new DatabaseConnection();
        $result = $usersRepository->getUserInfo($catId);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        $topics = $topicsRepository->getTopicsByUser($catId);

        require_once('./templates/account.php');

    }

    public function login()
    {
        // $connection = new DatabaseConnection;

        require('./templates/login.php');

    }

    public function register()
    {
        // $connection = new DatabaseConnection;

        require('./templates/register.php');

    }

    public function createUser() {

        // Verify pseudo input
        if (empty(htmlspecialchars($_POST['pseudo']))) {
            throw new \Exception("Le miaou pseudo est requis");
        } else {
            $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Verify email input  
        if (empty(htmlspecialchars($_POST['email']))) {
            throw new \Exception("Le miaou email est requis");
        } else {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        }

        // Verify password input
        if (empty(htmlspecialchars($_POST['password']))) {
            throw new \Exception("Le miaou mot de passe est requis");
        } else {
            if (htmlspecialchars($_POST['password']) === htmlspecialchars($_POST['passwordConfirm'])) {
                $password = htmlspecialchars($_POST['password']);
                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                throw new \Exception("Les miaous mots de passes ne sont pas les mêmes.");
            }

            //$password = htmlspecialchars($_POST['password']);
        }

        // Verify certified input
        if (isset($_POST['certified']) === true) {
            $certified = "1";
            var_dump($certified);
        } else {
            throw new \Exception("Tu dois être un chat !");
        }
        
        $usersRepository = new UsersRepository();

        $usersRepository->connection = new DatabaseConnection();

        $usersRepository->createUser($pseudo, $email, $password, $certified);

        // Rédirection vers la page du compte
        header("Location: ./index.php?action=login");
        exit;

    }

    public function loginUser()
    {
        
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
        $usersRepository->logintUser($email, $password);

        // require('./templates/connect.php');

        // Redirect to account page
        header("Location: ./index.php?action=account");
        exit;
    }

    public function modifyUser() 
    {
        $pseudo = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $catId = $_SESSION['id'];

        $usersRepository = new UsersRepository();
        $usersRepository->connection = new DatabaseConnection();
        $result = $usersRepository->getUserInfo($catId);
        $password = $result['password'];

        if (!empty(htmlspecialchars($_POST['password'])) && !empty(htmlspecialchars($_POST['passwordConfirm']))) {
            if (htmlspecialchars($_POST['password']) === htmlspecialchars($_POST['passwordConfirm'])) {
                // Check if password are the same
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    throw new \Exception("Les miaous mots de passes ne sont pas les mêmes.");
                }
        }

        $usersRepository->updateUser($pseudo, $email, $password, $catId);
        
        // Redirect to account page
        header("Location: ./index.php?action=account");
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?action=forum');
        exit;
    }

    
}