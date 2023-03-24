<?php $title = "Topic"; ?>

<?php ob_start(); ?>

<div class="container">

<!-- Topic content  -->
    <div class="w-100 m-auto">

        <div class="card">

            <div class="card-body">
                <h2 class="card-title"><?= $topic[0]['title'] ?></h2>

                <h3 class="card-title">Category : <?= $topic[0]['category'] ?></h3>

                <p class="card-text"><?= $topic[0]['content'] ?></p>

                <p class="card-text"><?= $topic[0]['date_creation'] ?></p>
            </div>

        </div>

    </div>

<!-- Comments content  -->
    <div class="w-75 m-auto mt-2">

        <div class="card bg-body-tertiary">

            <div class="card-body">
                <h3 class="card-title">Commentaires</h3>
                <p class="card-text">Voici les derniers commentaires du topic :</p>
                <?php foreach ($comments as $comment) { ?>

                <div class="card mt-1">
                    <div class="card-body">
                        <h6 class="card-title">Commentaire de : <?= $comment['pseudo'] ?> le <?= $comment['date_creation'] ?> </h6>
                        <p class="card-text"> <?= $comment['content'] ?> </p>
                    </div>
                    <!-- Ajouter une réponse à un commentaire -->
                    <div class="m-2">
                        <div class="card-body ">

                            <?php foreach ($responses as $response) { ?>
                            <?php if ($comment['id'] === $response['parent_id']) { ?>
                            <div class="card p-2 bg-info-subtle">
                                <p class="card-text">Commentaire de : <?= $response['pseudo'] ?></p>
                                <p class="card-text"><?= $response['content'] ?></p>
                                <p class="card-text">Ecrit le : <?= $response['date_creation'] ?></p>
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <?php if (isset($_SESSION) && !empty($_SESSION)) { ?>

                            <form action="index.php?action=responseComment" method="post">

                                <div class="my-3">
                                    <label for="InputContent" class="form-label">Répondre :</label>
                                    <input name="content" type="text" class="form-control" id="InputContent" placeholder="Votre réponse 👈" >
                                </div>

                                <input name="comment_id" type="hidden" value="<?= $comment['id'] ?>">
                                <input name="topic_id" type="hidden" value="<?= $topic[0]['0'] ?>">

                                <button type="submit" class="btn btn-primary" onclick="return confirm('Répondre à ce commentaire')">Répondre</button>

                            </form>

                            <?php }?>

                        </div>
                    </div>
                    <?php } ?>

                </div>

                <!-- Ajouter un commentaire -->
                <?php if (isset($_SESSION) && !empty($_SESSION)) { ?>
                <div class="card mt-4">
                    <div class="card-body">
                        <form action="index.php?action=addComment" method="post">

                            <div class="mb-3">
                                <label for="InputContent" class="form-label">Écrire un commentaire :</label>
                                <input name="content" type="text" class="form-control" id="InputContent" placeholder="Écrire son commentaire ici 👈" >
                            </div>

                            <input name="topic_id" type="hidden" value="<?= $topic[0]['0'] ?>">

                            <button type="submit" class="btn btn-primary" onclick="return confirm('Publier ce commentaire')">Publier</button>

                        </form>
                    </div>
                </div>
                <?php } ?>

            </div>

        </div>

    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require("./templates/layout.php"); ?>
