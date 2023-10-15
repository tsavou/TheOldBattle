<?php
if (isset($_GET["win"])) {
    $win = true;
    if ($_GET["win"] == 0) {
        $win = false;
    }
}
include("header.php");

?>

<div class="endbattle container">


    <?php if ($win) { ?>
        <p class="victory">Victoire ! </p>
        <p>Félicitations, tu remportes le combat !</p>
        <div class="img-wrapper">
            <img src="assets/img/victory.webp" alt="">
        </div>

    <?php } else { ?>
        <p class="defeat">Game over !</p>
        <p>Tu as perdu, recommence !</p>
        <div class="img-wrapper">
            <img src="assets/img/defeat.jpg" alt="">
        </div>

    <?php }
    ?>



    <a class="newgame" href="./">Nouvelle Partie</a>

</div>