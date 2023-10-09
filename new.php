<?php
require("src/Character.php");

session_start();

$json = file_get_contents("characters.json");
$characters = json_decode($json, true);

$index = array_search($_GET["id"], array_column($characters, "id"));

if (is_bool($index)) {
    header("location:./");
}

$obj = $characters[$index];

// Création du personnage que nous avons sélectionné
$player = new Character($obj["id"], $obj["name"], $obj["img"], $obj["puissance"]);

// Ajout des attaques à notre personnage
foreach ($obj["attacks"] as $attack) {
    $objAttack = new Attack($attack["name"], $attack["damage"]);
    $player->addAttack($objAttack);
}
// Stockage de l'objet en session
$_SESSION["player"] = $player;

// Obtenir un index aléatoire du tableau $characters
$index = array_rand($characters);

$obj = $characters[$index];

// Création du personnage de l'ia
$ia = new Character($obj["id"], $obj["name"], $obj["img"], $obj["puissance"]);

foreach ($obj["attacks"] as $attack) {
    $objAttack = new Attack($attack["name"], $attack["damage"]);
    $ia->addAttack($objAttack);
}

$_SESSION["ia"] = $ia;

// Initialisation du résumé du combat à venir
$_SESSION["fightSummary"] = "";

header("Location: ./battle.php");
