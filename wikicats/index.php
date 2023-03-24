<?php
/**
 * @author Kevin De Benedetti
 * 
 * Index du projet wikicats, il redirige vers les différentes pages et fonctionnalités du site.
 */
session_start();

/**
 * Appelle des controllers nécessaires pour le routeur.
 */
require_once("./src/controllers/users.php");
require_once("./src/controllers/topics.php");

/**
 * Utilisation des namespaces pour appeler les méthodes à exécuter dans le routeur.
 * 
 * @todo mise en ligne du site sur hébergeur
 */
use Application\Controllers\Topics\Topics;
use Application\Controllers\Users\Users;

try
{
    if (isset($_GET["action"]) && $_GET["action"] !== "") 
    {
        switch ($_GET["action"]) 
        {
            case "forum":
                /**
                 * @method forum() => rediriger la page forum
                 */
                (new Topics())->forum();
                break;

            case "register":
                /**
                 * @method register() => rediriger vers la page s'enregistrer
                 */
                (new Users())->register();
                break;

            case "submitRegister":
                /**
                 * @method createUser() => soumettre le formulaire d'inscription
                 */
                (new Users())->createUser();
                break;

            case "login":
                /**
                 * @method login() => rediriger vers la page se connecter
                 */
                (new Users())->login();
                break;
            
            case "logout":
                /**
                 * @method logout() => déconnecter un utilisateur
                 */
                (new Users())->logout();
                break;

            case "submitLogin":
                /**
                 * @method loginUser()=> soumettre le formulaire de connexion
                 */
                (new Users())->loginUser();
                break;

            case "account":
                /**
                 * @method account() => rediriger vers la page profil
                 */
                (new Users())->account();
                break;

            case "submitModification":
                /**
                 * @method modifyUser() => soumettre le formulaire de modification des informations de l'utilisateur
                 */
                (new Users())->modifyUser();
                break;

            case "submitTopic":
                /**
                 * @method addTopic() => Ajouter un topic
                 */
                (new Topics())->addTopic();
                break;

            case "modifyTopic":
                /**
                 * @method modifyTopic() => Modifier un topic
                 */
                (new Topics())->modifyTopic();
                break;
            
            case "deleteTopic":
                /**
                 * @method deleteTopic() => Supprimer un topic
                 */
                (new Topics())->deleteTopic();
                break;

            case "seeTopic":
                /**
                 * @method topic() => Redirige vers la page complète du topic
                 */
                (new Topics())->topic();
                break;
            
            case "addComment":
                /**
                 * @method addComment() => Ajouter un commentaire dans un topic
                 */
                (new Topics())->addComment();
                break;
            
            case "responseComment":
                /**
                 * @method addComment() => Répondre à un commentaire
                 */
                (new Topics())->responseComment();
                break;

        }
    } 
    else 
    {
        /**
         * Redirection vers la page d'accueil
         */
        require_once("./templates/homepage.php");
    }
} 
catch (Exception $e) {
    /**
     * @method getMessage() => redirgie vers la page error pour affficher les erreurs récupérées dans la classe Exception
     */
    // Gestion des erreurs
    $errorMessage = $e->getMessage();
    require('./templates/error.php');
}