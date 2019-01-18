<?php

class Application_Form_Page extends Zend_Form
{

    public function init()
    {
        $id = new Zend_Form_Element_Hidden('id');

        $keywords = new Zend_Form_Element_Text('keywords');
        $keywords->setLabel('Ключевые слова:')
                 ->setAttrib('style', "width:100%");

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Описание:');

        $text = new Zend_Form_Element_Textarea('text');
        $text->setLabel('Текст страницы:');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить');

        $this->addElements(array($id , $keywords, $description, $text, $submit));
    }


}

