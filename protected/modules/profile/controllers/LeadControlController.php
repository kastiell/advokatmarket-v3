<?php

/*
 * Контроллер відповідає за роботу з лідами іх активацією, відміною і тд...
 * Бажано в майбутньому переписати всі дії з застосуванням влістивості with, тобто з застосуванням relations  між таблицями.
 */

class LeadControlController extends Controller
{
    public $mode;

    public function  actionLInfo($id_lead){
        if(isset($_GET['id_request'])&&!empty($_GET['id_request'])){
            $id_request = (int)$_GET['id_request'];
        }

        $this->mode = 'no_request';

        $model = new LeadControlForm;
        $lead = Lead::model()->findByPk($id_lead);

        if(isset($_POST['ajax']) && $_POST['ajax']==='box-description-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LeadControlForm']))
        {
            $model->attributes=$_POST['LeadControlForm'];
            if($model->validate()){
                $lead_self = Lead::model()->findByPk($model->id_lead);
                if($lead_self->direct == 0){
                    $request_lead = new RequestLead;
                    $request_lead->id_lead = $model->id_lead;
                    $request_lead->id_lawyer = Yii::app()->user->getId();
                    $request_lead->status = 'expected';
                    $request_lead->time_expected = time();
                    $request_lead->cost_service = $model->cost;
                    $request_lead->deadline = $model->data_success;
                    if($request_lead->save()){
                        Yii::app()->user->setFlash('edit-status', "Заявка відправлена");
                        $this->refresh();
                    }
                }else{
                    $request_lead = RequestLead::model()->findByPk($lead_self->id_request_lead);
                    $request_lead->status = 'accepted';
                    $request_lead->time_accepted = time();
                    $request_lead->cost_service = $model->cost;
                    $request_lead->deadline = $model->data_success;
                    $lead_self->status = 'success';
                    $lead_self->time_success = time();
                    if($request_lead->save()&&$lead_self->save()){
                        Yii::app()->user->setFlash('edit-status',"Заявка прийнята");
                        $this->refresh();
                    }
                }
            }
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }

        $request_lead = RequestLead::model()->findByAttributes(array('id_lead'=>$id_lead,'id_lawyer'=>Yii::app()->user->getId()),array('condition'=>'status != "cancel"'));
        if($request_lead !== null){

            //die($request_lead->status);

            if(($request_lead->status == 'accepted')&&($request_lead->direct == 1))
                $this->mode = 'exist_request';
            if(($request_lead->status == 'expected')&&($request_lead->direct == 0))
                $this->mode = 'exist_request';
        }

        if($request_lead->status == 'accepted'){
            $this->mode = 'chat_open';
        }

        $this->layout='/layouts/panelLawyer';
        $model->id_lead = $id_lead;
        $this->render('linfo',array('lead'=>$lead,'model'=>$model));
    }

    public function actionCInfo(){
        $id_lead = 0;
        $id_request = 0;
        $lead = null;
        $request = null;
        if(isset($_GET['id_lead'])&&!empty($_GET['id_lead'])){
            $id_lead = (int)$_GET['id_lead'];
        }
        if(isset($_GET['id_request'])&&!empty($_GET['id_request'])){
            $id_request = (int)$_GET['id_request'];
        }

        if($id_request != 0){
            $request = RequestLead::model()->findByPk($id_request);
            if($request !== null){
                $id_lead = $request->id_lead;
                $lead = Lead::model()->findByAttributes(array('id'=>$id_lead,'id_client'=>Yii::app()->user->getId()));
            }else{
                throw new CHttpException(400, 'Помилка');
                Yii::app()->end();
            }
            $mode = 'request';
        }else if($id_lead != 0){
            $lead = Lead::model()->findByAttributes(array('id'=>$id_lead,'id_client'=>Yii::app()->user->getId()));
            $mode = 'lead';
        }else{
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }

        $this->layout='/layouts/panelClient';
        $this->render('cinfo',array('data'=>$lead,'request'=>$request,'mode'=>$mode));
    }

    //Відмінити новостворений ще не активований лід
    public function actionCCnlMake($id_lead){
        $lead = Lead::model()->findByPk($id_lead);
        $lead->status = 'cancel';
        $lead->time_cancel = time();
        if($lead->save(true)){
            Yii::app()->user->setFlash('edit-status',"Заявка відмінена");
            Yii::app()->request->redirect(CController::createUrl('/profile/ctape/t1'));
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Відмінити заявку юриста на лід користувача
    public function actionLCnlRqst($id_lead){
        $lead = Lead::model()->findByPk($id_lead);
        $request_lead = RequestLead::model()->findByAttributes(array('id_lead'=>$lead->id,'id_lawyer'=>Yii::app()->user->getId()));
        $request_lead->status = 'cancel';
        $request_lead->time_cancel = time();
        if($request_lead->save(true)){
            Yii::app()->user->setFlash('edit-status',"Заявка відмінена");
            Yii::app()->request->redirect($_SERVER['HTTP_REFERER']);
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Клієнт відміняє заяву юриста на лід
    public function actionCCnlRqst($id_request){
        $request_lead = RequestLead::model()->findByPk($id_request);
        $lead = Lead::model()->findByAttributes(array('id'=>$request_lead->id_lead,'id_client'=>Yii::app()->user->getId()));
        if($lead !== null){
            $request_lead->status = 'cancel';
            $request_lead->time_cancel = time();
            if($request_lead->save(true)){
                Yii::app()->user->setFlash('edit-status',"Заявка відмінена");
                Yii::app()->request->redirect(CController::createUrl('/profile/ctape/t2'));
            }
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Юрист видаляє запит йому від клієнта
    public function actionLCnlRqstDirect($id_lead){
        $lead = Lead::model()->findByPk($id_lead);
        $request_lead = RequestLead::model()->findByAttributes(array('id_lead'=>$lead->id,'id_lawyer'=>Yii::app()->user->getId()));
        $request_lead->status = 'cancel';
        $request_lead->time_cancel = time();

        $lead->status = 'cancel';
        $lead->time_cancel = time();

        if($request_lead->save(true)&&$lead->save(true)){
            Yii::app()->user->setFlash('edit-status',"Заявка відмінена");
            Yii::app()->request->redirect(CController::createUrl('/profile/ltape/t1'));
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Клієнт відміняє свій лід
    public function actionCCnlLead($id_lead){
        $lead = Lead::model()->findByPk($id_lead);
        $lead->status = 'cancel';
        $lead->time_cancel = time();

        $request_lead = RequestLead::model()->findAllByAttributes(array('id_lead'=>$id_lead));
        if($request_lead !== null){
            $m = true;
            foreach($request_lead as $v){
                $v->status = 'cancel';
                $v->time_cancel = time();
                if(!$v->save(true)){
                    $m = false;
                }
            }

        }

        if($lead->save(true)&&$m){
            Yii::app()->user->setFlash('edit-status',"Заявка відмінена");
            Yii::app()->request->redirect(CController::createUrl('/profile/ctape/t1'));
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Клієнт приймає заявку яку він надсилав конкретному юристу
    public function actionCAcptDirect($id_request){
        Yii::import('main.controllers.RegistryController');

        $request_lead = RequestLead::model()->findByPk($id_request);
        $lead = Lead::model()->findByAttributes(array('id'=>$request_lead->id_lead),array('condition'=>'id_client = :client','params'=>array(':client'=>Yii::app()->user->getId())));
        $lead->status = 'accepted';
        $lead->time_accepted = time();
        $lead->link = RegistryController::generatePassword(32);

        if($lead->save(true)){

            Yii::app()->user->setFlash('edit-status',"Заявка прийнята");
            Yii::app()->request->redirect(CController::createUrl('/profile/CTape/T1'));
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Клієнт приймає заявку юриста всі інші заявки заморожуються
    public function actionCAcptRqst($id_request){
        Yii::import('main.controllers.RegistryController');

        $request_lead = RequestLead::model()->findByPk($id_request);
        $lead = Lead::model()->findByAttributes(array('id'=>$request_lead->id_lead),array('condition'=>'id_client = :client','params'=>array(':client'=>Yii::app()->user->getId())));
        $lead->status = 'accepted';
        $lead->time_accepted = time();
        $lead->id_request_lead = $id_request;

        $request_lead_1 = RequestLead::model()->findAllByAttributes(array('id_lead'=>$lead->id));
        if($request_lead_1 !== null){
            $m = true;
            foreach($request_lead_1 as $v){
                $v->status = 'frozen';
                $v->time_frozen = time();
                if(!$v->save(true)){
                    $m = false;
                }
            }
        }
        $request_lead->status = 'accepted';
        $request_lead->time_accepted = time();
        $lead->link = RegistryController::generatePassword(32);

        if($m&&$lead->save(true)&&$request_lead->save(true)){

            Yii::app()->user->setFlash('edit-status',"Заявка прийнята");
            Yii::app()->request->redirect(CController::createUrl('/profile/CTape/T1'));
        }
        throw new CHttpException(400, 'Помилка');
        Yii::app()->end();
    }

    //Після того як юрист оплатить лід потрібно викликати цей метод
    public function actionLPay($id_lead){
        Yii::import('profile.controllers.ChatController');
        $lead = Lead::model()->findByPk($id_lead);
        if($lead !== null){
            $request_lead = RequestLead::model()->findByAttributes(array('id'=>$lead->id_request_lead,'id_lawyer'=>Yii::app()->user->getId()));
            if($request_lead !== null){
                $request_lead->status = 'process';
                $request_lead->time_process = time();

                $lead->status = 'process';
                $lead->time_process = time();

                $lead->id_consultation = ChatController::createConsultation($lead->id_client);

                if($lead->save(true)&&$request_lead->save(true)){
                    Yii::app()->user->setFlash('edit-status',"Заявка оплачена");
                    Yii::app()->request->redirect(CController::createUrl('/profile/LTape/T3'));
                }
                throw new CHttpException(400, 'Помилка1');
                Yii::app()->end();
            }
            throw new CHttpException(400, 'Помилка2');
            Yii::app()->end();
        }
        throw new CHttpException(400, 'Помилка3');
        Yii::app()->end();
    }

    //Створення питання
    public function actionAddLead($id_client,$ask,$type_ask,$id_lawyer){
        //http://localhost/advokatmarket-v2-local/advokatmarket/index.php?r=profile/leadcontrol/addlead&id_client=17&ask=123&type_ask=simple&id_lawyer=16
        $lead = new Lead;
        $lead->id_client = $id_client;
        $lead->id_request_lead = 0; // 0 когда вопрос создается в ощую ленту
        $lead->status = 'make';
        $lead->ask = $ask;
        $lead->direct = 1;
        $lead->type_ask = $type_ask;
        $lead->time_make = time();
        $lead->save();

        $request_lead = new RequestLead;
        $request_lead->id_lead = $lead->id;
        $request_lead->id_lawyer = $id_lawyer;
        $request_lead->cost_service = 0;
        $request_lead->status = 'expected';
        $request_lead->time_expected = time();
        $request_lead->direct = 1;
        $request_lead->save();

        $lead->id_request_lead = $request_lead->id;

        if($lead->save()&&$request_lead->save()){
            echo 'ok';
        }else{
            echo 'error';
        }
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
                'actions'=>array('LInfo','LCnlRqst','LCnlRqstDirect','LPay'),
                'roles'=>array(
                    User::LAWYER
                )
            ),
            array('allow',
                'actions'=>array('CCnlMake','CCnlRqst','CCnlLead','CAcptDirect','CAcptRqst','AddLead'),
                'roles'=>array(
                    User::CLIENT
                )
            ),
            array('deny',
                'actions'=>array('LInfo','LCnlRqst','LCnlRqstDirect','LPay','CCnlMake','CCnlRqst','CCnlLead','CAcptDirect','CAcptRqst','AddLead'),
                'users'=>array('*')
            ),
        );
    }
}