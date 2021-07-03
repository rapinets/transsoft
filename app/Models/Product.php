<?php
namespace Models;

use Core\DB;
use Core\Model;

/**
 * Class Product
 */
class Product extends Model
{
    protected $values = [];

    /**
     * Product constructor.
     */
    function __construct()
    {
        $this->table_name = "products";
        $this->id_column = "id";

    }

    // get max and min prices
    public function maxAndMinPrices()
    {
        $this->sql = "SELECT MIN(price) AS min, MAX(price) AS max FROM " . $this->table_name;
        return $this->getCollection()->select()[0];
    }



}