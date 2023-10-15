<?php
$json = file_get_contents("characters.json");
$characters = json_decode($json, true);

include("header.php");

?>

<div class="container">
    <h1>Selection de l'ancien</h1>

    <div class="characters flex">

        <?php
        foreach ($characters as $character) {
        ?>
            <div class="character-card">
                <a href="new.php?id=<?= $character["id"] ?>">
                    <img src="<?= $character["img"] ?>" alt="<?= $character["name"] ?>">
                </a>

                <p class="name"><?= $character["name"] ?></p>
                <div class="puissance flex"><?= $character["puissance"] ?></div>


            </div>

        <?php
        }
        ?>
    </div>

    <audio id="hover-sound">
        <source src="assets/audio/hover.wav" type="audio/mpeg">
    </audio>
   

</div>

<script src="assets/js/soundeffects.js"></script>
</body>

</html>