<?php $title = "Account"; ?>

<?php ob_start(); ?>

<h1 class="h1 mb-3 fw-normal text-center">
      Bienvenue <?= $_SESSION['pseudo'] ?>
      <i class="fa-solid fa-paw"></i>
</h1>

<div class="form-register w-100 m-auto">

    <form action="index.php?action=submitModification" method="post">

        <h2 class="h3 mb-3 fw-normal">
            Modifier les informations personnelles
        </h2>

        <div class="mb-3">
            <label for="InputPseudo" class="form-label">Pseudo</label>
            <input name="pseudo" type="text" class="form-control" id="InputPseudo" value="<?= $result["pseudo"] ?>">
        </div>

        <div class="mb-3">
            <label for="inputEmail" class="form-label">Adresse email</label>
            <input name="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" value="<?= $result["email"] ?>">
        </div>

        <div class="mb-3">
            <label for="InputPassword" class="form-label">Mot de passe</label>
            <input name="password" type="password" class="form-control" id="InputPassword">
        </div>

        <div class="mb-3">
            <label for="InputPasswordConfirm" class="form-label">Confirmer le mot de passe</label>
            <input name="passwordConfirm" type="password" class="form-control" id="InputPasswordConfirm">
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>

    </form>

</div>

<div class="form-register w-100 m-auto">

    <form action="index.php?action=submitTopic" method="post">

        <h2 class="h3 mb-3 fw-normal">
            Créer un topic
        </h2>

        <div class="mb-3">
            <label for="InputTitle" class="form-label">Titre</label>
            <input name="title" type="text" class="form-control" id="InputTitle" placeholder="Votre miaou titre 🙀">
        </div>

        <div class="mb-3">
            <label for="InputContent" class="form-label">Contenu</label>
            <input name="content" type="text" class="form-control" id="InputContent" placeholder="Ici le contenu mon pti minou 📝">
        </div>

        <div class="mb-3">
            <label for="InputCategory" class="form-label">Choisir la catégorie</label>
            <select name="category" class="form-select" id="InputCategory">
                <option selected>Choisir une catégorie</option>
                <option value="Yoga">Yoga</option>
                <option value="Santé">Santé</option>
                <option value="Toilettage">Toilettage</option>
                <option value="Chasse">Chasse</option>
                <option value="Rencontres libertines">Rencontres libertines</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>

    </form>

</div>

<!-- Affichage des topics de l'utilisateur -->
<div class="container">
    <!-- Afficher les derniers topics par date -->
    <div class="mt-4">
    <h2 class="h2 mb-2">
        Vos topics publiés :
    </h2>
    <!-- Listes des derniers topics -->
    <div class="w-100 mt-3">
            <?php foreach ($topics as $topic) { ?>
                <ol class="list-group my-3">
                    <li class="list-group-item d-flex justify-content-between align-items-start">

                        <div class="ms-2 me-auto">
                            <form action="index.php?action=modifyTopic" method="post">
                                <h5 class="card-title fw-bold fs-4"><?= $topic['title'] ?></h5>
                                <h6 class="card-title">Catégorie : <?= $topic['category'] ?></h6>

                                <div class="mb-3">
                                <label for="InputTitle" class="form-label fst-italic">Écrire un nouveau titre :</label>
                                <input name="title" type="text" class="form-control" id="InputTitle" placeholder="<?= $topic['title'] ?>" value="<?= $topic['title'] ?>">
                                </div>

                                <p class="card-text"><?= $topic['content'] ?></p>

                                <div class="mb-3">
                                <label for="InputContent" class="form-label">Écrire un nouveau contenu :</label>
                                <input name="content" type="text" class="form-control" id="InputContent" placeholder="<?= $topic['content'] ?>" value="<?= $topic['content'] ?>" > 
                                </div>

                                <input name="topic_id" type="hidden" value="<?= $topic['id'] ?>">

                                <button type="submit" class="btn btn-primary " onclick="return confirm('Are you sure you want to edit the topic?')">Modifier</button>
                            </form>
                        </div>

                        <div class="btn-group">
                            <form action="index.php?action=deleteTopic" method="post">

                                <input name="topic_id" type="hidden" value="<?= $topic['id'] ?>">
                                <button class="btn btn-sm btn-outline-secondary" type="submit" onclick="return confirm('Are you sure you want to delete the topic ?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>

                            </form>
                        </div>

                        <!-- <span class="badge bg-primary rounded-pill">14</span> -->
                    </li>
                </ol>
            <?php } ?>     
        </div>

    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require("./templates/layout.php"); ?>