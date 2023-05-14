<?php $title = "Wikicats - Connexion"; ?>

<?php ob_start(); ?>

<main class="form-signin w-100 m-auto text-center">
  <form action="index.php?action=submitLogin" method="post">
    
    <h1 class="h3 mb-3 fw-normal">
      Connexion
      <i class="fa-solid fa-paw"></i>
    </h1>

    <div class="form-floating">

      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="meow@wiskas.cat">
      <label for="floatingInput">Adresse e-mail 😺</label>

    </div>
    <div class="form-floating py-2">

      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Mot de passe 🐈‍⬛</label>

    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Se connecter</button>
    <p class="mt-5 mb-3 text-muted">© MeowCompany - 2023</p>
  </form>
</main>

<?php $content = ob_get_clean(); ?>

<?php require("./templates/layout.php"); ?>