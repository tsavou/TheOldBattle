<?php
require("src/Character.php");
include("header.php");

session_start();

if (!isset($_SESSION["player"])) {
    header("location:./");
}

$player = $_SESSION["player"];
$ia = $_SESSION["ia"];


if (isset($_GET["attack"])) {

    $gamestarted = true; // Si le combat a commencé
    $playerAttacks = $player->getAttacks();
    $iaAttacks = $ia->getAttacks();

    $playerIndex = $_GET["attack"];
    $iaIndex = array_rand($iaAttacks);

    // Attaque du joueur
    $playerAttack = $playerAttacks[$playerIndex];
    $playerShot = $player->attack($playerAttack);
    $ia->isAttacked($playerShot);


    // Riposte de l'IA
    $iaAttack = $iaAttacks[$iaIndex];
    $iaShot = $ia->attack($iaAttack);
    $player->isAttacked($iaShot);
}


if ($_SESSION["ia"]->getHealth() <= 0) {
    // Bien joué ;)
    header("location:./endbattle.php?win=1");
} elseif ($_SESSION["player"]->getHealth() <= 0) {
    // Game over :(
    header("location:./endbattle.php?win=0");
}

?>


<div class="container">
    <h1>Duel des anciens</h1>

    <div class="battle flex">
        <div class="player left">
            <h3> <?= $player->name ?></h3>
            <div class="puissance flex">
                <?= $player->puissance ?>
            </div>
            <img src="<?= $player->img ?>" alt="<?= $player->name ?>">


            <label class="d-none" for="health">Santé :</label>
            <progress class="health-bar" id="health" max="100" value="<?= $player->getHealth() ?>"> <?= $player->getHealth() ?>% </progress>

        </div>

        <div class="versus flex">
            <strong>vs</strong>

            <?php if ($gamestarted) { ?>
               <ul>
                <li>
                    <strong class="my-player"><?= $player->name ?></strong> utilise <strong><?= $playerAttack->name ?> </strong>
                    et inflige <strong><?= $playerShot ?></strong> points de dégâts à <strong class="ennemy"><?= $ia->name ?></strong>
                </li>

                <li> <strong class="ennemy"><?= $ia->name ?></strong> riposte avec <strong><?= $iaAttack->name ?></strong> et
                    inflige <strong><?= $iaShot ?></strong> points de dégâts à <strong class="my-player"><?= $player->name ?></strong>
                </li>
            </ul> 
            <?php } ?>      

        </div>

        <div class="player right">
            <h3> <?= $ia->name ?></h3>
            <div class="puissance flex">
                <?= $ia->puissance ?>
            </div>
            <img src="<?= $ia->img ?>" alt="<?= $ia->name ?>">
            <label class="d-none" for="health">Santé :</label>
            <progress class="health-bar" id="health" max="100" value="<?= $ia->getHealth() ?>"> <?= $ia->getHealth() ?>%"></progress>
        </div>
    </div>

    <div class="attacks">
        <h3>attaques : </h3>

        <ul>
            <?php foreach ($player->getAttacks() as $index => $attack) {
            ?>
                <li>
                    <a href="battle.php?attack=<?= $index ?>">
                        <?= $attack->name ?>
                    </a>
                </li>
            <?php } ?>
            <li><a id="escape" href="index.php"> Fuir le combat</a></li>
        </ul>

    </div>
</div>