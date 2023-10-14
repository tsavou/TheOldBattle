<?php
if (isset($_GET["win"])) {
    $win = true;
    if ($_GET["win"] == 0) {
        $win = false;
    }
}
session_start();
include("header.php");

?>

<div class="container">

    <p>
        <?php
        echo $win ? "victoire ! félicitations, tu remportes le combat !" : "game over !";
        ?>
    </p>
    <div class="img-wrapper">
        
    </div>
    <a class="btn" href="./">Nouvelle Partie</a>

</div>