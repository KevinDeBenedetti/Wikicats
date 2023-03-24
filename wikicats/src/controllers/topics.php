<?php
/**
 * @uses Topics => Controller utilisé pour toutes les intéractions avec les topics
 */
namespace Application\Controllers\Topics;

/**
 * Appelle du modèle Topics et de la database.
 */
require_once('./src/lib/database.php');
require_once('./src/models/topics.php');

/**
 * Utilisation des namespaces pour appeler les méthodes à exécuter dans le controlleur Topics.
 */
use Application\Lib\Database\DatabaseConnection;
use Application\Model\Topics\TopicsRepository;

/**
 * Classe Topics
 */
class Topics 
{

    /**
     * @method addTopic() => Pour créer un topic
     *          
     * @uses vérification des input avec les sécurités nécessaires et message d'erreur si tous les champs ne sont pas remplis
     * 
     * @method createTopic @param $catId, $title, $content, $category / Envoie des champs au model pour créer le topic
     */
    public function addTopic()
    {
        $catId = $_SESSION['id'];

        if (empty(htmlspecialchars($_POST['title']))) {
            throw new \Exception("The meow topic title is required");
        } else {
            $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
            $title = html_entity_decode($title);
        }
        if (empty(htmlspecialchars($_POST['content']))) {
            throw new \Exception("The meow topic title is required");
        } else {
            $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
            $content = html_entity_decode($content);
        }
        if (empty(htmlspecialchars($_POST['category']))) {
            throw new \Exception("The meow topic title is required");
        } else {
            $category = filter_var($_POST['category'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        $topicsRepository->createTopic($catId, $title, $content, $category);

        header("Location: ./index.php?action=account");
        exit;
    }

    /**
     * @method modifyTopic() => Pour modifier un topic
     * 
     * @uses vérification des input avec les sécurités nécessaires
     * 
     * @method updateTopic @param $title, $content, $topicId / Envoie des champs au model pour modifier le topic
     */
    public function modifyTopic()
    {
        $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $title = html_entity_decode($title);

        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
        $content = html_entity_decode($content);

        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();

        $topicsRepository->updateTopic($title, $content, $topicId);
        
        header("Location: ./index.php?action=account");
        exit;
    }

    /**
     * @method deleteTopic() => Pour supprimer un topic
     * 
     * @uses vérification de l'input avec les sécurités nécessaires
     * 
     * @method deleteTopic @param $topicId / Envoie de l'id du topic à supprimer
     */
    public function deleteTopic()
    {
        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        
        $topicsRepository->deleteTopic($topicId);
        
        header("Location: ./index.php?action=account");
        exit;
    }

    /**
     * @method forum() => Affichage de la page forum
     * 
     * @method getCategories() => Récupérer toutes les catégories de topics
     * 
     * @method showCategory() => Afficher les topics par catéagorie en créant des tableaux associatifs par catégorie pour renvoyer les informations sur la page
     * 
     * @param $category['category']
     * 
     * @method getLatestTopics() => Récupérer les derniers topics par catégories
     */    
    public function forum()
    {
        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        
        $categories = $topicsRepository->getCategories();

        foreach ($categories as $category) {
            $categoryTopics[$category['category']] = $topicsRepository->showCategory($category['category']);
        }
   
        $latestTopics = $topicsRepository->getLatestTopics();
        
        require_once('./templates/forum.php');
    }

    /**
     * @method topic() => Affichage de la page du topic sélectionné
     * 
     * @uses vérifier si le topic_id est bien présent et le sélectionner
     * 
     * @method getTopic @param $topicId / Récupère les bonnes informations du topic
     * 
     * @return $topic
     * 
     * @method getComments @param $topicId / Récupère les commentaires du topic
     * 
     * @return $comments
     * 
     * @method getResponses @param $topicId / Récupère les réponses des commentaires du topic
     * 
     * @return $responses
     */    
    public function topic()
    {
        if (empty($_POST['topic_id'])) {
            $topicId = $_GET['topic_id']; 
        } else {
            $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();

        $topic = $topicsRepository->getTopic($topicId);

        $comments = $topicsRepository->getComments($topicId);

        $responses = $topicsRepository->getResponses($topicId);

        require_once('./templates/topic.php');
    }

    /**
     * @method addComment() => Ajouter un commentaire
     * 
     * @uses récupérer et filter les données
     * 
     * @method addComment @param $catId, $topicId, $content / Ajoute un commentaire
     */    
    public function addComment()
    {
        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);

        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);

        $catId = $_SESSION['id'];

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
             
        $topicsRepository->addComment($catId, $topicId, $content);

        header("Location: ./index.php?action=seeTopic&topic_id={$topicId}");
        exit;
    }

    /**
     * @method responseComment() => Répondre à un commentaire
     * 
     * @uses récupérer et filtrer 
     * 
     * @method $_POST @param $topicID, $content, $catId, $commentId
     * 
     * @method addResponse @param $catId, $topicId, $content, $commentId
     */ 
    public function responseComment()
    {
        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
        $catId = $_SESSION['id'];
        $commentId = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();

        $topicsRepository->addResponse($catId, $topicId, $content, $commentId);

        header("Location: ./index.php?action=seeTopic&topic_id={$topicId}");
        exit;
    }
}