<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Логин:')
                 ->setRequired(true)
                 ->addValidator('NotEmpty', true,
                     array('messages' => array('isEmpty' => 'Введите логин'))
                 );

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Пароль:')
            ->setRequired(true)
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => 'Введите пароль'))
            );

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Войти в систему');

        $this->addElements(array($username, $password, $submit));
    }


}

