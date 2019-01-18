<?php

class Application_Model_DbTable_Events extends Zend_Db_Table_Abstract
{

    protected $_name = 'events';

    public function getAllEvents()
    {
        return $this->fetchAll(null, 'id DESC')->toArray();
    }

    public function addEvent($data)
    {
        $this->insert($data);
    }

    public function getEventById($id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        return $this->fetchRow($where)->toArray();
    }

    public function editEvent($data, $id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);
    }

    public function deleteEvent($id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }

}

