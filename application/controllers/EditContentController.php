<?php

class EditContentController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity())
            $this->_helper->redirector('index', 'index');
    }

    public function indexAction()
    {
        // action body
    }

    public function editPageAction()
    {
        $pageForm = new Application_Form_Page();
        $pageModel = new Application_Model_DbTable_Pages();

        if ($this->_request->isPost() && $pageForm->isValid($this->_request->getPost()))
        {

            $formValues = $pageForm->getValues();

            $data = array(
                'keywords'    => $formValues['keywords'],
                'description' => $formValues['description'],
                'text'        => $formValues['text']
            );

            $pageModel->updatePageInfo($data, $formValues['id']);

            if ($formValues['id'] == 1)
                $this->_helper->redirector('index', 'index');
            else if ($formValues['id'] == 2)
                $this->_helper->redirector->gotoUrl('/about');

        } else {
            if (is_null($this->_request->getParam('id')))
                $this->_helper->redirector('index', 'index');

            if ($this->_request->getParam('id') == 1)
                $page = $pageModel->getHomePageInfo();
            else if ($this->_request->getParam('id') == 2)
                $page = $pageModel->getAboutPageInfo();

            $pageForm->populate($page);
        }

        $this->view->pageForm = $pageForm;
    }

    public function addEventAction()
    {
        $eventForm = new Application_Form_Event();
        $eventModel = new Application_Model_DbTable_Events();

        if ($this->_request->isPost() && $eventForm->isValid($this->_request->getPost())) {
            $formValues = $eventForm->getValues();

            $data = array(
                'text' => $formValues['text'],
                'date' => date('Y-m-d H:i:s')
            );

            $eventModel->addEvent($data);
        }

        $this->view->eventForm = $eventForm ;
    }

    public function editEventAction()
    {
        $eventForm = new Application_Form_Event();
        $eventModel = new Application_Model_DbTable_Events();

        if ($this->_request->isPost() && $eventForm->isValid($this->_request->getPost())) {

            $formValues = $eventForm->getValues();

            $data = array(
                'text' => $formValues['text']
            );

            $eventModel->editEvent($data, $formValues['id']);

        } else {
            if (is_null($this->_request->getParam('id')))
                $this->_helper->redirector('index', 'index');

            $event = $eventModel->getEventById($this->_request->getParam('id'));
            $eventForm->populate($event);
        }

        $this->view->eventForm = $eventForm;
    }

    public function deleteEventAction()
    {
        if (!is_null($this->_request->getParam('id'))) {
            $eventModel = new Application_Model_DbTable_Events();
            $eventModel->deleteEvent($this->_request->getParam('id'));
        }

        $this->_helper->redirector('index', 'index');
    }

    public function addServiceAction()
    {
        $serviceForm = new Application_Form_Service();

        if ($this->_request->isPost()  && $serviceForm->isValid($this->_request->getPost())) {
            $formValues = $serviceForm->getValues();


            if (!is_null($formValues['image']) && $serviceForm->image->receive()) {
                $newName = Zend_Registry::get('myimages') . "/" . md5(date('Y-m-d H:i')) . "_" . $formValues['image'];
                rename(Zend_Registry::get('myimages') . '/' . $formValues['image'], $newName);
            }
            $serviceModel = new Application_Model_DbTable_Services();

            $data = array(
                'keywords' => $formValues['keywords'],
                'description' => $formValues['description'],
                'title' => $formValues['title'],
                'text' => $formValues['text']
            );

            if (!is_null($formValues['image'])) {
                $data['image'] = md5(date('Y-m-d H:i')) . "_" . $formValues['image'];
            } else {
                $data['image'] = '';
            }

            $serviceModel->addService($data);
            $this->_helper->redirector->gotoUrl('/services');
        }

        $this->view->serviceForm = $serviceForm;
    }

    public function editServiceAction()
    {
        $serviceForm = new Application_Form_Service();
        $serviceModel = new Application_Model_DbTable_Services();

        if ($this->_request->isPost()  && $serviceForm->isValid($this->_request->getPost())) {
            $formValues = $serviceForm->getValues();

            if (!is_null($formValues['image']) && $serviceForm->image->receive()) {
                $newName = Zend_Registry::get('myimages') . "/" . md5(date('Y-m-d H:i')) . "_" . $formValues['image'];
                rename(Zend_Registry::get('myimages') . '/' . $formValues['image'], $newName);

                $service = $serviceModel->getServiceById($formValues['id']);
                unlink(Zend_Registry::get('myimages') . '/' . $service['image']);

            }

            $data = array(
                'keywords' => $formValues['keywords'],
                'description' => $formValues['description'],
                'title' => $formValues['title'],
                'text' => $formValues['text']
            );

            if (!is_null($formValues['image'])) {
                $data['image'] = md5(date('Y-m-d H:i')) . "_" . $formValues['image'];
            }

            $serviceModel->editService($data, $formValues['id']);
            $this->_helper->redirector->gotoUrl('/services');

        } else {
            if (is_null($this->_request->getParam('id')))
                $this->_helper->redirector('index', 'index');

            $service = $serviceModel->getServiceById($this->_request->getParam('id'));
            $serviceForm->populate($service);
        }

        $this->view->serviceForm = $serviceForm;
    }

    public function deleteServiceAction()
    {
        if (is_null($this->_request->getParam('id')))
            $this->_helper->redirector('index', 'index');

        $servicesModel = new Application_Model_DbTable_Services();
        $service = $servicesModel->getServiceById($this->_request->getParam('id'));

        if ($service['image'] != '')
            unlink(Zend_Registry::get('myimages') . '/' . $service['image']);

        $servicesModel->deleteService($this->_request->getParam('id'));
        $this->_helper->redirector->gotoUrl('/services');
    }


}















