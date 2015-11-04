<?php

namespace Aca\Bundle\ShopBundle\Controller; // use all the files in this directory


use Symfony\Bundle\FrameworkBundle\Controller\Controller;//class called Controller
use Aca\Bundle\ShopBundle\Db\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;



class ProductController extends Controller
{
    /**
     * Show all Products
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllAction()
    {
        $query = "SELECT
                      *
                  FROM
                  aca_product
                  ORDER BY
                  product_id desc"
        ;

        $db = new Database();
        $productRows = $db->fetchRowMany($query);
//        foreach ($productRows as $row){
//        };
//            $product[] = $row['name'];
//            $price[] = $row['price'];
////            echo "Title:     $row[title]<br>Author:    $row[author]<br>Date:      $row[date]<br>Contents:  $row[contents]<br><br><br></pre>";
//            //print_r($row);
//        }
//            //print_r($product);
        return $this->render(
            'AcaShopBundle:Product:products.html.twig',
            array(
                'products' => $productRows,
                 )
            );


    }

    /**
     * Single Product
     * @param string $slug
     */
    public function showOneAction($category, $slug)
    {
        $db = new Database();

        $query= 'select * from aca_product where category = "'.$category.'" and slug = "'.$slug.'";';

        $product = $db->fetchRowMany($query);

        $product = $product[0];
//        $product = array_pop($product); same thing as line 62
//        $product = array_shift($product); same thing as line 62

//        print_r($category, $slug);

        return $this->render(
            'AcaShopBundle:Product:single_product.html.twig',
            array(
                'product' => $product,
            ));
    }


}

/*
 * 1. Create a field called slug in the product table
 * 2. Populate the slug with some value
 * 3. Make a hyperlink for each product using this slug
 * 4. Make sure two things don't have the same name
 *      http://www.epicurious.com/recipes/food/views/goan-curried-clams-101277
 *      in above address 'goan-curried-clams-101277' is called slug
 * 5. Create a route for the new page and a controller for the new route
 * 6. Create a method in the controller to handle the product detail page with slug
 * 7. Figure out which product you should display using slug
 *
 */