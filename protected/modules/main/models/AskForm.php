<?php

class AskForm extends CFormModel
{
    public $ask;
    public $name;
    public $email;
    public $phone;
    public $city;
    public $type_ask = 'simple'; //Есть такие значения: simple,detail,support
    public $pass;
    public $pass_hidden = 0;
    public $id_user = 0;

    public function rules()
    {
        return array(
            array('ask, name, email, phone, city, type_ask', 'required','on'=>'guest=true&step=1 guest=true&step=new'),
            array('email', 'email','on'=>'guest=true&step=1 guest=true&step=new'),
            array('ask, name, phone', 'length','on'=>'guest=true&step=1 guest=true&step=new', 'min'=>2, 'max'=>1000,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('city', 'exist','on'=>'guest=true&step=1 guest=true&step=new', 'attributeName'=>'city_ru','className'=>'LocatedCity','message'=>'Такого города не существует'),
            array('email', 'unique','on'=>'guest=true&step=1 guest=true&step=new', 'attributeName'=>'login','className'=>'User','message'=>'Такий email вже існує'),

            array('ask', 'length','on'=>'guest=false&step=1 guest=false&step=new', 'min'=>2, 'max'=>1000,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('type_ask, ask', 'required','on'=>'guest=false&step=1 guest=false&step=new'),

            array('type_ask', 'required','on'=>'guest=true&step=2 guest=true&step=new'),


            array('pass, pass_hidden', 'length','on'=>'guest=true&step=3', 'min'=>6, 'max'=>60,'tooShort'=>'Пароль повинен мати мінімально 6 символів','tooLong'=>'Пароль повинен мати максимально 30 символів'),
            array('id_user', 'exist','on'=>'guest=true&step=3','attributeName'=>'id','className'=>'User','message'=>'Такого id не существует'),
            //array('ask, name, email, phone, city, type_ask, pass_hidden', 'safe','on'=>'logout, login'),
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
