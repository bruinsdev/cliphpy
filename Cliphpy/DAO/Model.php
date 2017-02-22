<?php

namespace Cliphpy\DAO;

use Cliphpy\Element;

abstract class Model extends Element
{
    /**
     * @param int $signal
     */
    public function close($signal)
    {
    }

    public function setInstance($instance)
    {
        $this->dao = $instance;
    }

    public function setDatabase()
    {
        $this->db = $this->dao->getDatabase();
    }
}
