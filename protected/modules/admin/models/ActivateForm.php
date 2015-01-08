<?php

class ActivateForm extends CFormModel
{
    public $title_ask;
    public $cost_lead;
    public $id_lead;

    public function rules()
    {
        return array(
            array('cost_lead, title_ask, id_lead', 'required'),
            array('cost_lead', 'numerical','integerOnly'=>true, 'min'=>0, 'max'=>50000,'tooSmall'=>'Невірне значення','tooBig'=>'Дуже велика цифра'),
            array('title_ask', 'length', 'min'=>1, 'max'=>300,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('id_lead', 'exist', 'attributeName'=>'id','className'=>'Lead','message'=>'Ошибка'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'cost_lead'=>"Вартість ліду",
            'title_ask'=>'Назва питання',
        );
    }
}
