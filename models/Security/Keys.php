<?php

namespace Security\Models;

use Phalcon\Mvc\Model\Relation;
use Phalcon\Db;

use MyApplication\Models\ModelBase;

class Keys extends ModelBase
{
    private $id;
        
    private $iv;

    private $key;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setIV($iv)
    {
        $this->iv = $iv;

        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIV()
    {
        return $this->iv;
    }

    public function getKey()
    {
        return $this->key;
    }
	
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('db-security');
    }
}
