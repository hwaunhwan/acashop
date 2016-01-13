<?php
namespace Aca\Bundle\ShopBundle\Controller; // use all the files in this directory


use Symfony\Bundle\FrameworkBundle\Controller\Controller;//class called Controller
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Class OrderController deals with all things related to shipping and billing
 * @package Aca\Bundle\ShopBundle\Controller
 */
class OrderController extends Controller
{
    /**
     * Place an order
     * @param Request $request
     * @return RedirectResponse
     */
    public function placeOrderAction(Request $request)
    {

        $submitCheck = $request->get('submit_check');



        if (empty($submitCheck) || $submitCheck != 1) {
            return new RedirectResponse('/cart');
        } else {
            $order = $this->get('order');
            $order->placeOrder();
            $orderProducts = $order->getOrderProducts();

            return $this->render(
                'AcaShopBundle:Order:order.html.twig',
                array (
                    'orderProducts' => $orderProducts
                )
            );
        }
    }

    public function thankYouAction()
    {
        $order = $this->get('order');
        $orderProducts = $order->getOrderProducts();

        return $this->render(
            'AcaShopBundle:Order:order.html.twig',
            array(
                'orderProducts' => $orderProducts
            )
        );
    }


}





?>