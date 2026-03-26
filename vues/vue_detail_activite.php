<?php $titre_page = htmlspecialchars($activite['nom']); ?>
<?php include("vues/templates/header.php"); ?>

<section class="py-5">
    <div class="container">
        <!-- Fil d'Ariane -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                <li class="breadcrumb-item"><a href="index.php?action=activites">Activités</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($activite['nom']); ?></li>
            </ol>
        </nav>

        <!-- Message d'inscription -->
        <?php if (isset($message_inscription)): ?>
            <?php if ($message_inscription['status'] == 1): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($message_inscription['status_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle-fill"></i> <?php echo htmlspecialchars($message_inscription['status_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Détail de l'activité -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="fw-bold text-primary">
                            <i class="bi bi-calendar-event"></i>
                            <?php echo htmlspecialchars($activite['nom']); ?>
                        </h1>
                        <p class="lead mt-3"><?php echo htmlspecialchars($activite['description'] ?? ''); ?></p>

                        <div class="row mt-4 g-3">
                            <?php if (!empty($activite['date_activite'])): ?>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded">
                                        <h6 class="fw-bold text-primary"><i class="bi bi-calendar3"></i> Date</h6>
                                        <p class="mb-0"><?php echo date('d/m/Y', strtotime($activite['date_activite'])); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($activite['lieu'])): ?>
                                <div class="col-sm-6">
                                    <div class="p-3 bg-light rounded">
                                        <h6 class="fw-bold text-primary"><i class="bi bi-geo-alt"></i> Lieu</h6>
                                        <p class="mb-0"><?php echo htmlspecialchars($activite['lieu']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="fw-bold text-primary"><i class="bi bi-people"></i> Places</h6>
                                    <p class="mb-0">
                                        <strong><?php echo intval($activite['places_restantes']); ?></strong>
                                        / <?php echo intval($activite['places_max']); ?> disponibles
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire d'inscription -->
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> S'inscrire à cette activité</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (intval($activite['places_restantes']) > 0): ?>
                            <form action="index.php" method="post">
                                <input type="hidden" name="action" value="inscrire">
                                <input type="hidden" name="id_activite" value="<?php echo $activite['id']; ?>">

                                <div class="mb-3">
                                    <label for="nom" class="form-label fw-bold">Nom *</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required
                                           placeholder="Votre nom">
                                </div>

                                <div class="mb-3">
                                    <label for="prenom" class="form-label fw-bold">Prénom *</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" required
                                           placeholder="Votre prénom">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           placeholder="votre.email@exemple.fr">
                                </div>

                                <div class="mb-3">
                                    <label for="telephone" class="form-label fw-bold">Téléphone</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone"
                                           placeholder="06 XX XX XX XX">
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="bi bi-check-circle"></i> Confirmer l'inscription
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-x-circle display-4 text-danger"></i>
                                <p class="mt-3 fw-bold">Cette activité est complète.</p>
                                <p class="text-muted">Il n'y a plus de places disponibles.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Retour -->
        <div class="mt-4">
            <a href="index.php?action=activites" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Retour aux activités
            </a>
        </div>
    </div>
</section>

<?php include("vues/templates/footer.php"); ?>
