<?php

/*
 * Контроллер відповідає за ініціалізацію чату
 */

class MsgController extends Controller
{
    public function  actionIndex($id){
        Yii::import('profile.controllers.ChatController');

        $idCons = $id;
        $myRole = Yii::app()->user->getRole();
        $toRole = $myRole == 'client' ? 'lawyer' : 'client';
        $myId = Yii::app()->user->getId();
        $cons = Consultation::model()->findByAttributes(array('id'=>$idCons,'id_'.$myRole=>$myId));
        if($cons === null){
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }
        $toId = (array)$cons['id_'.$toRole];
        $toId = $toId[0];

        $info = array();
        $info['me'] = array('type_user'=>$myRole,'id'=>$myId);
        $info['to'] = array('type_user'=>$toRole,'id'=>$toId);

        if($myRole == User::CLIENT){
            $model = Client::model()->findByPk($myId);
        }else{
            $model = Lawyer::model()->findByPk($myId);
        }
        $info['me']['name'] = $model->name;
        $info['me']['first_name'] = $model->first_name;
        $info['me']['phone'] = $model->phone;
        $info['me']['email'] = User::model()->findByPk($myId)->login;

        if($toRole == User::CLIENT){
            $model = Client::model()->findByPk($toId);
        }else{
            $model = Lawyer::model()->findByPk($toId);
        }
        $info['to']['name'] = $model->name;
        $info['to']['first_name'] = $model->first_name;
        $info['to']['phone'] = $model->phone;
        $info['to']['email'] = User::model()->findByPk($toId)->login;

        $chatForm1 = new ChatForm('pay');
        $chatForm2 = new ChatForm('reviews');

        $dataMsg = ChatController::GetMsg($idCons);
        if($myRole == User::CLIENT){
            $this->layout='/layouts/panelClient';
        }else{
            $this->layout='/layouts/panelLawyer';
        }

        $this->render('client/index',array('dataXAMPP'=>array('hash'=>$cons->channel,'idCons'=>$cons->id,'status'=>$cons->status,'cost'=>$cons->cost),'info'=>$info,
                    'dataMsg'=>$dataMsg,
                    'models'=>array('pay'=>$chatForm1,'reviews'=>$chatForm2)));
    }

    public function renderMsg($dataMsg,$info,$type_user){
        foreach($dataMsg as $v){
            $msg = nl2br($v->msg);
            $name = $v->origin;

            $name = $v->origin == $type_user ? $info['me']['name'] : $info['to']['name'];
            $class_ = $v->origin == $type_user ? 'me' : 'to';
            $first_name = $v->origin == $type_user ? $info['me']['first_name'] : $info['to']['first_name'];
            $full_name = $name.($first_name ? ' '.$first_name : '');

            echo '<div class="item grid maxwidth '.$class_.'">
                <div class="col-d1">'.$full_name.':</div>
                <div class="col-d2">'.$msg.'</div>
            </div>';
        }
    }

    public function actionValidStep($scenario){
        $model = new ChatForm($scenario);
        if(isset($_POST['ajax']) && $_POST['ajax']==='chat-'.$scenario.'-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionTestPay($id){
        $consult = Consultation::model()->findByPk($id);
        $consult->status = 'cons';
        $consult->save();
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
                'actions'=>array('index'),
                'roles'=>array(
                    User::LAWYER,
                    User::CLIENT
                )
            ),
            array('deny',
                'actions'=>array('index'),
                'users'=>array('*')
            ),
        );
    }
}