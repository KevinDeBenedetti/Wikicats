<?php $title = "Forum"; ?>

<?php ob_start(); ?>

<h1 class="h1 mb-3 fw-normal text-center">
      Bienvenue sur Wikicats
      <i class="fa-solid fa-paw"></i>
</h1>

<div>
    <h2 class="h2 mb-2 text-center">
        Catégories du forum
    </h2>

    <!-- Nav bar des catégories -->
    <div class="btn-group w-100" role="group" aria-label="Basic example">

        <?php $categoryKeys = array_keys($categoryTopics); ?>

        <?php foreach ($categoryKeys as $category) { ?>
        <a href="#<?= $category ?>" type="button" class="btn btn-outline-primary"><?= $category ?></a>
        <?php }?>

    </div>

    <!-- Afficher les derniers topics par date -->
    <div class="mt-4">
        <h2 class="h2 mb-2">
            Derniers topics publiés
        </h2>
        <!-- Listes des derniers topics -->
        <div class="w-100 mt-2">
            <?php foreach ($latestTopics as $latestTopic) { ?>
                <ol class="list-group my-1">
                    <li class="list-group-item d-flex justify-content-between align-items-start">

                        <div class="ms-2 me-auto">

                            <div class="fw-bold"><?= $latestTopic['title'] ?>
                            </div>
                            <p class="fw-light card-text">Catégorie : <?= $latestTopic['category'] ?> - Créé le <?= $latestTopic['date_creation'] ?></p>

                        </div>

                        <form action="index.php?action=seeTopic" method="post" class="m-3">

                            <input name="topic_id" type="hidden" value="<?= $latestTopic['id'] ?>">

                            <input name="cat_id" type="hidden" value="<?= $latestTopic['cat_id'] ?>">

                            <button type="submit" class="btn btn-primary">Voir plus</button>
                        </form>

                        <!-- <span class="badge bg-primary rounded-pill">14</span> -->
                    </li>
                </ol>
            <?php } ?>     
        </div>

    </div>

    <!-- Afficher chaque catégorie -->


    <div class="mt-4">

        <?php foreach ($categoryKeys as $category) { ?>
        <h2 id="<?= $category ?>" class="text-capitalize mt-4"><?= $category ?></h2>

        <?php foreach ($categoryTopics as $categoryTopic) {
                    foreach ($categoryTopic as $topic) {
                        if ($category == $topic['category']) {
        ?>

        <div class="w-100 mt-2">

            <ol class="list-group my-1">

                <li class="list-group-item d-flex justify-content-between align-items-start">

                <div class="ms-2 me-auto">

                    <div class="fw-bold" ><?= $topic['title'] ?></div>
                    <p class="fw-light card-text">Date de création : <?= $topic['date_creation'] ?></p>

                </div>

                <form action="index.php?action=seeTopic" method="post" class="m-3">

                <input name="topic_id" type="hidden" value="<?= $topic['id'] ?>">

                <input name="cat_id" type="hidden" value="<?= $topic['cat_id'] ?>">

                <button type="submit" class="btn btn-primary">Voir plus</button>
                </form>

                <!-- Badge avec le nombre de commentaires -->
                <!-- <span class="badge bg-primary rounded-pill">14</span> -->

                </li>
            </ol>
        </div>
        <?php } ; 
            } ;
        } ;
            ?>
        <?php } ; ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require("./templates/layout.php"); ?>


