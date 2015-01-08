<?php

/*
 * Контроллер відповідає за відображення ленти юриста
 */

class LTapeController extends Controller
{
    public function  actionT1(){

        $dataProvider = new CActiveDataProvider('Lead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'condition'=>"status = 'list' AND direct = 0",
            )
        ));

        $this->layout='/layouts/panelLawyer';
        $this->render('t1',array('dataProvider'=>$dataProvider));
    }

public function  actionT2t(){

        $dataProvider = new CActiveDataProvider('RequestLead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'join'=>"JOIN tbl_lead v ON v.status != 'make' AND v.id_request_lead = t.id",
                'condition'=>"t.status = 'expected' AND t.direct = 1 AND t.id_lawyer = :lawyer",
                'params'=>array(':lawyer'=>Yii::app()->user->getId()),
            )
        ));

        $this->layout='/layouts/panelLawyer';
        //$this->layout='/lTape/layouts/panelTopT2';
        $this->render('t2t',array('dataProvider'=>$dataProvider));
    }

    public function  actionT2f(){

        $dataProvider = new CActiveDataProvider('RequestLead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'condition'=>"status = 'expected' AND direct = 0 AND id_lawyer = :lawyer",
                'params'=>array(':lawyer'=>Yii::app()->user->getId()),
            )
        ));

        //$this->layout='/lTape/layouts/panelTopT2';
        $this->layout='/layouts/panelLawyer';
        $this->render('t2f',array('dataProvider'=>$dataProvider));
    }

    public function  actionT3(){

        $dataProvider = new CActiveDataProvider('Lead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'join'=>'JOIN tbl_request_lead v ON v.id_lawyer = :lawyer AND v.id_lead = t.id',
                'condition'=>"t.status = 'accepted' OR t.status = 'process'",
                'params'=>array(':lawyer'=>Yii::app()->user->getId())
            )
        ));

        $this->layout='/layouts/panelLawyer';
        $this->render('t3',array('dataProvider'=>$dataProvider));
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('T1','T2t','T2f','T3'),
                'roles'=>array(
                    User::LAWYER
                )
            ),
            array('allow',
                'actions'=>array('T3'),
                'roles'=>array(
                    User::DLAWYER
                )
            ),
            array('deny',
                'actions'=>array('T1','T2t','T2f','T3'),
                'users'=>array('*')
            ),
        );
    }
}