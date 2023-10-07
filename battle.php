<?php
session_start();



include("src/classes.php");
include("header.php");

// récupération du perso selectionné
if (isset($_GET["id"])) {
    foreach ($characters as $character) {
        if ($character->id == $_GET["id"]) {
            $MyCharacter = $character;
        }
    }
}
// récupération de l'adversaire
if (isset($_GET["versus"])) {
    foreach ($characters as $character) {
        if ($character->id == $_GET["versus"]) {
            $ennemy = $character;
        }
    }
}




// Gestion des attaques, du combat et de la santé
$isStarted = false;
$isOver = false;




if (!isset($_SESSION['ennemy_hp'])) {
    $_SESSION['ennemy_hp'] = $ennemy->health;
}

if (!isset($_SESSION['my_hp'])) {
    $_SESSION['my_hp'] = $MyCharacter->health;
}

if ($_SESSION['my_hp'] <= 0 or $_SESSION['ennemy_hp'] <= 0) {
    $isOver = true;
    unset($victory);
    unset($damage);
    unset($counter_damage);
}

if (!$isOver) {


    if (isset($_GET["attack"])) {
        $isStarted = true;
        $selectedattack = $_GET["attack"];
        foreach ($MyCharacter->attacks as $attack) {
            if ($attack["name"] == $selectedattack) {
                $attackname = $attack["name"];
                $damage = $attack["damage"];

                // Réduction des points de vie de l'adversaire
                $_SESSION['ennemy_hp'] -= $damage;
            }
        }

        // riposte de l'adversaire
        $attackindex = rand(0, count($ennemy->attacks) - 1);
        $counter = $ennemy->attacks[$attackindex];
        $counter_damage = $counter["damage"];

        // Réduction de points de vie de mon perso
        $_SESSION['my_hp'] -= $counter_damage;
    }
    $ennemy_hp = $_SESSION['ennemy_hp'];
    $my_hp = $_SESSION['my_hp'];

    if ($_SESSION['ennemy_hp'] <= 0) {
        $victory = true;
        $isOver = true;
    } else if ($_SESSION['my_hp'] <= 0) {
        $victory = false;
        $isOver = true;
    }
} else {
    $_SESSION['ennemy_hp'] = $ennemy->health;
    $_SESSION['my_hp'] = $MyCharacter->health;
    $ennemy_hp = $_SESSION['ennemy_hp'];
    $my_hp = $_SESSION['my_hp'];
}


?>


<div class="container">
    <h1>Duel des anciens</h1>

    <div class="battle flex">
        <div class="player left">
            <h3> <?= $MyCharacter->name ?></h3>
            <div class="puissance flex">
                <?= $MyCharacter->puissance ?>
            </div>
            <img src="<?= $MyCharacter->img ?>" alt="<?= $MyCharacter->name ?>">

            <?php if (!$isOver) { ?>
                <label for="health"></label>
                <progress class="health-bar" id="health" max="100" value="<?= $my_hp ?>"></progress>
            <?php } ?>
        </div>

        <div class="versus flex">
            <strong>vs</strong>
            <?php if ($isStarted && !$isOver) {
            ?>
                <ul>
                    <li class="my-player">
                        <strong><?= $MyCharacter->name ?></strong> utilise <strong><?= $attackname ?> </strong>
                        et inflige <strong><?= $damage ?></strong> points de dégats à <strong><?= $ennemy->name ?></strong>
                    </li>

                    <li class="ennemy"> <strong><?= $ennemy->name ?></strong> riposte avec <strong><?= $counter["name"] ?></strong> et
                        inflige <strong><?= $counter["damage"] ?></strong> points de dégats à <strong><?= $MyCharacter->name ?></strong>
                    </li>
                </ul>
            <?php
            } elseif (!$isStarted && !$isOver) {
            ?>
                <ul>
                    <li> Sélectionner une attaque pour commencer le combat </li>
                </ul>
            <?php
            } elseif ($isOver && $victory) {
            ?>
                <ul>
                    <li class="my-player"> <strong> Victoire ! </strong></li>
                </ul>
                <a class="newgame" href="index.php"> Nouveau combat</a>
            <?php
            } elseif ($isOver && !$victory) {
            ?>
                <ul>
                    <li class="ennemy"> <strong> Perdu ! </strong> </li>
                </ul>
                <a class="newgame" href="index.php"> Nouveau combat</a>
            <?php
            }
            ?>

        </div>

        <div class="player right">
            <h3> <?= $ennemy->name ?></h3>
            <div class="puissance flex">
                <?= $ennemy->puissance ?>
            </div>
            <img src="<?= $ennemy->img ?>" alt="<?= $ennemy->name ?>">

            <?php if (!$isOver) { ?>
                <label for="health"></label>
                <progress class="health-bar" id="health" max="100" value="<?= $ennemy_hp ?>"></progress>
            <?php } ?>
        </div>
    </div>

    <div class="attacks">
        <h3>attaques : </h3>


        <ul>
            <?php foreach ($MyCharacter->attacks as $attack) {
            ?>
                <li>
                    <a href="battle.php?id=<?= $MyCharacter->id ?>&name=<?= $MyCharacter->name ?>&versus=<?= $ennemy->id ?>&ennemy=<?= $ennemy->name ?>&attack=<?= $attack["name"] ?>">
                        <?= $attack["name"] ?>
                    </a>
                </li>

            <?php
            } ?>
            <li>
                <a id="escape" href="index.php"> Fuir le combat</a>

            </li>
        </ul>

    </div>
</div>