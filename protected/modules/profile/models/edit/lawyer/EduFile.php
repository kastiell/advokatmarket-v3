<?php

class EduFile extends CFormModel
{
    public $file;

    public function rules()
    {
        return array(
            //array('file', 'required'),
            array('file', 'file','types'=>'jpg, gif, png','maxSize'=>5242880),
        );
    }

    public function attributeLabels()
    {
        return array(
            'file'=>'Диплом'
        );
    }
}
