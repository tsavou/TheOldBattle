<?php


class Character
{
    public $id;
    public $name;
    public $img;
    public $puissance;
    public $attacks= array();
    public $type;
    public $origin;
    public $health = 100;

    public function __construct(int $id, string $name, string $img, int $puissance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
        $this->puissance = $puissance;      
    }
}

// Création d'un tableau d'objets Character à partir des données JSON

$characters = [];

foreach ($charactersData as $data) {
    $character = new Character($data["id"], $data["name"], $data["img"], $data["puissance"], $data["attacks"], $data["type"], $data["origin"]);
    $characters[] = $character;
}



?>

<p></p>