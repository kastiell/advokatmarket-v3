<?php

class GeneralLawyerForm extends CFormModel
{
    public $name;
    public $first_name;
    public $last_name;
    public $type_work;
    public $exp;
    public $spec;

    public function rules()
    {
        return array(
            //array('name, first_name, last_name, type_work, exp, spec', 'required'),
            array('name, first_name, last_name', 'length', 'min'=>2, 'max'=>50,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('exp', 'length', 'min'=>30, 'max'=>200,'tooShort'=>'Мало символів','tooLong'=>'Багато символів'),
            array('type_work', 'in', 'range'=>array('lawyer','notary','advocate'),'message'=>'Значення не співпадає'),
            array('spec','safe'),
            //TODO Добавить специализацию (новый список)
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>"Имя",
            'first_name'=>'Фамилия',
            'last_name'=>'Отчество',
            'type_work'=>'Тип деятельности',
            'exp'=>'Опыт',
            'spec'=>'Специализация (не больше 3-х)',
        );
    }
}
