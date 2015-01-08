<?php

class LeadControlForm extends CFormModel
{
    public $cost;
    public $data_success;
    //public $type_work = array('online','online&offline','offline');
    public $type_work = 'online';
    public $id_lead;

    public function rules()
    {
        return array(
            array('cost, data_success, type_work, id_lead', 'required'),
            array('cost', 'numerical','integerOnly'=>true, 'min'=>0, 'max'=>50000,'tooSmall'=>'Невірне значення','tooBig'=>'Дуже велика цифра'),
            array('data_success', 'numerical','integerOnly'=>true, 'min'=>0, 'max'=>336,'tooSmall'=>'Невірне значення','tooBig'=>'Дуже велика цифра'),
            array('id_lead', 'exist', 'attributeName'=>'id','className'=>'Lead','message'=>'Ошибка'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'cost'=>"Вартість послуги",
            'data_success'=>'Срок виконання',
            'type_work'=>'Тип діяльності',
        );
    }
}
