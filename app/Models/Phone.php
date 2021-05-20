<?php

namespace Models;

use Storage\Storage;
use Traits\Arrayable;

class Phone implements \ArrayAccess
{
    use Arrayable;

    protected $items;

    private $storage;

    public function __construct()
    {
        $this->items = (new Storage())->all();
    }

    public function all()
    {
        return $this->items;
    }

    public function sort($by, $order = 'ASC') {

        $items = $this->all();

        uasort($items, function ($a, $b) use($by, $order) {
            switch ($order){
                case 'ASC':
                   return  $a[$by] - $b[$by];
                   break;
                case 'DESC':
                    return $b[$by] - $a[$by];
                    break;
                default:
                    return  $a[$by] - $b[$by];
            }
        });

        return $items;
    }

}