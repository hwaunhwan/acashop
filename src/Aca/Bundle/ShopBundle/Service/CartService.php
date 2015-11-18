<?php

namespace Aca\Bundle\ShopBundle\Service;

use Simplon\Mysql\Mysql;
use \Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;


class CartService
{
    /**
     * Database Class
     * @var Mysql
     */
    protected $db;

    /**
     * Session
     * @var /Session
     */
    protected $session;

    public function __construct(Mysql $db, Session $session)   //Dependency Injection with type hinting = Mysql
    {
        $this->db = $db;
        $this->session = $session;
    }


    /**
     * Add a product to the cart
     * @param $productId
     * @param $quantity
     * @return bool
     */
    public function addProduct($productId, $quantity)
    {
//
        $cartId = $this->session->get('cart_id'); //getting session set user_id from login
//        $cart = $this->session->get('cart');
//        $cartId = $this->getCartId();
        $productPrice = $this->getProductPrice($productId);

        // Check if I have a cart record
        // If I don't have one, make one
        // Will need cart_id which is Primary Key from ACA_CART



        if (!empty($cartId)) {

            $insertedId= $this->db->insert('aca_cart_product',
                array(
                    'cart_id' => $cartId,
                    'product_id' => $productId,
                    'qty' => $quantity,
                    'unit_price' => $productPrice
                )
            );

            //For cart session
//            $cart[] = array(
//                'product_id' => $productId,
//                'quantity' => $quantity
//            );
//            $this->session->set('cart', $cart);
//            $this->session->save();

            return !empty($insertedId) && is_int($insertedId) ? true : false;

        } else {
            return new RedirectResponse('/');
        }

    }

    /**
     * Get the price of one product
     * @param int $productId
     * @return float
     */
    protected function getProductPrice($productId)
    {

        $query = 'select
            *
        from
            aca_product
        where
            product_id = "' . $productId . '"';

        $row = $this->db->fetchRow($query);
        return isset($row['price']) ? $row['price'] : null;

    }
    /**
     * Create a cart record, and return the id if it doesn't exist
     * If it does exist, just return the ID
     * @return int
     * @throws Exception
     */
    public function getCartId()
    {

//        $db = $this->get('acadb');

        $user_id = $this->session->get('user_id');

        $query = '
        select
            *
        from
            aca_cart
        WHERE
            user_id = :userId';

        $data = $this->db->fetchRow($query, array('userId' => $user_id));
        if (empty($user_id)){
            throw new Exception('Please login first');
        } else {

        if (empty($data)){
            $cartId = $this->db->insert('aca_cart', array('user_id' => $user_id));
        } else {
            $cartId = $data['cart_id'];
        }
        $this->session->set('cart_id', $cartId);
        $this->session->save();

        return $cartId;
//        return $this->getCartId();
        }
    }

    public function getAllCartProducts()
    {
        $query = "
            select
                  *
            from
            	  aca_cart_product cp
	              left join aca_product p on (cp.product_id = p.product_id)
	              left join aca_cart c on (cp.cart_id = c.cart_id)
            WHERE
                  cp.cart_id = :myCartId";

        return $this->db->fetchRowMany($query,
            array(
                'myCartId'=> $this->getCartId()
            )
        );
    }

    public function updateCart()
    {
        return new RedirectResponse('/cart');
    }

    /**
     * Delete a shopping cart
     * @throws Exception
     */
    public function nixCart()
    {
        $cartId = $this->getCartId();
        $this->db->delete('aca_cart_product', array('cart_id' => $cartId));
        $this->db->delete('aca_cart', array('cart_id' => $cartId));
        //create a new black cart
//        $this->getCartId();
    }
}

?>