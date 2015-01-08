<?php

class ContactLawyerForm extends CFormModel
{
    public $city;
    public $street;
    public $apartment;
    public $phone;
    public $site;

    public function rules()
    {
        //TODO Добавить остальную валидацию
        //TODO В соответствии с локализацией проверять город
        return array(
            //array('city, street, apartment, phone, site', 'required'),
            array('street, apartment, phone, site', 'length', 'min'=>2, 'max'=>100,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('city', 'exist', 'attributeName'=>'city_ru','className'=>'LocatedCity','message'=>'Такого города не существует'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'city'=>"Город",
            'street'=>'Улица',
            'apartment'=>'Офис(Квартира)',
            'phone'=>'Телефон',
            'site'=>'Сайт'
        );
    }
}
