<?php
namespace Controllers;

use Core\Controller;
use Core\View;


/**
 * Class ProductController
 */
class ProductController extends Controller
{

    public function indexAction()
    {
        $this->forward('product/list');

    }

    /**
     *
     */
    public function listAction()
    {


        $this->set('title', "Товари");
        $products = $this->getModel('Product')
            ->initCollection()
            ->sort($this->getSortParams())
            ->getCollection()
            ->select();
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
            $this->set('saved', 1);
            $model->saveItem($id,$values);
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

            $model->addItem($values);
            $sku = $values['sku'];
            $this->redirect("/product/edit", array('sku' => $sku));
            echo "record saved ";
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