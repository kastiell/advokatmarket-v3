<?php

class TestForm extends CFormModel
{
    public $test;

    public function rules()
    {
        return array(
            array('test', 'required'),
            array('test', 'length', 'min'=>1, 'max'=>100,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'test'=>"Ім'я",
        );
    }
}
