<?php
require("src/Character.php");
include("header.php");

session_start();

if (!isset($_SESSION["player"])) {
    header("location:./");
}

function doAttack(Character $attacker, Character $defender, int $index = null)
{
    $attacks = $attacker->getAttacks();
    if (!isset($index)) {
        $index = array_rand($attacks);
    }
    $attack = $attacks[$index];

    $shot = $attacker->attack($attack);
    $defender->isAttacked($shot);

    $_SESSION["fightSummary"] .= "<p>{$attacker->name} utilise {$attack->name}</p>";
    $_SESSION["fightSummary"] .= "<p>Cela inflige {$shot} de dommages à {$defender->name}</p>";
}

if (isset($_GET["attack"])) {
    doAttack($_SESSION["player"], $_SESSION["ia"], $_GET["attack"]);

    // au tour de ton adversaire
    doAttack($_SESSION["ia"], $_SESSION["player"]);
}

if ($_SESSION["ia"]->getHealth() <= 0) {
    // Bien joué ;)
    header("location:./endgame.php?win=1");
} elseif ($_SESSION["player"]->getHealth() <= 0) {
    // Game over :(
    header("location:./endgame.php?win=0");
}

$player = $_SESSION["player"];
$ia = $_SESSION["ia"];
$fightSummary = $_SESSION["fightSummary"];
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
            <progress class="health-bar" id="health" max="100" value="<?= $player->getHealth()?>"> <?= $player->getHealth() ?>% </progress>

        </div>

        <div class="versus flex">
            <strong>vs</strong>
            <p> <?= $fightSummary ?></p>
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
                    <a href="battle.php?attack=<?= $index ?>"><?= $attack->name ?>
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