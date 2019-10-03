<?php 
namespace Moly\Server\Request;

use Moly\Contracts\GameInterface;

class Game implements GameInterface{

    protected $name = null;

    public function __construct()
    {   
        $this->setGameName('Cricket');
    }

    protected function setGameName($name)
    {
        $this->name = $name;
    }

    public function getGameName()
    {
        return $this->name;
    }
   
}