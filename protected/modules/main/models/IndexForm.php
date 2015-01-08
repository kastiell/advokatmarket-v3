<?php

class IndexForm extends CFormModel
{
    public $ask;
    public $name;
    public $email;
    public $phone;
    public $city;
    public $type_ask; //Есть такие значения: simple,detail,support
    public $pass;
    public $pass_hidden = 0;

    public function rules()
    {
        return array(
            array('ask, name, email, phone, city, type_ask', 'required','on'=>'logout'),
            array('email', 'email','on'=>'logout'),
            array('pass', 'length','on'=>'logout', 'min'=>6, 'max'=>30,'tooShort'=>'Пароль повинен мати мінімально 6 символів','tooLong'=>'Пароль повинен мати максимально 30 символів'),
            array('ask, name, phone', 'length','on'=>'logout', 'min'=>2, 'max'=>1000,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('city', 'exist','on'=>'logout', 'attributeName'=>'city_ua','className'=>'LocatedCity','message'=>'Такого города не существует'),
            array('email', 'unique','on'=>'logout', 'attributeName'=>'login','className'=>'User','message'=>'Такий email вже існує'),
            array('ask', 'length','on'=>'login', 'min'=>2, 'max'=>1000,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('ask, type_ask', 'required','on'=>'login'),
            array('ask, name, email, phone, city, type_ask, pass_hidden', 'safe','on'=>'logout, login'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>"Ім'я",
            'first_name'=>'Прізвище',
            'email'=>'Email',
            'phone'=>'Телефон',
        );
    }
}
