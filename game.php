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

    $_SESSION["fightSummary"] .= "<p>{$attacker->name} lance une attaque {$attack->name}</p>";
    $_SESSION["fightSummary"] .= "<p>L'attaque {$attack->name} a généré {$shot} de dommages sur {$defender->name}</p>";
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

<main>
    <h2>Duel</h2>
    <div class="characters versus">
        <div class="character">
            <img src="assets/img/characters/<?= $player->id ?>.jpg" alt="<?= $player->name ?>">
            <div class="character-specs-wrapper">
                <div class="character-specs <?= $player->type ?>-shadow">
                    <div class="character-spec-item">
                        <img class="lightsaber-icon" src="assets/img/<?= $player->type ?>saber.svg" />
                        <span><?= $player->puissance ?></span>
                    </div>
                    <div class="character-spec-item">
                        <label class="d-none" for="playerHealth">Santé :</label>
                        <progress id="playerHealth" max="100" value="<?= $player->getHealth() ?>"><?= $player->getHealth() ?>%</progress>
                    </div>
                </div>
            </div>
        </div>
        <div class="fight-summary">
            <span>vs</span>
            <p><?= $fightSummary ?></p>
        </div>
        <div class="character">
            <img src="assets/img/characters/<?= $ia->id ?>.jpg" alt="<?= $ia->name ?>">
            <div class="character-specs-wrapper">
                <div class="character-specs <?= $ia->type ?>-shadow">
                    <div class="character-spec-item">
                        <img class="lightsaber-icon" src="assets/img/<?= $ia->type ?>saber.svg" />
                        <span><?= $ia->puissance ?></span>
                    </div>
                    <div class="character-spec-item">
                        <label class="d-none" for="iaHealth">Santé :</label>
                        <progress id="iaHealth" max="100" value="<?= $ia->getHealth() ?>"><?= $ia->getHealth() ?>%</progress>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="attacks">
        <span>Attaques :</span>
        <?php
        foreach ($player->getAttacks() as $index => $attack) {
        ?>
            <a class="btn" href="./game.php?attack=<?= $index ?>"><?= $attack->name ?></a>
        <?php
        }
        ?>
    </div>
</main>
</body>

</html>