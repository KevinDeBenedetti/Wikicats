<?php

session_start();

// Controllers appelés
require_once("./src/controllers/users.php");
require_once("./src/controllers/topics.php");
require_once("./src/controllers/users.php");

// Namespaces
use Application\Controllers\Topics\Topics;
use Application\Controllers\Users\Users;

try
{
    if (isset($_GET["action"]) && $_GET["action"] !== "") 
    {
        switch ($_GET["action"]) 
        {
            case "forum":
                (new Topics())->forum();
                break;

            case "register":
                (new Users())->register();
                break;

            case "submitRegister":
                (new Users())->createUser();
                break;

            case "login":
                (new Users())->login();
                break;
            
            case "logout":
                (new Users())->logout();
                break;

            case "submitLogin":
                (new Users())->loginUser();
                break;

            case "account":
                (new Users())->account();
                // (new Topics())->account();
                break;

            case "submitModification":
                (new Users())->modifyUser();
                break;

            case "submitTopic":
                (new Topics())->addTopic();
                break;

            case "modifyTopic":
                (new Topics())->modifyTopic();
                break;
            
            case "deleteTopic":
                (new Topics())->deleteTopic();
                break;

            case "seeTopic":
                (new Topics())->topic();
                break;
            
            case "addComment":
                (new Topics())->addComment();
                break;
            
            case "responseComment":
                (new Topics())->responseComment();
                break;

        }
    } 
    else 
    {
        require_once("./templates/homepage.php");
    }
} 
catch (Exception $e) {
    // Gestion des erreurs
    $errorMessage = $e->getMessage();
    require('./templates/error.php');
}