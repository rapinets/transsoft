<?php


namespace Controllers;


use Core\Controller;
use Middleware\Helper;
use Validation\Validator;

class CustomerController extends Controller
{
    public function LoginAction()
    {
        if (is_null(Helper::getCustomer())){
            $this->set('title', "Вхід");
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
            {
                $email = filter_input(INPUT_POST, 'email');
                $password = md5(filter_input(INPUT_POST, 'password'));

                $customer = $this->getModel('User')
                    ->initCollection()
                    ->where('email', $email)
                    ->andWhere('password', $password)
                    ->getCollection()
                    ->selectFirst();

                if(!empty($customer)) {
                    $_SESSION['customer_id'] = $customer['customer_id'];
                    $this->redirect('/product/list');
                } else {
                    $this->invalid_password = 1;
                }
            }
            $this->renderLayout();
        }
        else {
            $this->redirect('/product/list');
        }

    }

    public function LogoutAction()
    {

        $_SESSION = [];

        // expire cookie

        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 3600, "/");
        }

        session_destroy();
        $this->redirect('/product/list');
    }

    public function registerAction()
    {
        $this->set('title', "Реєстрація");

        $model = $this->getModel('User');

        $validator = new Validator($model->getPostValues());
        $validator->setAliases([
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'password' => 'Password',
        ]);
        $validator->setRules([
            'last_name' => ['required', 'between:3,50',],
            'first_name' => ['required', 'between:3,50',],
            'telephone' => ['required', 'min:13', 'telephone',],
            'email' => ['required', 'email',],
            'password' => ['required', 'min:8', 'password',],
        ]);

        if (!$validator->validate()){
            $this->set();
        }

        $this->renderLayout();
    }


}