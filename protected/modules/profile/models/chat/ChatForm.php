<?php

class ChatForm extends CFormModel
{
    public $pay_cost;
    public $txt;

    public function rules()
    {
        return array(
            array('pay_cost', 'required','on'=>'pay'),
            array('pay_cost', 'numerical','integerOnly'=>true, 'min'=>1, 'max'=>50000,'on'=>'pay','tooSmall'=>'Невірне значення','tooBig'=>'Дуже велика цифра'),

            array('txt', 'required','on'=>'reviews'),
            array('txt', 'length','on'=>'reviews', 'min'=>6, 'max'=>30,'tooShort'=>'6 символів','tooLong'=>'30 символів'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'pay_cost'=>"pay_cost",
            'txt'=>"txt",
        );
    }
}
