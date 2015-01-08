<?php

class ViewsController extends Controller
{
    public function actionUsers(){

        $dataProvider = new CActiveDataProvider('User',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));

        $this->layout='/layouts/adminPanel';
        $this->render('users',array('dataProvider'=>$dataProvider));
    }

    public function actionActivate(){
        $dataProvider = new CActiveDataProvider('LawyerOptions',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'with' => array('lawyer'),
                'condition'=>"success_profile = 'activate' AND lawyer.role != 'lawyer'",
            )
        ));

        $this->layout='/layouts/adminPanel';
        $this->render('activate',array('dataProvider'=>$dataProvider));
    }

    public function actionActivateLead(){
        $dataProvider = new CActiveDataProvider('Lead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'with' => array('lead_client'),
                'condition'=>"status = 'make'",
            )
        ));

        $this->layout='/layouts/adminPanel';
        $this->render('activateLead',array('dataProvider'=>$dataProvider));
    }

    public function actionDeactiveRqstLead(){

        $day = 0*Yii::app()->params['day2pay']; //Кількість днів до відображення ліду в адмінці

        $dataProvider = new CActiveDataProvider('Lead',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'with' => array('lead_client','lead_request'),
                'condition'=>"t.status = 'accepted' AND t.time_accepted < ".(time() - $day*3600*24),
            )
        ));

        $this->layout='/layouts/adminPanel';
        $this->render('deactiveRqstLead',array('dataProvider'=>$dataProvider));


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
                'actions'=>array('Users','Activate','ActivateLead','DeactiveRqstLead'),
                'roles'=>array(
                    User::ADMIN
                )
            ),
            array('deny',
                'actions'=>array('Users','Activate','ActivateLead','DeactiveRqstLead'),
                'users'=>array('*')
            ),
        );
    }
}