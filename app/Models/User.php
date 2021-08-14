<?php
namespace Models;

use Core\Model;

/**
 * Class User
 */
class User extends Model
{
    public function __construct()
    {
        $this->table_name = $this->getName();
        $this->id_column = 'customer_id';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'customer';
    }

}