<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

class HeaderadminCell extends Cell
{

    public function display($userdata)
    {
      $mediatable = TableRegistry::get('Multimedia');
      $img = $mediatable->get($userdata['multimedia_id'], [
          'contain' => []
      ]);
       $this->set('userdata', $userdata);
       $this->set('img', $img);
    }

}
