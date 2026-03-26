<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB - Galaxy Swiss Bourdin<?php echo isset($titre_page) ? ' | ' . $titre_page : ''; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS personnalisé -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-capsule"></i> GSB
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action ?? '') == 'accueil' ? 'active' : ''; ?>"
                           href="index.php">
                           <i class="bi bi-house-door"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action ?? '') == 'medicaments' || ($action ?? '') == 'detail_medicament' ? 'active' : ''; ?>"
                           href="index.php?action=medicaments">
                           <i class="bi bi-capsule-pill"></i> Médicaments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action ?? '') == 'activites' || ($action ?? '') == 'detail_activite' ? 'active' : ''; ?>"
                           href="index.php?action=activites">
                           <i class="bi bi-calendar-event"></i> Activités
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action ?? '') == 'mentions_legales' ? 'active' : ''; ?>"
                           href="index.php?action=mentions_legales">
                           <i class="bi bi-file-earmark-text"></i> Mentions légales
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main>
