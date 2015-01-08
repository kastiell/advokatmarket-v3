<?php

//Модель регестрации юриста
class RegistryLawyerForm extends CFormModel
{
    public $name;
    public $first_name;
    public $email;
    public $phone;

    public function rules()
    {
        //TODO Добавить остальную валидацию
        return array(
            array('name, first_name, email, phone', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'attributeName'=>'login','className'=>'User','message'=>'Такий email вже існує'),
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
