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
     * 
     * @see accès à la bdd
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
     * 
     * @return $result tableau des topics par utilisateur
     * 
     * @see table topics 
     * 
     */    
    public function getTopicsByUser($catId)
    {

        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM topics WHERE cat_id = ? ORDER BY date_creation DESC"
        );
        $query->execute([$catId]);
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @method updateTopic @param $title, $content, $topicId
     * Modifier le topic d'un utilisateur
     * 
     * @see modifie la table topics
     * 
     */   
    public function updateTopic($title, $content, $topicId)
    {
        $query = $this->connection->getConnection()->prepare(
            "UPDATE topics SET title = ?, content = ? WHERE id = ?"
        );
        $query->execute([$title, $content, $topicId]);       
    }

    /**
     * @method deleteTopic @param $topicId
     * Supprimer le topic d'un utilisateur
     * 
     * @see supprime un topic de la table topics
     * 
     */   
    public function deleteTopic($topicId)
    {
        $query = $this->connection->getConnection()->prepare(
            "DELETE FROM topics WHERE id = ?"
        );
        $query->execute([$topicId]);       
    }

    /**
     * @method getCategories
     * Récupère toutes les catégories
     * 
     * @see retourne toutes les catégories de la table topics
     */   
    public function getCategories()
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT category FROM topics ORDER BY category ASC"
        );
        $query->execute([]);
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @method showCategory @param $category valeur de la catégorie
     * Récupérer les topics par catégorie
     * 
     * @return $result / Tableau associatif les posts de la catégorie demandée
     * 
     * @see récupérer / les topics d'une catégorie en paramètre
     */ 
    public function showCategory($category)
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM topics WHERE category = ? ORDER BY date_creation DESC"
        );
        $query->execute([$category]);
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @method getLatestTopics
     * Récupérer tous les topics par ordre de dates décroissant
     * 
     * @return $result / Tableau associatif de tous les posts par ordre décroissant
     * 
     * @see récupérer tous les topics par ordre de date décroissant
     */ 
    public function getLatestTopics()
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM topics ORDER BY date_creation DESC"
        );
        $query->execute([]);
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @method getTopic @param $topicId
     * Récupérer un topic par son id
     * 
     * @return $result / Tableau avec les informations de l'objet
     * 
     * @see réupérer un topic avec son id
     */ 
    public function getTopic($topicId)
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT * FROM topics 
            LEFT JOIN cats ON topics.cat_id = cats.id
            WHERE topics.id = ?"
        );
        $query->execute([$topicId]);
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @method addComment @param $catId, $topicId, $content
     * Ajouter un commerce
     *  
     * @see ajouter un commentaire à un topice dans la table comments
     */ 
    public function addComment($catId, $topicId, $content)
    {
        $query = $this->connection->getConnection()->prepare(
            "INSERT INTO comments (cat_id, topic_id, content) VALUES (?, ?, ?)"
        );
        $query->execute([$catId, $topicId, $content]);
    }

    /**
     * @method addComment @param $catId, $topicId, $content
     * Ajouter un commentaire
     *  
     * @see ajouter un commentaire à un topic dans la table comments
     */ 
    public function getComments($topicId)
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT comments.id, cat_id, topic_id, content, pseudo, date_creation FROM comments 
            INNER JOIN cats ON comments.cat_id = cats.id
            WHERE topic_id = ? AND parent_id IS NULL
            ORDER BY comments.date_creation DESC"
        );
        $query->execute([$topicId]);
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @method addResponse @param $catId, $topicId, $content, $commentId
     * Ajouter une réponse à un commentaire
     *  
     * @see ajouter un commentaire à un topic dans la table comments avec un parent_id correspondant au commentaire commenté
     */ 
    public function addResponse($catId, $topicId, $content, $commentId)
    {
        $query = $this->connection->getConnection()->prepare(
            "INSERT INTO comments (cat_id, topic_id, content, parent_id) VALUES (?, ?, ?, ?)"
        );
        $query->execute([$catId, $topicId, $content, $commentId]);
    }

    /**
     * @method getResponses @param $commentId / Récupère les dernières réponses à un commentaire
     * 
     * @return $result / tableau des réponses à un commentaire
     *  
     * @see récupère toutes les réponses à un commentaire en fonction de son id parent_id
     */ 
    public function getResponses($commentId)
    {
        $query = $this->connection->getConnection()->prepare(
            "SELECT comments.id, parent_id, cat_id, topic_id, content, pseudo, date_creation FROM comments 
            INNER JOIN cats ON comments.cat_id = cats.id
            WHERE topic_id = ? AND parent_id IS NOT NULL
            ORDER BY comments.date_creation DESC"
        );
        $query->execute([$commentId]);
        $result = $query->fetchAll();

        return $result;
    }
}