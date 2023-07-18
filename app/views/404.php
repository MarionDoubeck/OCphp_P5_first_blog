<?php
use App\services\Helpers;
$helper = new Helpers;
$helper->renderView('app/views/header.php',[]);
?>

<div class="container">
<h2>Erreur 404 : Cette page n'existe pas</h2>
</div>
<?php $helper->renderView('app/views/footer.php',[]); ?>