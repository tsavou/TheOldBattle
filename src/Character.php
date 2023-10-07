<?php


class Character
{
    public $id;
    public $name;
    public $img;
    public $puissance;
    private $attacks= array();    
    private $health = 100;

    public function __construct(int $id, string $name, string $img, int $puissance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
        $this->puissance = $puissance;      
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function addAttack(Attack $attackObj)
    {
        array_push($this->attacks, $attackObj);
    }

    public function getAttacks() {
        return $this->attacks;
        
    }
    
    public function attack(Attack $attackObj) {
        $shot = ($attackObj->damage * $this->puissance) / 100;
        return $shot;
    }

    public function isAttacked(float $damage) {
        $this->health -= $damage;
    }
}





?>

<p></p>