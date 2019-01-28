<?php require_once __DIR__ . '/inc/core.php'; ?>
<?php require_once __DIR__ . '/inc/_template/head_start.php'; ?>
<link href="css/cover.css" rel="stylesheet">
<?php require_once __DIR__ . '/inc/_template/head_end.php'; ?>

<header class="masthead mb-auto">
    <div class="inner">
        <h3 class="masthead-brand">Recipe Recommender</h3>
        <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" href="#">Home</a>
            <a class="nav-link" href="#">Features</a>
            <a class="nav-link" href="#">Contact</a>
        </nav>
    </div>
</header>

<main role="main" class="inner cover">
    <h1 class="cover-heading">Recipe Recommender</h1>
    <p class="lead">Finding recipes you will love.</p>

    <div class="row mt-5">
        <div class="offset-2 col-4">
            <p class="lead text-center">
                <a href="#" class="btn btn-lg btn-secondary text-center" style="width: 120px;">Explore</a>
            </p>
        </div>
        <div class="col-4">
            <p class="lead text-center">
                <a href="#" class="btn btn-lg btn-secondary text-center" style="width: 120px;">Login</a>
            </p>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/inc/_template/footer.php'; ?>
