<?php

class Application_Form_Event extends Zend_Form
{

    public function init()
    {
        $id = new Zend_Form_Element_Hidden('id');

        $text = new Zend_Form_Element_Textarea('text');
        $text->setLabel('Текст события:')
             ->addValidator('NotEmpty', true,
                 array('message' => array('isEmpty' => 'Введите текст события'))
             );

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить');

        $this->addElements(array($id, $text, $submit));
    }


}

