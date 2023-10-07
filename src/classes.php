<?php

$json = file_get_contents("characters.json");
$charactersData = json_decode($json, true);

class Character
{
    public $id;
    public $name;
    public $img;
    public $puissance;
    public $attacks;
    public $type;
    public $origin;
    public $health;

    public function __construct(int $id, string $name, string $img, int $puissance, array $attacks, string $type, string $origin, int $health = 100)
    {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
        $this->puissance = $puissance;
        $this->attacks = $attacks;
        $this->type = $type;
        $this->origin = $origin;
        $this->health = $health;
    }
   
   
}

// Création d'un tableau d'objets Character à partir des données JSON

$characters=[];

foreach ($charactersData as $data) {
    $character = new Character($data["id"], $data["name"], $data["img"], $data["puissance"], $data["attacks"], $data["type"], $data["origin"]);
$characters[]=$character;
}



?>

<p></p>