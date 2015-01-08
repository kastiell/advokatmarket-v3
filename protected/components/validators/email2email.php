<?php

//Валидатор проверяет есть ли в базе такой email но не выдает ощибку если email равен сам себе
//вызов array('email', 'email2email'),
// http://phptime.ru/yii/perevod-sozdanie-svoego-pravila-validacii-validation-rule.html
// Yii::import('application.components.validators.email2email');
class email2email extends CValidator{
    protected function validateAttribute($object,$attribute){
        $user = User::model()->findByAttributes(array('login'=>$object->$attribute));
        $userThis = User::model()->findByPk(Yii::app()->user->getId());
        if($user !== null)
            if($user->login !== $userThis->login)
                $this->addError($object,$attribute,'Такой email уже существует');
    }
}