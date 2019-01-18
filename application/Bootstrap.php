<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initView()
    {
        $this->bootstrap('layout');
        $view = $this->getResource('layout')->getView();

        $view->doctype('XHTML1_TRANSITIONAL');

        $view->headTitle('IT Центр')
             ->setSeparator(' - ');

        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
                         ->appendName('author', 'Evgeniy Poliakov');

        $view->headLink()->appendStylesheet('/css/style.css', 'screen, projection');


    }

    protected function _initRouter()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $home = new Zend_Controller_Router_Route_Static(
            'home',
            array(
                'controller' => 'index',
                'action' => 'index'
            )
        );

        $about = new Zend_Controller_Router_Route_Static(
            'about',
            array(
                'controller' => 'index',
                'action' => 'about'
            )
        );

        $services = new Zend_Controller_Router_Route_Static(
            'services',
            array(
                'controller' => 'index',
                'action' => 'services'
            )
        );

        $fullService = new Zend_Controller_Router_Route(
            'services/:id',
            array(
                'controller' => 'index',
                'action' => 'view-full-service'
            )
        );

        $contacts = new Zend_Controller_Router_Route_Static(
            'contacts',
            array(
                'controller' => 'index',
                'action' => 'contacts'
            )
        );

        $login = new Zend_Controller_Router_Route_Static(
            'login',
            array(
                'controller' => 'auth',
                'action' => 'index'
            )
        );

        $logout = new Zend_Controller_Router_Route_Static(
            'logout',
            array(
                'controller' => 'auth',
                'action' => 'logout'
            )
        );

        $router->addRoutes(array(
            'home' => $home,
            'about' => $about,
            'services' => $services,
            'contacts' => $contacts,
            'fullService' => $fullService,
            'login' => $login,
            'logout' => $logout
        ));
    }

    protected function _initNavigation()
    {
        $this->bootstrap('layout');
        $view = $this->getResource('layout')->getView();

        $pages = array(
            array(
                'label' => 'Главная',
                'route' => 'home'
            ),
            array(
                'label' => 'О нас',
                'route' => 'about'
            ),
            array(
                'label' => 'Услуги',
                'route' => 'services',
                'id'    => 'services'
            ),
            array(
                'label' => 'Контакты',
                'route' => 'contacts'
            )
        );

        $navigation = new Zend_Navigation($pages);
        $view->navigation($navigation);
        $view->navigation()->menu()->setPartial('menu.phtml');
    }

    protected function _initHelper()
    {
        $this->bootstrap('layout');
        $view = $this->getResource('layout')->getView();

        $view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Application_View_Helper');

        Zend_Controller_Action_HelperBroker::addPath(
            APPLICATION_PATH . '/controllers/helpers',
            'Application_Controller_Helper'
        );
    }

    protected function _initConfig()
    {
        Zend_Registry::set('myimages', $this->getOption('myimages'));
        Zend_Registry::set('reCaptchaPublic', $this->getOption('reCaptchaPublic'));
        Zend_Registry::set('reCaptchaPrivate', $this->getOption('reCaptchaPrivate'));
    }

}

