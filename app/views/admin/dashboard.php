<?php include 'dashboard-header-and-menu.php'; ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <p>Articles</p>
                </div>
                <ul class="card-body nav nav-sidebar flex-column">
                <li><a href="/index.php?action=adminAllPosts" class="nav-link">Tous les articles</a></li>
                <li><a href="index.php?action=adminAddPost" class="nav-link">Nouvel article</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <p>Commentaires</p>
                </div>
                <ul class="card-body nav nav-sidebar flex-column">
                <li><a href="index.php?action=adminPendingComments" class="nav-link">Commentaires en attente de validation</a></li>
                <li><a href="index.php?action=adminValidatedComments" class="nav-link">Tous les commentaires publiés</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <p>Utilisateurs</p>
                </div>
            <ul class="card-body nav nav-sidebar flex-column">
              <li><a href="index.php?action=adminAllUsers" class="nav-link">Tous les utilisateurs</a></li>
            </ul>
            </div>
        </div>
    </div>

<?php include 'dashboard-scripts.php'; ?>
</body>
</html>
