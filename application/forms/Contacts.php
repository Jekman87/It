<?php

class Application_Form_Contacts extends Zend_Form
{

    public function init()
    {
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email:')
              ->setRequired(true)
              ->addValidator('NotEmpty', true,
                  array('messages' => array('isEmpty' => 'Введите email'))
              )
              ->addValidator('EmailAddress', true,
                  array('messages' => array('emailAddressInvalidFormat' => 'Введите правильный email'))
              );

        $text = new Zend_Form_Element_Textarea('text');
        $text->setLabel('Сообщение:')
             ->setRequired(true)
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => 'Введите сообщение'))
            );

        $this->addPrefixPath('Cgsmith\\Form\\Element', APPLICATION_PATH . '/../vendor/wendrowycz/zf1-recaptcha-2/src/Cgsmith/Form/Element/', Zend_Form::ELEMENT);
        $this->addElementPrefixPath('Cgsmith\\Validate\\', APPLICATION_PATH . '/../vendor/wendrowycz/zf1-recaptcha-2/src/Cgsmith/Validate/', Zend_Form_Element::VALIDATE);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Отправить');

        $this->addElements(array($email, $text));

        $this->addElement('Recaptcha', 'g-recaptcha-response', array(
            'siteKey'   => Zend_Registry::get('reCaptchaPublic'),
            'secretKey' => Zend_Registry::get('reCaptchaPrivate'),
        ));

        $this->addElement($submit);
    }


}

