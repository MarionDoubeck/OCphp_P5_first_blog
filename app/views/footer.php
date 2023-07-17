<?php use App\services\Session;?>
</main>
</div><!-- .container -->

<footer class="border-top">
    <div class="container px-4 px-lg-5 list-inline text-center" style="margin-bottom:20px">
        <?php if (Session::isParamSet('username') === TRUE) : ?>
            <p>Vous êtes connecté en tant que : <?= htmlspecialchars(Session::get('username')) ?></p>
            <?php if (Session::get('role') === "admin") : ?>
                <a href="index.php?action=administration" class="list-inline-item" >Administration</a>
            <?php endif; ?>
            <a href="index.php?action=logout" class="list-inline-item">Déconnexion</a>
        <?php else : ?>
            <a href="index.php?action=register" class="list-inline-item">S'enregistrer</a>
            <a href="index.php?action=login" class="list-inline-item">Se connecter</a>
        <?php endif; ?>
    </div><!-- .container -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="https://www.linkedin.com/in/marion-doubeck-220884/" target="_blank">
                        <span class="fa-stack fa-lg">
                            <svg class="svg-inline--fa fa-circle fa-stack-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512z"></path></svg>
                            <svg class="svg-inline--fa fa-linkedin-in fa-stack-1x fa-inverse" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 63.7v384.6C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32V63.7c0-17.2-14.4-31.7-32-31.7zM135.5 416H69V202.3h66.5V416zm-33.2-243c-21.6 0-39.1-17.5-39.1-39.1c0-21.6 17.5-39.1 39.1-39.1c21.6 0 39.1 17.5 39.1 39.1c0 21.6-17.5 39.1-39.1 39.1zm281.6 243h-66.5V309c0-24.6-8.4-41.3-29.4-41.3c-16 0-25.5 10.8-29.7 21.2c-1.5 3.6-1.8 8.6-1.8 13.7v112.6h-66.5c.9-191.3 0-211.5 0-285.9h66.5v40.5c8.8-13.6 24.6-33 59.7-33c43.5 0 76.1 28.4 76.1 89.7V416z"></path></svg>
                        </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com/profile.php?id=100093222172907" target="_blank">
                            <span class="fa-stack fa-lg">
                                <svg class="svg-inline--fa fa-circle fa-stack-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512z"></path></svg><!-- <i class="fas fa-circle fa-stack-2x"></i> Font Awesome fontawesome.com -->
                                <svg class="svg-inline--fa fa-facebook-f fa-stack-1x fa-inverse" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg><!-- <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i> Font Awesome fontawesome.com -->
                            </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://github.com/MarionDoubeck" target="_blank">
                            <span class="fa-stack fa-lg">
                                <svg class="svg-inline--fa fa-circle fa-stack-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512z"></path></svg><!-- <i class="fas fa-circle fa-stack-2x"></i> Font Awesome fontawesome.com -->
                                <svg class="svg-inline--fa fa-github fa-stack-1x fa-inverse" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" data-fa-i2svg=""><path fill="currentColor" d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path></svg><!-- <i class="fab fa-github fa-stack-1x fa-inverse"></i> Font Awesome fontawesome.com -->
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div><!-- .container -->
</footer>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../public/JavaScript/scripts.js"></script>
</body>
</html>