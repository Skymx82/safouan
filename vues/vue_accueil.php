<?php $titre_page = "Accueil"; ?>
<?php include("vues/templates/header.php"); ?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold">Galaxy Swiss Bourdin</h1>
                <p class="lead mt-3">
                    Laboratoire pharmaceutique de référence, engagé dans l'innovation thérapeutique
                    et le bien-être de chacun. Découvrez nos médicaments et nos activités de santé.
                </p>
                <div class="mt-4">
                    <a href="index.php?action=medicaments" class="btn btn-light btn-lg me-2">
                        <i class="bi bi-capsule-pill"></i> Nos médicaments
                    </a>
                    <a href="index.php?action=activites" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-event"></i> Nos activités
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <i class="bi bi-hospital display-1" style="font-size: 10rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Section Présentation -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Pourquoi choisir GSB ?</h2>
                <p class="text-muted lead">Notre engagement pour votre santé depuis plus de 30 ans</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-shield-check display-4 text-primary mb-3"></i>
                        <h4 class="card-title">Qualité certifiée</h4>
                        <p class="card-text text-muted">
                            Tous nos médicaments respectent les normes les plus strictes de l'industrie pharmaceutique
                            et sont certifiés par les autorités de santé compétentes.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-lightbulb display-4 text-primary mb-3"></i>
                        <h4 class="card-title">Innovation continue</h4>
                        <p class="card-text text-muted">
                            Notre département R&D investit constamment dans la recherche de nouvelles
                            molécules et formulations pour améliorer les traitements existants.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-people display-4 text-primary mb-3"></i>
                        <h4 class="card-title">Proximité et écoute</h4>
                        <p class="card-text text-muted">
                            GSB organise régulièrement des événements de sensibilisation à la santé
                            et propose des activités complémentaires pour le bien-être de tous.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Chiffres clés -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">350+</h2>
                    <p class="text-muted">Médicaments distribués</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">30</h2>
                    <p class="text-muted">Années d'expertise</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">15k+</h2>
                    <p class="text-muted">Professionnels de santé partenaires</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">12</h2>
                    <p class="text-muted">Sites de production</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("vues/templates/footer.php"); ?>
