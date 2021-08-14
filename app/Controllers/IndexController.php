<?php
namespace Controllers;

use Core\Controller;
use Middleware\Helper;


/**
 * Class IndexController
 */
class IndexController extends Controller
{

    /**
     *
     */
    public function indexAction()
    {
        $this->set("title", "Test shop");
        Helper::getCustomer();
        $this->forward('index/test');
    }

    /**
     *
     */
    public function testAction()
    {
        echo "hello from testAction";

    }

}