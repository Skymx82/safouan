<?php $titre_page = "Nos Activités"; ?>
<?php include("vues/templates/header.php"); ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold"><i class="bi bi-calendar-event"></i> Nos Activités</h1>
            <p class="text-muted lead">Découvrez les activités complémentaires proposées par GSB et inscrivez-vous !</p>
        </div>

        <div class="row g-4">
            <?php if (!empty($activites) && is_array($activites)): ?>
                <?php foreach ($activites as $act): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">
                                    <i class="bi bi-calendar-check"></i>
                                    <?php echo htmlspecialchars($act['nom']); ?>
                                </h5>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars(mb_substr($act['description'] ?? '', 0, 150)) . '...'; ?>
                                </p>
                                <ul class="list-unstyled small">
                                    <?php if (!empty($act['date_activite'])): ?>
                                        <li class="mb-1">
                                            <i class="bi bi-calendar3 text-primary"></i>
                                            <?php echo date('d/m/Y', strtotime($act['date_activite'])); ?>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (!empty($act['lieu'])): ?>
                                        <li class="mb-1">
                                            <i class="bi bi-geo-alt text-primary"></i>
                                            <?php echo htmlspecialchars($act['lieu']); ?>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <i class="bi bi-people text-primary"></i>
                                        <?php echo intval($act['places_restantes']); ?> / <?php echo intval($act['places_max']); ?> places restantes
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                <?php if (intval($act['places_restantes']) > 0): ?>
                                    <a href="index.php?action=detail_activite&id=<?php echo $act['id']; ?>"
                                       class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-pencil-square"></i> Détails & Inscription
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-x-circle"></i> Complet
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Aucune activité disponible pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include("vues/templates/footer.php"); ?>
