<?php $title = "Wikicats - Accueil"; ?>

<?php ob_start(); ?>

<div class="cover-container">
    <main class="px-3 text-center">
        <h1>Bienvenue sur le site Wikicats</h1>
        <p class="lead">Cher chat, tu peux dès à présent naviguer dans la page forum. Le site est toujours en cours de construction. Notamment sur la partie front, tu peux déjà t'inscrire, te connecter à ton profil, publier des topics dans les catégories définies par nos modérateurs félins. Tu pourras également intéragir avec nos compatriotes nyctalopes, par des messages dans les topics et des réponses aux messages (donc des messages dans les messages, comme dans Inception le film avec des humains).</p>
        <p class="lead">Pour toi petit curieux de passage, tu peux consulter le forum, naviguer dans les topics créés et voir les commentaires laissés par les minous de la commu.</p>
    </main>
</div>

<?php $content = ob_get_clean(); ?>

<?php require("./templates/layout.php"); ?>
