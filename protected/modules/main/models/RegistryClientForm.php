<?php

//Модель регестрации юриста
class RegistryClientForm extends CFormModel
{
    public $name;
    public $city;
    public $email;
    public $phone;
    public $password;

    public function rules()
    {
        //TODO Добавить остальную валидацию
        return array(
            array('name, email, phone, city, password', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'attributeName'=>'login','className'=>'User','message'=>'Такий email вже існує'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>"Ім'я",
            'email'=>'Email',
            'city'=>'Город',
            'phone'=>'Телефон',
            'password'=>'Пароль',
        );
    }
}
