<?php

namespace Aca\Bundle\ShopBundle\Controller; // use all the files in this directory

use Aca\Bundle\ShopBundle\Db\Database; //use the 'class' called Database
use Symfony\Component\HttpFoundation\Request; //class called Request
use Symfony\Bundle\FrameworkBundle\Controller\Controller;//class called Controller


class DefaultController extends Controller
{
    public function indexAction($name, $age)
    {
        return $this->render(
            'AcaShopBundle:Default:index.html.twig',
            array(
                'name' => $name,
                'age' => $age
            )
        );
    }

    /**
     *
     */
    public function loginFormAction()
    {
        return $this->render(
            'AcaShopBundle:LoginForm:loginForm.html.twig'
        );

    }

    public function processLoginAction(Request $request) //type hinting
    {
        $username = $request->get('username');
        // check above request doc block
        // $request is used to the $_POST
        echo '$username= '.$username. '<br/>';
        $password = $request->get('password');
        echo '$password= '.$password. '<br/>';


        $query = "select user_id from aca_user WHERE username='$username' and password='$password';";

        $db = new Database();

        $data = $db->fetchRows($query);
        if ($data > 0){
            return $this->render(
                'AcaShopBundle:LoginForm:loggedin.html.twig'
            );
        } die('Wrong Id or Password');

//        $username = $_POST['username'];
//        $password = $_POST['password'];
//
        // Run a query against the DB
        // Check the id and pw
        // If you find a record, it's valid user
        // If you don't, they are not valid

        // If they are valid, set things to session
        // Make the login boxes go away


    }
}

