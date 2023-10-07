<?php
$json = file_get_contents("characters.json");
$characters = json_decode($json, true);

include("header.php");

$ennemy = $characters[rand(0, count($characters) - 1)];

?>

<div class="container">
    <h1>Selection de l'ancien</h1>

    <div class="characters flex">

        <?php
        foreach ($characters as $character) {
        ?>
            <div class="character-card">
                <a href="battle.php?id=<?= $character["id"] ?>&name=<?= $character["name"] ?>&versus=<?= $ennemy["id"] ?>&ennemy=<?= $ennemy["name"] ?>">
                    <img src="<?= $character["img"] ?>" alt="<?= $character["name"] ?>">
                </a>

                <p class="name"><?= $character["name"] ?></p>
                <div class="puissance flex"><?= $character["puissance"] ?></div>


            </div>

        <?php
        }
        ?>
    </div>

</div>


</body>

</html>