<?php
namespace Controllers;

use Core\Controller;
use Core\View;
use Traits\EnumeratesValues;


/**
 * Class ProductController
 */
class ProductController extends Controller
{
    use EnumeratesValues;

    public function indexAction()
    {
        $this->forward('product/list');

    }

    /**
     *
     */
    public function listAction()
    {
        // get min and max prices
        $minAndMaxPrices = $this->getModel('Product')->maxAndMinPrices();

        // set min price to view
        $min =  filter_input(INPUT_POST, 'min_price') ??  $minAndMaxPrices['min'];
        $this->set('min_price', $min);

        // set max price to view
        $max = filter_input(INPUT_POST, 'max_price') ?? $minAndMaxPrices['max'];
        $this->set('max_price', $max);

        // set page title
        $this->set('title', "Товари");

        $products = $this->getModel('Product')
            ->initCollection()
            ->whereBetween('price', $min, $max)
            ->sort($this->getSortParams())
            ->getCollection()
            ->select();

        // set products to view
        $this->set('products', $products);


        $this->renderLayout();
    }

    /**
     *
     */
    public function viewAction()
    {
        $this->set('title', "Карточка товара");

        $product = $this->getModel('Product')
            ->initCollection()
            ->filter(['id',$this->getId()])
            ->getCollection()
            ->selectFirst();
        $this->set('products', $product);

        $this->renderLayout();
    }

    /**
     *
     */
    public function editAction()
    {
        $model = $this->getModel('Product');
        $this->set('saved', 0);
        $this->set("title", "Редагування товару");
        $id = filter_input(INPUT_POST, 'id');

        if ($id) {
            $values = $model->getPostValues();
            $args = $this->productFilter();
            $filterValues = filter_var_array($values, $args);
            $this->set('saved', 1);
            $model->saveItem($id, $filterValues);
        }

        if ($this->getSku()){
            $this->set('product', $model->getField($this->getSku()));
            echo "record saved";
        } else {
            $this->set('product', $model->getItem($this->getId()));
        }



        $this->renderLayout();
    }

    /**
     *
     */
    public function addAction()
    {
        $this->set("title","Додавання товару");
        $model = $this->getModel('Product');
        if ($values = $model->getPostValues()) {
            $args = $this->productFilter();
            $filterValues = filter_var_array($values, $args);
            $model->addItem($filterValues);
            $sku = $filterValues['sku'];
            $this->redirect("/product/edit", array('sku' => $sku));

        }

        $this->renderLayout();

    }



    public function deleteAction()
    {
        $model = $this->getModel('Product');
        $model->deleteItem();
        $this->redirect('/product/list');
    }

    /**
     * @return array
     */
    public function getSortParams()
    {
        $params = [];
        $sortfirst = filter_input(INPUT_POST, 'sortfirst');
        if ($sortfirst === "price_DESC") {
            $params['price'] = 'DESC';
        } else {
            $params['price'] = 'ASC';
        }
        $sortsecond = filter_input(INPUT_POST, 'sortsecond');
        if ($sortsecond === "qty_DESC") {
            $params['qty'] = 'DESC';
        } else {
            $params['qty'] = 'ASC';
        }

        return $params;
    }

    public function betweenParams()
    {
        $params = [];
        $params['price'] = filter_input(INPUT_POST, 'price');
        $params['max'] = filter_input(INPUT_POST, 'max-price');
        return $params;
    }

    /**
     * @return array
     */
    public function getSortParams_old()
    {
        /*
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else 
        { 
            $sort = "name";
        }
         * 
         */
        $sort = filter_input(INPUT_GET, 'sort');
        if (!isset($sort)) {
            $sort = "name";
        }
        /*
        if (isset($_GET['order']) && $_GET['order'] == 1) {
            $order = "ASC";
        } else {
            $order = "DESC";
        }
         * 
         */
        if (filter_input(INPUT_GET, 'order') == 1) {
            $order = "DESC";
        } else {
            $order = "ASC";
        }
        
        return array($sort, $order);
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        /*
        if (isset($_GET['id'])) {
         
            return $_GET['id'];
        } else {
            return NULL;
        }
        */
        return filter_input(INPUT_GET, 'id');
    }

    public function getSku()
    {
        return filter_input(INPUT_GET, 'sku');
    }
    
}