<?php include 'header.php'; ?>

<div class="container">
    <!-- Article details -->
    <h2><?php 
        $str = htmlspecialchars('TITRE') ;
        //remove accents
        $str = preg_replace('/[\p{M}]/u', '', Normalizer::normalize($str, Normalizer::FORM_D));
        echo $str;
    ?></h2>
    <p>Auteur: <?= htmlspecialchars("AUTEUR") ?></p>
    <p>Dernière mise à jour: <?= htmlspecialchars("DATE") ?></p>
    <img src="" style="max-width: 600px;" alt="Image de l'article">
    <p><?= htmlspecialchars("CHAPO") ?></p>
    <p><?= htmlspecialchars("CONTENU") ?></p>
</div>

<div class="container">
    <!-- Comments -->
    <h3>Commentaires</h3>

    
</div>

<?php include 'footer.php'; ?>
