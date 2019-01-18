<?php
class Application_Controller_Helper_FormatDate extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array)
    {
        $en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $ru = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь', );

        $count = count($array);
        for ($i=0; $i<$count; $i++) {
            $array[$i]['date'] = str_replace($en, $ru, date('F j, Y', strtotime($array[$i]['date'])));
        }

        return $array;
    }
}