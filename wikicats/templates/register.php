<?php $title = "Register"; ?>

<?php ob_start(); ?>

<main class="form-register w-100 m-auto">

    <form action="index.php?action=submitRegister" method="post">

        <h1 class="h3 mb-3 fw-normal">
            Inscris toi petit chat
            <i class="fa-solid fa-paw"></i>
        </h1>

        <div class="mb-3">
            <label for="InputPseudo" class="form-label">Pseudo</label>
            <input name="pseudo" type="text" class="form-control" id="InputPseudo">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Adresse email</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

            <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre email avec un chien.</div>
        </div>

        <div class="mb-3">
            <label for="InputPassword" class="form-label">Mot de passe</label>
            <input name="password" type="password" class="form-control" id="InputPassword">
        </div>

        <div class="mb-3">
            <label for="InputPasswordConfirm" class="form-label">Confirmer le mot de passe</label>
            <input name="passwordConfirm" type="password" class="form-control" id="InputPasswordConfirm">
        </div>

        <div class="mb-3 form-check">
            <label class="form-check-label" for="certified">Tu certifies être un chat et/ou un félin sympathique.</label>
            <input name="certified" value="true" type="checkbox" class="form-check-input" id="certified">
        </div>

        <button type="submit" class="btn btn-primary">Soumettre</button>

    </form>

</main>

<?php $content = ob_get_clean(); ?>

<?php require("./templates/layout.php"); ?>