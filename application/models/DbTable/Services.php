<?php

class Application_Model_DbTable_Services extends Zend_Db_Table_Abstract
{

    protected $_name = 'services';

    public function getAllServices()
    {
        $select = $this->select()
                       ->from(
                           $this->_name,
                           array('id', 'keywords', 'description', 'title', 'image'))
                       ->order('id DESC');

        return $this->fetchAll($select)->toArray();
    }

    public function getServiceById($id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        return $this->fetchRow($where)->toArray();
    }

    public function addService($data)
    {
        $this->insert($data);
    }

    public function editService($data, $id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);
    }

    public function deleteService($id)
    {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }




}

