<?php
namespace Core;

use Traits\Filter;

/**
 * Class Model
 */
class Model implements DbModelInterface
{
    use Filter;

    /**
     * @var
     */
    protected $table_name;
    /**
     * @var
     */
    protected $id_column;

    /**
     * @var array
     */
    protected $columns = [];
    /**
     * @var
     */
    protected $collection;
    /**
     * @var
     */
    protected $sql;

    /**
     * @var array
     */
    protected $params = [];

    protected $values = [];

    /**
     * @return $this
     */
    public function initCollection()
    {
        $columns = implode(',',$this->getColumns());
        $this->sql = "select $columns from " . $this->table_name ;
        return $this;

    }

    /**
     * @return array
     */
    public function getColumns()
    {
        $db = new DB();
        $sql = "show columns from  $this->table_name;";
        $results = $db->query($sql);
        foreach($results as $result) {
            array_push($this->columns,$result['Field']);
        }
        return $this->columns;

    }


    /**
     * @param $params
     * @return $this
     */
    public function sort($params)
    {
        if($count = count($params)) {
            $sql = " ORDER BY ";
            foreach ($params as $name => $order) {
                $sql .= $name . ' ' . $order . ', ';
            }
            $sql = rtrim($sql, ' ,');
            $this->sql .= $sql;
        }

        return $this;
    }

    /*
     * @param $params
     */

    public function filter($params)
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function getCollection()
    {
        $db = new DB();
        $this->sql .= ";";

        $this->collection = $db->query($this->sql, $this->params);
        return $this;
    }


    /**
     * @return mixed
     */
    public function select()
    {
        return $this->collection;

    }

    /**
     * @return null
     */
    public function selectFirst()
    {
        return isset($this->collection[0]) ? $this->collection[0] : null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        $sql = "select * from $this->table_name where $this->id_column = ?;";

        $db = new DB();
        $params = array($id);
        return $db->query($sql, $params)[0];
    }

    public function getField($sku)
    {
        $sql = "select * from $this->table_name where  sku = ?";
        $db = new DB();
        $params = array($sku);
        return $db->query($sql, $params)[0];
    }

    /**
     * @return array
     */
    public function getPostValues()
    {
        $values = [];
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            /*
            if ( isset($_POST[$column]) && $column !== $this->id_column ) {
                $values[$column] = $_POST[$column];
            }
             * 
             */
            $column_value = filter_input(INPUT_POST, $column);
            if ($column_value && $column !== $this->id_column ) {
                $values[$column] = $column_value;
            }

        }
        return $values;

    }

    public function addItem($values)
    {

        $db = new DB();
        $sql = "insert into $this->table_name (sku, name, price, qty, description)  values (:sku, :name, :price, :qty, :description)";
        $db->query($sql, $values);

    }

    public function saveItem($id, $values)
    {
        $db = new DB();
        $sql = "update $this->table_name set sku = :sku, name = :name, price = :price, qty = :qty, description = :description where id = $id";

        $db->query($sql, $values);
    }

    public function deleteItem()
    {
        $db = new DB();
        $db->deleteEntity($this);
    }

    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getPrimaryKeyName(): string
    {
        return $this->id_column;
    }

    public function getId()
    {
        return filter_input(INPUT_GET, 'id');
    }

    public function getSku()
    {
        return filter_input(INPUT_GET, 'sku');
    }

}
