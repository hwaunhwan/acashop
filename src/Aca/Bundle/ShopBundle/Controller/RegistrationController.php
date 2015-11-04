<?php

namespace Aca\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;//class called Controller
use Aca\Bundle\ShopBundle\Db\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;



class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $msg = null; //to give error msg when id is already taken

        $session = $this->getSession();

        $name = $request->get('name');
        $username = $request->get('username');
        $password = $request->get('password');

        if (!empty($name) && !empty($username) && !empty($password)) {

            $db = new Database();

        $query = '
              select
                *
              from
                aca_user
              where
                username = "' . $username . '"';

        $data = $db->fetchRowMany($query);


        if (!empty($data) && $request->getMethod() == 'POST') {                          //Duplicate username
            $msg = 'Username is already in use...Please choose a different one!';
            $session->set('newUser', false);
        } else {
            $newQuery = '
            insert into
            aca_user
            (name, username, password)
            VALUES
            ("' . $name . '", "' . $username . '", "' . $password . '")';

            $db->createUser($newQuery);

            $session->set('newUser', true);
            $session->set('name', $name);
        }
        }
        $session->save();

        $newUser = $session->get('newUser');

        return $this->render(
            'AcaShopBundle:Default:registration.html.twig',
            array(
                'newUser' => $newUser,
                'name' => $name,
                'msg' => $msg,
                'username' => $username,
                'password' => $password
            )
        );
    }

    private function getSession()
    {
        /**
         * @var Session $session
         */
        $session = $this->get('session');
        if (!$session->isStarted()) {
            $session->start();
        }
        return $session;
    }


    public function toHomeAction()
    {
        $session = $this->getSession();
        $session->remove('newUser');
        $session->save();
        return new RedirectResponse('/');
    }
}
?>