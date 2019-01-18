<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $pagesModel = new Application_Model_DbTable_Pages();
        $homepage = $pagesModel->getHomePageInfo();

        $this->view->keywords = $homepage['keywords'];
        $this->view->description = $homepage['description'];
        $this->view->text = $homepage['text'];
    }

    public function aboutAction()
    {
        $pagesModel = new Application_Model_DbTable_Pages();
        $homepage = $pagesModel->getAboutPageInfo();

        $this->view->keywords = $homepage['keywords'];
        $this->view->description = $homepage['description'];
        $this->view->text = $homepage['text'];
    }

    public function servicesAction()
    {
        $this->view->imagesPath = Zend_Registry::get('myimages');

        $servicesModel = new Application_Model_DbTable_Services();
        $this->view->services = $servicesModel->getAllServices();
    }

    public function contactsAction()
    {
        $this->view->headScript()->appendFile('//www.google.com/recaptcha/api.js');
        $this->view->addHelperPath(APPLICATION_PATH . '/../vendor/wendrowycz/zf1-recaptcha-2/src/Cgsmith/View/Helper/', 'Cgsmith\\View\\Helper');

        $contactForm = new Application_Form_Contacts();

        $message = new Zend_Session_Namespace('message');

        if ($this->_request->isPost() && $contactForm->isValid($this->_request->getPost())) {

            $mail = new Zend_Mail('utf-8');
            $mail->setBodyHtml('Вам пришло письмо от ' . $contactForm->getValue('email') . '<br /><br />' . $contactForm->getValue('text'))
                 ->addTo('Почта2')
                 ->setSubject('Контактная форма');

            if (APPLICATION_ENV == 'development') {
                $config = array(
                    'auth' => 'login',
                    'username' => 'Почта1',
                    'password' => 'пароль',
                    'ssl' => 'tls'
                );

                $connection = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            }

            try {
                if (APPLICATION_ENV == 'development') $mail->send($connection);
                else $mail->send();

                $message->m = '<p>Сообщение было отправлено. Спасибо!</p>';

                $this->_helper->redirector->gotoUrl('/contacts');

            } catch (Exception $e) {
                $message->m = '<p>Во время отправки возникла ошибка.</p>';
            }
        }

        $this->view->message = $message->m;
        $this->view->contactForm = $contactForm;
    }

    public function viewFullServiceAction()
    {
        $id = $this->_request->getParam('id');

        $this->view->navigation()->findOneById('services')->setActive(true);

        $servicesModel = new Application_Model_DbTable_Services();
        $this->view->service = $servicesModel->getServiceById($id);
    }


}









