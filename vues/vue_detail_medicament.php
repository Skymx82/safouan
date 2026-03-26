<?php $titre_page = htmlspecialchars($medicament['nom']); ?>
<?php include("vues/templates/header.php"); ?>

<section class="py-5">
    <div class="container">
        <!-- Fil d'Ariane -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                <li class="breadcrumb-item"><a href="index.php?action=medicaments">Médicaments</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($medicament['nom']); ?></li>
            </ol>
        </nav>

        <!-- En-tête du médicament -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="fw-bold text-primary">
                            <i class="bi bi-capsule"></i> <?php echo htmlspecialchars($medicament['nom']); ?>
                        </h1>
                        <?php if (!empty($medicament['forme'])): ?>
                            <span class="badge bg-info fs-6 mb-2"><?php echo htmlspecialchars($medicament['forme']); ?></span>
                        <?php endif; ?>
                        <p class="lead mt-3"><?php echo htmlspecialchars($medicament['description'] ?? ''); ?></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <?php if (!empty($medicament['prix'])): ?>
                            <p class="display-6 fw-bold text-success">
                                <?php echo number_format($medicament['prix'], 2, ',', ' '); ?> &euro;
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($medicament['date_mise_marche'])): ?>
                            <p class="text-muted">
                                <i class="bi bi-calendar3"></i>
                                Mise sur le marché : <?php echo date('d/m/Y', strtotime($medicament['date_mise_marche'])); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($medicament['composition'])): ?>
                    <div class="mt-3 p-3 bg-light rounded">
                        <h6 class="fw-bold"><i class="bi bi-list-check"></i> Composition</h6>
                        <p class="mb-0"><?php echo htmlspecialchars($medicament['composition']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4">
            <!-- Effets thérapeutiques -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="bi bi-heart-pulse"></i> Effets thérapeutiques</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($medicament['effets_therapeutiques'])): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($medicament['effets_therapeutiques'] as $effet): ?>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <?php echo htmlspecialchars($effet['description']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Aucun effet thérapeutique renseigné.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Effets secondaires -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Effets secondaires</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($medicament['effets_secondaires'])): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($medicament['effets_secondaires'] as $effet): ?>
                                    <li class="list-group-item border-0 ps-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <i class="bi bi-exclamation-circle text-warning me-2"></i>
                                            <?php echo htmlspecialchars($effet['description']); ?>
                                        </div>
                                        <?php
                                        $badgeClass = 'bg-secondary';
                                        $label = $effet['gravite'];
                                        if ($effet['gravite'] == 'faible') $badgeClass = 'bg-success';
                                        elseif ($effet['gravite'] == 'modere') $badgeClass = 'bg-warning text-dark';
                                        elseif ($effet['gravite'] == 'grave') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?php echo $badgeClass; ?> ms-2">
                                            <?php echo htmlspecialchars($label); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Aucun effet secondaire renseigné.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactions médicamenteuses -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0"><i class="bi bi-arrow-left-right"></i> Interactions médicamenteuses</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($medicament['interactions'])): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Médicament en interaction</th>
                                    <th>Description</th>
                                    <th>Niveau de risque</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($medicament['interactions'] as $inter): ?>
                                    <tr>
                                        <td class="fw-bold">
                                            <i class="bi bi-capsule"></i>
                                            <?php echo htmlspecialchars($inter['nom_medicament_interaction']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($inter['description']); ?></td>
                                        <td>
                                            <?php
                                            $riskClass = 'bg-secondary';
                                            if ($inter['niveau_risque'] == 'faible') $riskClass = 'bg-success';
                                            elseif ($inter['niveau_risque'] == 'modere') $riskClass = 'bg-warning text-dark';
                                            elseif ($inter['niveau_risque'] == 'eleve') $riskClass = 'bg-orange';
                                            elseif ($inter['niveau_risque'] == 'critique') $riskClass = 'bg-danger';
                                            ?>
                                            <span class="badge <?php echo $riskClass; ?>">
                                                <?php echo htmlspecialchars($inter['niveau_risque']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted"><i class="bi bi-info-circle"></i> Aucune interaction connue avec d'autres médicaments GSB.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Retour -->
        <div class="mt-4">
            <a href="index.php?action=medicaments" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Retour à la liste des médicaments
            </a>
        </div>
    </div>
</section>

<?php include("vues/templates/footer.php"); ?>
