<div class="container px-4 px-lg-5 mt-5 mb-5 border p-3">
    <div class="d-flex mb-4">
        <h3 class="text-left">
            <?php 
                $str = htmlspecialchars("un titre d'article") ;
                //remove accents
                $str = preg_replace('/[\p{M}]/u', '', Normalizer::normalize($str, Normalizer::FORM_D));
                echo $str;
            ?>
            <span class="font-weight-light" style="padding-left:30px; margin-top:20px; font-size: .85rem">Cree le : DATE</span>
        </h3>
    </div>
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="d-flex gap-3">
                <img src="#" style="max-width: 200px;" alt="Image de l'article">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim porro ex hic nostrum repellat. Velit ea voluptates provident in? Magnam quod tempore consequuntur quia distinctio dolorum aspernatur, adipisci reiciendis consequatur aliquam eaque facere vel aut reprehenderit cumque soluta magni voluptatum.</p>
        </div>
        <button style="width:fit-content;"><a href=#>Lire plus...</a></button>
    </div>
</div>