<?php

namespace Aca\Bundle\ShopBundle\Model;

use Simplon\Mysql\Mysql;

/**
 * Class AbstractModel shares DB and Session
 */

abstract class AbstractModel
{
    /**
     * @var Mysql
     */
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}

?>