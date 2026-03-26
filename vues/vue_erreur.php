<?php $titre_page = "Erreur"; ?>
<?php include("vues/templates/header.php"); ?>

<section class="py-5">
    <div class="container text-center">
        <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
        <h1 class="fw-bold mt-3">Oups !</h1>
        <p class="lead text-muted">
            <?php echo htmlspecialchars($erreur ?? 'Une erreur est survenue.'); ?>
        </p>
        <a href="index.php" class="btn btn-primary mt-3">
            <i class="bi bi-house-door"></i> Retour à l'accueil
        </a>
    </div>
</section>

<?php include("vues/templates/footer.php"); ?>
