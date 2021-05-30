<?php
namespace Controllers;

use Core\Controller;
use Models\Phone;

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