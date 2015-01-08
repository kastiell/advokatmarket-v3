<?php

class ChatController extends Controller
{
    public function createConsultation($id_client){
        Yii::import('main.controllers.RegistryController');
        $consult = new Consultation;
        $consult->id_client = $id_client;
        $consult->id_lawyer = Yii::app()->user->getId();
        $consult->channel = strtolower(RegistryController::generatePassword(64));
        $consult->status = 'start';
        $consult->time_start = time();
        if($consult->save()){
            return $consult->id;
        }
        return false;
    }


    public function actionAddMsg(){
        $ok = '{"status":"0"}';
        $fail = '{"status":"1"}';

        $data = Yii::app()->request->getPost('data',null);
        if($data == null) die($fail);
        $o = json_decode($data);

        $chat_line = new ChatLine;
        $chat_line->msg = $o->msg;
        $chat_line->type = $o->type;
        $chat_line->origin = $o->origin;
        $chat_line->ts = $o->ts;
        $chat_line->id_consultation = $o->id;
        if($chat_line->save()){
            die($ok);
        }
        die($fail);
    }

    public function actionAddCmnd(){

        $ok = '{"status":"0"}';
        $fail = '{"status":"1"}';

        $data = Yii::app()->request->getPost('data',null);
        if($data == null) die($fail);
        $o = json_decode($data);

        $type = Yii::app()->user->getRole();
        $consult = Consultation::model()->findByAttributes(array('id'=>$o->idCons,'id_'.$type=>Yii::app()->user->getId()));

        switch($o->method){
            case 'pay':
                Yii::import('main.controllers.RegistryController');
                $consult->status = 'pay';

                $model = new ChatForm;
                $model->pay_cost = $o->cost;
                if(!$model->validate()){
                    die($fail);
                }

                $consult->cost = $model->pay_cost;
                $consult->link_pay = RegistryController::generatePassword(64);
                if($consult->save()){
                    die($ok);
                }
                break;
            case 'close_consultation':
                if($consult->status == 'cons'){
                    $consult->status = 'reviews';
                }else{
                    $consult->status = 'cancel';
                }

                if($consult->save()){
                    die($ok);
                }

                break;
            case 'reviews':
                $consult->review_txt = $o->txt;
                $consult->status = 'end';
                if($consult->save()){
                    die($ok);
                }
                break;
        }
        die($fail);
    }

    public function GetMsg($idCons){
        $chat_line = ChatLine::model()->findAllByAttributes(array('id_consultation'=>$idCons));
        if($chat_line === null){
            return null;
        }
        return $chat_line;
    }


    //Фильтрация действий
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
                'actions'=>array('AddMsg'),
                'roles'=>array(
                    User::LAWYER,
                    User::CLIENT
                )
            ),
            array('deny',
                'actions'=>array('AddMsg'),
                'users'=>array('*')
            ),
        );
    }
}