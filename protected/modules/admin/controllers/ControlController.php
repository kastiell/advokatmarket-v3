<?php

class ControlController extends Controller
{
	public function actionActivateLawyer($id_lawyer)
	{
        $lawyer_option = LawyerOptions::model()->findByPk($id_lawyer);
        if(($lawyer_option !== null)&&($lawyer_option->success_profile == 'activate')){
            $lawyer_option->success_profile = 'activate';
            $user = User::model()->findByPk($id_lawyer);
            $user->role = 'lawyer';
            if($user->save(true)&&$lawyer_option->save(true)){
                Yii::app()->user->setFlash('edit-status',"Заявка прийнята");
                Yii::app()->request->redirect(CController::createUrl('/admin/views/activate'));
            }
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
	}

    public function actionOpenLead($id_lead){

        $model = new ActivateForm;
        if(isset($_POST['ajax']) && $_POST['ajax']==='open-admin-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['ActivateForm'])){

            $model->attributes = $_POST['ActivateForm'];
            $id_lead = $model->id_lead;

            $lead = Lead::model()->findByPk($id_lead);
            $lead->status = 'list';
            $lead->title_ask = $model->title_ask;
            $lead->cost_lead = $model->cost_lead;

            if($lead->save(true)){
                Yii::app()->user->setFlash('edit-status',"Заявка ".$id_lead." активована");
                Yii::app()->request->redirect(CController::createUrl('/admin/views/activateLead'));
            }
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }

        $model->id_lead = $id_lead;
        $lead = Lead::model()->findByPk($id_lead);
        $this->layout='/layouts/adminPanel';
        $this->render('openLead',array('lead'=>$lead,'model'=>$model));
    }

    public function actionDeactivateLead($id_lead){
        $lead = Lead::model()->findByPk($id_lead);
        $lead->status = 'cancel';
        if(($lead->direct == 1)&&($lead->id_request_lead != 0)){
            $request_lead = RequestLead::model()->findByPk($lead->id_request_lead);
            $request_lead->status = 'cancel';
            $request_lead->time_cancel = time();
            $request_lead->save();
        }
        $lead->save(true);
        Yii::app()->user->setFlash('edit-status',"Заявка ".$id_lead." відмінена");
        Yii::app()->request->redirect(CController::createUrl('/admin/views/activateLead'));
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
                'actions'=>array('ActivateLawyer','OpenLead','DeactivateLead'),
                'roles'=>array(
                    User::ADMIN
                )
            ),
            array('deny',
                'actions'=>array('ActivateLawyer','OpenLead','DeactivateLead'),
                'users'=>array('*')
            ),
        );
    }
}


















