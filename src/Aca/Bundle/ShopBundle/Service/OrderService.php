<?php

namespace Aca\Bundle\ShopBundle\Service;

use Simplon\Mysql\Mysql;
use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Service\CartService;


class OrderService
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

    /**
     * @var CartService
     */
    protected $cart;

    public function __construct(Mysql $db, Session $session, CartService $cart)   //Dependency Injection with type hinting = Mysql
    {
        $this->db = $db;
        $this->session = $session;
        $this->cart = $cart;
    }

    /**
     * Place an order
     * @return void
     */
    public function placeOrder()
    {
        $orderProducts = $this->cart->getAllCartProducts();

        $orderId = $this->createOrderRecord();
        //$orderId = $this->cart->getCartId();

        //use aca_order_product and aca_order tables in DB
        foreach ($orderProducts as $orderProduct) {
            $this->db->insert(
                'aca_order_product',
                array(
                    'order_id' => $orderId,
                    'product_id' => $orderProduct['product_id'],
                    'quantity' => $orderProduct['qty'],
                    'price' => $orderProduct['unit_price']
                )
            );
        }
        $this->cart->nixCart();

        $this->session->set('completed_order_id', $orderId);
        $this->session->save();



    }

    public function createOrderRecord()
    {
        $userId = $this->session->get('user_id');

        $query = '
        insert into
            aca_order (user_id)
        values
            ("'.$userId.'")';

        return $this->db->executeSql($query);


//        $this->db->insert('aca_order',
//            array(
//                'user_id' => $userId,
//                'order_date' => "NOW()"
//            ));
//        return $userId;
    }

    public function getOrderProducts()
    {
        $orderId = $this->session->get('completed_order_id');

        $query = '
            select
                  *
            from
            	  aca_order_product op
            	  left join aca_product p on (op.product_id = p.product_id)
            	  left join aca_cart c on (op.order_id = c.cart_id)
            WHERE
                  order_id = "'.$orderId.'"';


        return $this->db->fetchRowMany($query);


    }

}

?>