<?php $title = "Wikicats - Erreur"; ?>

<?php ob_start(); ?>

<nav class="d-flex justify-content-center align-items-center position-sticky">
    <h2 class="text-white">Erreur</h2>
</nav>

<?php $nav = ob_get_clean(); ?>

<?php ob_start(); ?>
<h1>Wikicats Erreur</h1>
<p>Détail de l'erreur : <?= $errorMessage ?></p>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>