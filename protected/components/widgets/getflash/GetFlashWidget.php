<?php

//Виджет для отображения flash
//flash-name - имя флеша
//style-class - название css класса со стилем оформления
class GetFlashWidget extends CWidget{

    private $params = array(
        'flash-name'=>'edit-status',
        'style-class'=>'edit-flash-block',
        'text'=>null,
        'show'=>false
    );

    public function setParams($params) {
        $this->params = array_merge($this->params, $params);
    }

    public function run(){
        $this->render('getFlashWidget',array('params'=>$this->params));
    }
}