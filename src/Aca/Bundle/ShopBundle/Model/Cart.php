<?php
namespace Aca\Bundle\ShopBundle\Model;


class Cart extends AbstractModel
{
    /**
     * Get all products that are in my shopping cart
     * @param int $cartId PK for the shopping cart
     * @return array|null
     */

    public function getAllCartProducts($cartId)
    {
        $query = '
        select
                  *
        from
            	  aca_cart_product cp
	              left join aca_product p on (cp.product_id = p.product_id)
	              left join aca_cart c on (cp.cart_id = c.cart_id)
        WHERE
                  cp.cart_id = :myCartId
        ';
        return $this->db->fetchRowMany($query,
            array(
                'myCartId' => $cartId
            )
        );

    }

}