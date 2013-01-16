<?php
class System_Db_model extends System_model
{

    protected $_adapter = 'mysql';
    protected $_dbArr = array();
    protected $_db;

    public function __construct()
    {
        parent::__construct();
        $this->_setAdapter();
        // $this->_helper = System_Db_Model_Helper::getInstance();
        $this->init();
    }

    protected function _setAdapter()
    {
        if (!$this->_db = System_Db_Adapter::getAdapter($this->_adapter))
        {
            $this->_db = System_Db_Adapter::connect($this->_adapter);
            $this->_dbArr[$this->_adapter] = $this->_db;
        }
    }

    protected function _getAdapter($adapter)
    {
        if (!isset($this->_dbArr[$adapter]))
        {
            return $this->_dbArr[$adapter] = System_Db_Adapter::connect($adapter);
        }else
        return $this->_dbArr[$adapter];
    }

}