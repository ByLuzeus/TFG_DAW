<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Multimedia Entity
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string $alt
 * @property string $description
 * @property string $mytype
 *
 * @property \App\Model\Entity\Artcile[] $articles
 * @property \App\Model\Entity\Timeline[] $timelines
 * @property \App\Model\Entity\Network[] $networks
 * @property \App\Model\Entity\Slider[] $sliders
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Activity[] $activities
 */
class Multimedia extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'url' => true,
        'title' => true,
        'alt' => true,
        'description' => true,
        'mytype' => true,
        'articles' => true,
        'networks' => true,
        'sliders' => true,
        'adminusers' => true,
        'timelines' => true,
        'activities' => true,
    ];
}
