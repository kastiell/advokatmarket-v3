<?php

class EduLawyerForm extends CFormModel
{
    public $country;
    public $city_edu;
    public $vnz;
    public $faculty;
    public $year_leave;

    public function rules()
    {
        //TODO Добавить остальную валидацию
        //TODO В соответствии с локализацией проверять город
        return array(
            //array('country, city_edu, vnz, faculty, year_leave', 'required'),
            //array('city_edu', 'exist', 'attributeName'=>'city_ru','className'=>'LocatedCity','message'=>'Такого города не существует'),
            array('vnz, faculty', 'length', 'min'=>2, 'max'=>100,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            //array('country, city_edu, vnz, faculty', 'length', 'min'=>2, 'max'=>100,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('year_leave', 'numerical','integerOnly'=>true, 'min'=>1900, 'max'=>2100,'tooSmall'=>'Мала дата','tooBig'=>'Велика дата'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'country'=>"Страна",
            'city_edu'=>'Город',
            'vnz'=>'ВУЗ',
            'faculty'=>'Факультет',
            'year_leave'=>'Год выпуска'
        );
    }
}
