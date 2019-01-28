<?php

require_once __DIR__ . '/inc/core.php';
require_once __DIR__ . '/inc/_template/head_start.php';

if (!isset($_GET['id']))
    exit("500");

$recipe = Recipe::Fetch($_GET['id']);
if ($recipe == null) exit("empty");

$json = file_get_contents('http://recommender-service/content?recipe=' . $_GET['id'] . '&amount=3');
$obj = json_decode($json);
pre($obj);
exit;

?>
<link href="css/base.css" rel="stylesheet">

<?php require_once __DIR__ . '/inc/_template/head_end.php'; ?>
<?php require_once __DIR__ . '/inc/_template/navigation.php'; ?>

<div class="container">

    <div class="text-center">
        <h1 class="mt-4 mb-0"><?=$recipe->title;?></h1>
        <h5 class="mt-0 mb-4"><?=implode($recipe->cuisine);?> - <?=implode($recipe->course);?></h5>
    </div>

    <div class="row">

        <div class="col-md-4">
            <img class="img-fluid" src="<?=$recipe->thumbnail;?>" alt="">
        </div>

        <div class="col-md-4">
            <h4 class="my-3">General</h4>
            <ul>
                <li>Number of Servings: <?= $recipe->number_of_servings != 0 ? $recipe->number_of_servings : "Unknown"; ?></li>
                <li>Time: <?= $recipe->time != '' ? $recipe->time  : "Unknown"; ?></li>
                <li>Rating: <?= $recipe->rating != 0 ? $recipe->rating . '/5' : "Unknown"; ?></li>
            </ul>

            <?php if ($recipe->instructions != "") { ?>
                <h4 class="my-3">Instruction</h4>
                <p><?=$recipe->instructions;?></p>
            <?php } ?>

            <?php
            if (!empty($recipe->flavors)) {
                echo '<h4 class="my-3">Flavors</h4>';
                echo '<ul>';
                foreach ($recipe->flavors as $key => $value)
                {
                    if ($value == 0) continue;
                    echo '<li>' . ($value == 1 ? $key : $key . ': ' . round($value * 100, 0) . '%') . '</li>';
                }
                echo '</ul>';
            }
            ?>

            <h4>Source</h4>
            <?= $recipe->source != '' ? '<p><a href="'.$recipe->source.'">' . $recipe->source . '</a></p>' : ''; ?>

        </div>

        <div class="col-md-4">
            <h3 class="my-3">Ingredients</h3>
            <ul>
                <?php foreach ($recipe->ingredients as $ingredient) { ?>
                    <li><?=$ingredient;?></li>
                <?php } ?>
            </ul>
        </div>

    </div>

    <hr>
    <h3 class="my-3">Recommendations</h3>
    <div class="row">
        <div class="col-4 portfolio-item">
            <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Project One</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-4 portfolio-item">
            <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Project Two</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-4 portfolio-item">
            <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Project Three</a>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="offset-2 col-4 portfolio-item">
            <div class="card h-100">
                <div class="card-header bg-dark text-white text-center">Users who liked this, liked also:</div>
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Project One</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-4 portfolio-item">
            <div class="card h-100">
                <div class="card-header bg-dark text-white text-center">Users who liked this, recently liked:</div>
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Project Two</a>
                    </h4>
                </div>
            </div>
        </div>
    </div>

</div>

<?php

pre($recipe);
require_once __DIR__ . '/inc/_template/footer.php';
