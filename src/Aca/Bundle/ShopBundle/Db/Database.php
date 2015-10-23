<?php

namespace Aca\Bundle\ShopBundle\Db;

class Database
{
    /**
     * Database connection
     *
     * @var DBCommon
     */
    protected $db;

    public function __construct(){

        $host = 'localhost';
        $username = 'root';
        $password = 'root';
        $dbname = 'acashop';


        $db = new \mysqli($host, $username, $password, $dbname);

        if ($db->connect_error){
            die("Connection failed: ". $db->connect_error);
        }
        echo "Connected successfully <br/>";
        //connect to the db?
        //go to php.net and investigate mysqli family of functions
    }

    public function fetchRows($query)
    {
        return array('user_id');// make it 3 since I only have 3 on my table
    }
}