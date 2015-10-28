<?php
namespace Aca\Bundle\ShopBundle\Db;
use \mysqli;
use \Exception;
/**
 * Class Database
 * @package Aca\Bundle\ShopBundle\Db
 */
class Database
{
    /**
     * @var mysqli
     */
    protected $db;
    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "root", "acashop");
        if ($this->db->connect_errno) {
            throw new Exception(
                "Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error
            );
        }
    }

    /**
     * Get many rows from the DB
     * @param string $query SQL query
     * @return array Assoc array of data from DB
     */
    public function fetchRowMany($query)
    {
        $return = [];
        $result = $this->db->query($query);
        while($row = $result->fetch_assoc()){
            $return[] = $row;
        }
        return $return;
    }
}
//class Database
//{
//    /**
//     * Database connection
//     *
//     * @var mysqli
//     */
//    protected $db;
//
//    public function __construct(){
//
//        $host = 'localhost';
//        $username = 'root';
//        $password = 'root';
//        $dbname = 'acashop';
//
//
//        $this->db = new \mysqli($host, $username, $password, $dbname); // you can type Use \mysqli; on top.... then you won't need \ in front of mysqli
//
//        if ($this->db->connect_errno){
//
//            throw new Exception(
//                "Failed to connect to MySQL: (" . $this->db->connect_errno . ")" . $this->db->connect_error
//            );
//
//            //die("Connection failed: ". $db->connect_error);//Do not use die and exit...it's better to use Exception
//        } else {echo "Connected successfully <br/>";}
//
//        //connect to the db?
//        //go to php.net and investigate mysqli family of functions
//    }
//
//    public function fetchRowMany($query)
//    {
//
//        return array('user_id');// make it 3 since I only have 3 on my table
//    }
//}


