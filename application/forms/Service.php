<?php

class Application_Form_Service extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');

        $id = new Zend_Form_Element_Hidden('id');

        $keywords = new Zend_Form_Element_Text('keywords');
        $keywords->setLabel('Ключевые слова:')
                 ->setAttrib('style', 'width:100%');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Описание:');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Название услуги:')
            ->setAttrib('style', 'width:100%');

        $text = new Zend_Form_Element_Textarea('text');
        $text->setLabel('Текст:');

        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Превью:')
              ->setDestination(Zend_Registry::get('myimages'))
              ->addValidator('Extension', true,
                  array(
                      'extension' => 'jpg,gif,png',
                      'messages' => array('fileExtensionFalse' => 'Загружать можно только jpg, gif и png')
                  )
              )
              ->addValidator('ImageSize', true,
                  array(
                      'maxwidth' => '100',
                      'maxheight' => '100',
                      'messages' => array(
                          'fileImageSizeWidthTooBig' => 'Ширина изображения не должна быть больше 100px',
                          'fileImageSizeHeightTooBig' => 'Высота изображения не должна быть больше 100px'
                      )
                  )
              );

        $submit = new Zend_Form_Element_Submit('submit');

        $this->addElements(array($id, $keywords, $description, $title, $text, $image, $submit));
    }


}

