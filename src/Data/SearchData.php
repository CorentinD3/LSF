<?php

namespace App\Data;

use App\Entity\Animal;
use App\Entity\Lait;
use App\Entity\Pate;

class SearchData
{

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var  Lait[]
     */
    public $lait = [];

    /**
     * @var  Pate[]
     */

    public $pates = [];
    /**
     * @var  Animal[]
     */
    public $animals = [];

}