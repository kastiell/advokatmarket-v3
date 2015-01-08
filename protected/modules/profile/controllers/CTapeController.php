<?php

/*
 * Контроллер відповідає за відображення ленти клієнта
 */

class CTapeController extends Controller
{
    public function  actionT1(){
        $dataProvider = new CActiveDataProvider('Lead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'condition'=>"(status = 'list') AND id_client = :client AND direct = 0",
                'params'=>array(':client'=>Yii::app()->user->getId())
            )
        ));

        $this->layout='/layouts/panelClient';
        $this->render('t1',array('dataProvider'=>$dataProvider));
    }

    public function  actionT2(){

        $dataProvider = new CActiveDataProvider('RequestLead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'join'=>'INNER JOIN tbl_lead v ON v.id = t.id_lead AND (v.status = "success" OR v.status = "list")',
                'condition'=>"v.id_client = :client AND (t.status = 'accepted' OR (t.status = 'expected' AND t.direct = 0)) AND t.id_lawyer != 0",
                'params'=>array(':client'=>Yii::app()->user->getId())
            )
        ));

        $this->layout='/layouts/panelClient';
        $this->render('t2',array('dataProvider'=>$dataProvider));
    }

    public function  actionT3(){

        $dataProvider = new CActiveDataProvider('Lead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'condition'=>"id_client = :client AND (status = 'accepted' OR status = 'process')",
                'params'=>array(':client'=>Yii::app()->user->getId())
            )
        ));

        $this->layout='/layouts/panelClient';
        $this->render('t3',array('dataProvider'=>$dataProvider));
    }
/*
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
                'actions'=>array('T1','T2','T3'),
                'roles'=>array(
                    User::CLIENT
                )
            ),
            array('deny',
                'actions'=>array('T1','T2','T3'),
                'users'=>array('*')
            ),
        );
    }
*/
}