<?php

//<?php $this->widget('application.components.widgets.translateCity.TranslateCityWidget',array('params'=>array('city'=>$lawyer->city,'lang'=>'ru')));? >

//Виджет берет название города который лежит в базе и переводит на нужный язык
// lang - язык НА КОТОРЫЙ НУЖНО перевести по умолчанию = ru
// separator ->
//   null - Просто вывести город,
//   word - Вывести сокращение (Укр(м.),Рус(г.))
//   Остальное добавить по надобности

class TranslateCityWidget extends CWidget{

    private $params = array(
        'city'=>null,
        'lang'=>'ru',
        'separator'=>'word',
    );

    public function setParams($params){
        $this->params = array_merge($this->params, $params);
    }

    public function run(){
        //TODO КРИВО исправить здесь
        if($this->params['city']==null){
            //throw new CHttpException(404, 'Нет что переводить');
            //Yii::app()->end();
            return '';
        }

        $lang = $this->params['lang'];
        $dlang = $lang == 'ua' ? 'ru' : 'ua';
        $t='';
        if($this->params['separator'] == 'word'){
            $t = $lang == 'ru' ? 'г. ':'м. ';
        }
        $locatedCity = LocatedCity::model()->findByAttributes(array('city_'.$dlang=>$this->params['city']));
        if($locatedCity===null){ //Если нет что переводить
            $city = $t.$this->params['city'];
        }else{
            $city = (array)$locatedCity->attributes;
            $city = $t.$city['city_'.$lang];
        }
        $this->render('translateCityWidget',array('city'=>$city));
    }
}