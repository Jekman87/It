<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity())
            $this->_helper->redirector('index', 'index');


        $loginForm = new Application_Form_Login();

        if ($this->_request->isPost() && $loginForm->isValid($this->_request->getPost())) {

            $formValues = $loginForm->getValues();

            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
            $authAdapter->setTableName('users')
                        ->setIdentityColumn('username')
                        ->setCredentialColumn('password')
                        ->setCredentialTreatment('MD5(CONCAT(MD5(?), MD5(salt)))');

            $authAdapter->setIdentity($formValues['username'])
                        ->setCredential($formValues['password']);

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($authAdapter);

            if ($result->isValid()) $this->_helper->redirector('index', 'index');
            else $this->view->message = "Вы ввели неверные данные";

        }

        $this->view->loginForm = $loginForm;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }


}



