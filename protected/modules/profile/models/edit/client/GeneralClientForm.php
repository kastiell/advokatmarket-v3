<?php

class GeneralClientForm extends CFormModel
{
    public $name;
    public $phone;
    public $city;

    public function rules()
    {
        return array(
            array('name, phone', 'length', 'min'=>2, 'max'=>50,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('city', 'exist', 'attributeName'=>'city_ru','className'=>'LocatedCity','message'=>'Такого города не существует'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>"Имя",
            'phone'=>'Телефон',
            'city'=>'Город',
        );
    }
}
