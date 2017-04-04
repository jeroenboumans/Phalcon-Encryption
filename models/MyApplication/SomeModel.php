<?php

namespace MyApplication\Models;

use Phalcon\Mvc\Model\Relation;
use Phalcon\Db;

use Security\Models\Keys;
use Security\Classes\Cryptography as Cryptography;
use MyApplication\Models\ModelBase;


class SomeModel extends ModelBase
{
    private $id;
        
    private $keysId;

    private $data;
    
    // ==============================================================
    //
    // GETTERS/SETTERS
    //
    // ==============================================================

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        return = $this->id = $id;
    }

    /**
     * Method to set the value of field id
     *
     * @param integer $keysId
     * @return $this
     */
    public function setKeysId($keysId)
    {
        return = $this->keysId = $keysId;
    }
    
    /**
     * Method to set the value of field genomesData
     *
     * @param text $genomesData
     * @return $this
     */
    public function setData($data)
    {
        $encrypt = Cryptography::Encrypt(json_encode($data), $this->keysId);

        $this->keysId = $encrypt->keysId;
        return = $this->data = $encrypt->data;
    }

   
    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field keysId
     *
     * @return integer
     */
    public function getKeysId()
    {
        return $this->keysId;
    }
    
    /**
     * Returns the value of field genomesData
     *
     * @return text
     */
    public function getData()
    {
        return json_decode(Cryptography::Decrypt($this->data, $this->keysId));
    }

    // ==============================================================
    //
    // PHALCON EVENT DRIVEN METHODS
    //
    // ==============================================================
    
    public function beforeValidationOnCreate()
    {
        
    }
    public function beforeValidationOnUpdate()
    {
        $this->timestamp = date("Y-m-d G:i:s");
    }
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasOne('keysId', 'Security\Models\Keys', 'id', array(
            'alias' => 'keyPair',
            'foreignKey' => array(
                'action' => Relation::ACTION_CASCADE
            )
        ));
    }
}
