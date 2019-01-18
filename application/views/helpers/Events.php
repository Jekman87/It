<?php
class Application_View_Helper_Events extends Zend_View_Helper_Abstract
{
    public function events()
    {
        $eventsModel = new Application_Model_DbTable_Events();

        $html = '';

        $events = Zend_Controller_Action_HelperBroker::getStaticHelper('FormatDate')->direct($eventsModel->getAllEvents());

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $url = $this->view->url(array('controller' => 'edit-content', 'action' => 'add-event'), 'default');
            $html .= '<p class="aligncenter"><a href="' . $url . '">Добавить событие</a></p>';
        }

        $html .= '<ul>';
        $html .= $this->view->partialLoop('partial-loops/event.phtml', $events);
        $html .= '</ul>';

        return $html;
    }
}