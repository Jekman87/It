<?php

class Application_Model_DbTable_Pages extends Zend_Db_Table_Abstract
{

    protected $_name = 'pages';

    public function getHomePageInfo()
    {
        return $this->fetchRow('id = 1')->toArray();
    }

    public function getAboutPageInfo()
    {
        return $this->fetchRow('id = 2')->toArray();
    }

    public function updatePageInfo($data, $id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);
    }
}

