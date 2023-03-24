<?php

namespace Application\Controllers\Topics;

require_once('./src/lib/database.php');
require_once('./src/models/topics.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Topics\TopicsRepository;

class Topics 
{

    // Method to add a topic by an identify user 
    public function addTopic()
    {
        $catId = $_SESSION['id'];

        // Verify title input
        if (empty(htmlspecialchars($_POST['title']))) {
            throw new \Exception("The meow topic title is required");
        } else {
            // Security for the input
            $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
            // Modify the value to read it in BDD
            $title = html_entity_decode($title);
        }

        // Verify conntent input
        if (empty(htmlspecialchars($_POST['content']))) {
            throw new \Exception("The meow topic title is required");
        } else {
            // Security for the input
            $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
            // Modify the value to read it in BDD
            $content = html_entity_decode($content);
        }

        // Verify conntent input category    
        if (empty(htmlspecialchars($_POST['category']))) {
            throw new \Exception("The meow topic title is required");
        } else {
            $category = filter_var($_POST['category'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $topicsRepository = new TopicsRepository();

        $topicsRepository->connection = new DatabaseConnection();

        $topicsRepository->createTopic($catId, $title, $content, $category);

        // Redirect to account page
        header("Location: ./index.php?action=account");
        exit;
    }

    // Method to modify a topic by an identify user
    public function modifyTopic()
    {
        $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $title = html_entity_decode($title);

        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
        $content = html_entity_decode($content);

        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);
        // $category = filter_var($_POST['category'], FILTER_SANITIZE_SPECIAL_CHARS);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        
        $topicsRepository->updateTopic($title, $content, $topicId);
        
        // Redirect to account page
        header("Location: ./index.php?action=account");
        exit;
    }

    // Method to delete a topic
    public function deleteTopic()
    {
        // Use POST method to get the topic id
        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        
        $topicsRepository->deleteTopic($topicId);
        
        // Redirect to account page
        header("Location: ./index.php?action=account");
        exit;
    }

    // Method to show forum page
    public function forum()
    {
        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();

        // Show all categories
        $categories = $topicsRepository->getCategories();

        // print_r($categories);

        foreach ($categories as $category) {

            $categoryTopics[$category['category']] = $topicsRepository->showCategory($category['category']);

            //print_r($categoryTopics);
        }

        // Show latest topics
        $latestTopics = $topicsRepository->getLatestTopics();
        
        require_once('./templates/forum.php');
    }

    // Method to show a topic
    public function topic()
    {
        // Use POST method to get the topic id

        if (empty($_POST['topic_id'])) {
            $topicId = $_GET['topic_id']; 
        } else {
            $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        // Show all categories
        $topic = $topicsRepository->getTopic($topicId);

        $comments = $topicsRepository->getComments($topicId);
        
        $responses = $topicsRepository->getResponses($topicId);

        require_once('./templates/topic.php');

    }

    // Method to add a comment
    public function addComment()
    {
        // Use POST method to get the topic id
        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);

        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);

        $catId = $_SESSION['id'];

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        // Show all categories
        $topicsRepository->addComment($catId, $topicId, $content);

        // Redirect to account page
        header("Location: ./index.php?action=seeTopic&topic_id={$topicId}");
        exit;
    }

    // Méthode pour répondre à un commentaire
    public function responseComment()
    {
        // Use POST method to get the topic id
        $topicId = filter_var($_POST['topic_id'], FILTER_SANITIZE_NUMBER_INT);

        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);

        $catId = $_SESSION['id'];

        $commentId = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);

        $topicsRepository = new TopicsRepository();
        $topicsRepository->connection = new DatabaseConnection();
        // Appelle de la méthode pour ajouter le commentaire
        $topicsRepository->addResponse($catId, $topicId, $content, $commentId);


        // Redirect to account page
        header("Location: ./index.php?action=seeTopic&topic_id={$topicId}");
        exit;
    }
}