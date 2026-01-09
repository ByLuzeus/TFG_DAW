<?php
namespace App\View\Cell;

use Cake\View\Cell;

class MenuadminCell extends Cell
{

    public function display($seccion)
    {

       $this->set('seccion', $seccion);
    }

}
