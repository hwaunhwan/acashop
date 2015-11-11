<?php

namespace Aca\Bundle\ShopBundle\Controller; // use all the files in this directory


use Symfony\Bundle\FrameworkBundle\Controller\Controller;//class called Controller
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
//use \Exception;

/**
 * Class CartController deals with all things related to the cart
 * @package Aca\Bundle\ShopBundle\Controller
 */
class CartController extends Controller
{

    public function showCartAction()
    {

        $cart = $this->get('cart');
        $db = $this->get('acadb');
        $cartProducts = $cart->getAllCartProducts();



//        $cart = $this->get('cart');
//        $db = $this->get('acadb');
//        $session = $this->getSession();
//        $cart = $this->get('cart');
//        $cart->getCartId();
//
//        $cartId = $session->get('cart_id');
//
//        $query = "
//            select
//                  *
//            from
//            	  aca_cart_product cp
//	              left join aca_product p on (cp.product_id = p.product_id)
//	              left join aca_cart c on (cp.cart_id = c.cart_id)
//            WHERE
//                  cp.cart_id = :myCartId";
//
//        $query = "SELECT
//                      *
//                  FROM
//                  aca_cart_product
//                  WHERE
//                  cart_id = :myCartId
//                  "
//        ;
//        $cartProducts = $db->fetchRowMany($query, array('myCartId'=> $cartId));


        return $this->render(
            'AcaShopBundle:Cart:show.all.html.twig',
            array(
                'cartProducts' => $cartProducts
            )
        );
    }

    public function addCartAction(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity');

        $cart = $this->get('cart'); //Cart Service
        $cart->getCartId();

        $cart->addProduct($productId, $quantity);

        return new RedirectResponse('/cart');


//        try {
//            $productId = $request->get('product_id');
//            $quantity = $request->get('quantity');
//
//            $cart = $this->get('cart'); //Cart Service
//            $cart->getCartId();
//
//            $cart->addProduct($productId, $quantity);
//        } catch (Exception $e){
//            $e->getMessage('Please Login');
//            return new RedirectResponse('/cart');
//        }
    }

//    private function getSession()
//    {
//        /**
//         * @var Session $session
//         */
//        $session = $this->get('session');
//        if (!$session->isStarted()) {
//            $session->start();
//        }
//        return $session;
//    }


}



?>

