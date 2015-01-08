<?php

class ChLoginLawyerForm extends CFormModel
{
    public $email;
    public $password_old;
    public $password;
    public $password_repeat;


    public function rules()
    {
        Yii::import('application.components.validators.email2email');
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'email2email'),
            //array('email', 'unique', 'attributeName'=>'login','className'=>'User','message'=>'Такий email вже існує'),
            array('password, password_repeat', 'length', 'min'=>6, 'max'=>30,'tooShort'=>'Пароль повинен мати мінімально 6 символів','tooLong'=>'Пароль повинен мати максимально 30 символів'),
            array('password_repeat', 'compare', 'compareAttribute'=>'password','message'=>'Паролі не співпадають'),
            array('password_old', 'in', 'range'=>array('',User::model()->findByPk(Yii::app()->user->getId())->password)),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email'=>"Email",
            'password_old'=>'Старый пароль',
            'password'=>'Новый пароль',
            'password_repeat'=>'Еще раз'
        );
    }
}
