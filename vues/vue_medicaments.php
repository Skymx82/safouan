<?php $titre_page = "Nos Médicaments"; ?>
<?php include("vues/templates/header.php"); ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold"><i class="bi bi-capsule-pill"></i> Nos Médicaments</h1>
            <p class="text-muted lead">Découvrez les médicaments fabriqués par Galaxy Swiss Bourdin</p>
        </div>

        <!-- Barre de recherche -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchMedicament" class="form-control"
                           placeholder="Rechercher un médicament..." onkeyup="filtrerMedicaments()">
                </div>
            </div>
        </div>

        <!-- Liste des médicaments -->
        <div class="row g-4" id="listeMedicaments">
            <?php if (!empty($medicaments) && is_array($medicaments)): ?>
                <?php foreach ($medicaments as $med): ?>
                    <div class="col-md-6 col-lg-4 medicament-card">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold text-primary mb-0">
                                        <i class="bi bi-capsule"></i>
                                        <?php echo htmlspecialchars($med['nom']); ?>
                                    </h5>
                                    <?php if (!empty($med['forme'])): ?>
                                        <span class="badge bg-info"><?php echo htmlspecialchars($med['forme']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars(mb_substr($med['description'] ?? '', 0, 150)) . '...'; ?>
                                </p>
                                <?php if (!empty($med['prix'])): ?>
                                    <p class="fw-bold text-success mb-2">
                                        <i class="bi bi-tag"></i> <?php echo number_format($med['prix'], 2, ',', ' '); ?> &euro;
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                <a href="index.php?action=detail_medicament&id=<?php echo $med['id']; ?>"
                                   class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-eye"></i> Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Aucun médicament disponible pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
/**
 * Filtre les médicaments en temps réel selon la saisie utilisateur
 */
function filtrerMedicaments() {
    const recherche = document.getElementById('searchMedicament').value.toLowerCase();
    const cartes = document.querySelectorAll('.medicament-card');
    cartes.forEach(function(carte) {
        const texte = carte.textContent.toLowerCase();
        carte.style.display = texte.includes(recherche) ? '' : 'none';
    });
}
</script>

<?php include("vues/templates/footer.php"); ?>
