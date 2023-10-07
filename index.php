<?php
include("header.php");
include("src/classes.php");
//choix de l'adversaire
$ennemy = $characters[rand(0, count($characters) - 1)];

session_start();

// Réinitialiser les données de santé lorsque vous commencez un nouveau combat
unset($_SESSION['ennemy_hp']);
unset($_SESSION['my_hp']);

?>

<div class="container">
    <h1>Selection de l'ancien</h1>

    <div class="characters flex">

        <?php
        foreach ($characters as $character) {
        ?>
            <div class="character-card">
                <a href="battle.php?id=<?= $character->id ?>&name=<?= $character->name ?>&versus=<?= $ennemy->id ?>&ennemy=<?= $ennemy->name ?>">
                    <img src="<?= $character->img ?>" alt="<?= $character->name ?>">
                </a>

                <p class="name"><?= $character->name ?></p>
                <div class="puissance flex"><?= $character->puissance ?></div>


            </div>

        <?php
        }
        ?>
    </div>

</div>


</body>

</html>