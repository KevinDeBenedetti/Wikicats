<?php
/**
 * @uses Topics => Model utilisé pour toutes les intéractions avec les topics
 */
namespace Application\Model\Topics;

/**
 * Appelle de la bdd
 */
require_once('./src/lib/database.php');

/**
 * Utilisation du namespace de la bdd
 */
use Application\Lib\Database\DatabaseConnection;

/**
 * Classe TopicsRepository
 */
class TopicsRepository
{
    /** 
     * @property $connection => propriété de la bdd
     */
    public DatabaseConnection $connection;

    /**
     * @method createTopic @param $catId, $title, $content, $category
     * Méthode pour créer un topic dans la bdd
     */
    public function createTopic($catId, $title, $content, $category)
    {
        $query = $this->connection->getConnection()->prepare(
            "INSERT INTO topics (cat_id, title, content, category) VALUES (?, ?, ?, ?)"
        );
        $query->execute([$catId, $title, $content, $category]);
    }

    /**
     * @method getTopicsByUser @param $catId
     * Méthode pour récupérer les topics d'un utilisateur
     */    
    public function getTopicsByUser($catId)
    {
        // Préparation de la requête pour créer un utilisateur
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM topics WHERE cat_id = ? ORDER BY date_creation DESC"
        );
        // Exécution de la requête pour créer un utilisateur
        $query->execute([$catId]);
        $result = $query->fetchAll();

        return $result;
    }

    // Modify a topic
    public function updateTopic($title, $content, $topicId)
    {
        // Request to modify topic information
        $query = $this->connection->getConnection()->prepare(
            "UPDATE topics SET title = ?, content = ? WHERE id = ?"
        );
        // Execution of the request to connect a topic by his id
        $query->execute([$title, $content, $topicId]);       
    }

    // Delete a topic
    public function deleteTopic($topicId)
    {
        // Request to delete topic information
        $query = $this->connection->getConnection()->prepare(
            "DELETE FROM topics WHERE id = ?"
        );
        // Execution of the request to connect a topic by his id
        $query->execute([$topicId]);       
    }

        // Get all categories
        public function getCategories()
        {
            // Request to show all categories
            $query = $this->connection->getConnection()->prepare(
                "SELECT category FROM topics ORDER BY category ASC"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([]);
            $result = $query->fetchAll();
    
            return $result;
        }

        // Get all topics of a category
        public function showCategory($category)
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "SELECT * FROM topics WHERE category = ? ORDER BY date_creation DESC"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([$category]);
            $result = $query->fetchAll();

            // print_r($result);
    
            return $result;
        }

        // Get latest topics
        public function getLatestTopics()
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "SELECT * FROM topics ORDER BY date_creation DESC"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([]);
            $result = $query->fetchAll();
    
            return $result;
        }

        // Get latest topics
        public function getTopic($topicId)
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "SELECT * FROM topics 
                LEFT JOIN cats ON topics.cat_id = cats.id
                WHERE topics.id = ?"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([$topicId]);
            $result = $query->fetchAll();
    
            return $result;
        }

        // Add a comment
        public function addComment($catId, $topicId, $content)
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "INSERT INTO comments (cat_id, topic_id, content) VALUES (?, ?, ?)"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([$catId, $topicId, $content]);
        }

        // Récupère les derniers commentaires
        public function getComments($topicId)
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "SELECT comments.id, cat_id, topic_id, content, pseudo, date_creation FROM comments 
                INNER JOIN cats ON comments.cat_id = cats.id
                WHERE topic_id = ? AND parent_id IS NULL
                ORDER BY comments.date_creation DESC"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([$topicId]);
            $result = $query->fetchAll();
    
            return $result;
        }

        // Ajouter une réponse à un commentaires dans les commentaires
        public function addResponse($catId, $topicId, $content, $commentId)
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "INSERT INTO comments (cat_id, topic_id, content, parent_id) VALUES (?, ?, ?, ?)"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([$catId, $topicId, $content, $commentId]);
        }

        // Récupère les dernières réponses de commentaires
        public function getResponses($commentId)
        {
            // Request to show all topics of a category
            $query = $this->connection->getConnection()->prepare(
                "SELECT comments.id, parent_id, cat_id, topic_id, content, pseudo, date_creation FROM comments 
                INNER JOIN cats ON comments.cat_id = cats.id
                WHERE topic_id = ? AND parent_id IS NOT NULL
                ORDER BY comments.date_creation DESC"
            );
            // Exécution de la requête pour créer un utilisateur
            $query->execute([$commentId]);
            $result = $query->fetchAll();
    
            return $result;
        }
}