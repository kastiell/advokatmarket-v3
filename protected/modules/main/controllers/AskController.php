<?php
/*
 * Контроллер відповідає за роботу ф. задати питання
 */

class AskController extends Controller
{
    public function actionAddAsk(){

        $id_lawyer = 0;
        if(isset($_GET['id_lawyer'])&&!empty($_GET['id_lawyer'])){
            $id_lawyer = (int)$_GET['id_lawyer'];
        }

        if(isset($_POST['AskForm'])){
            if(Yii::app()->user->isGuest){
                $model = new AskForm('guest=true&step=new');
                $model->attributes = $_POST['AskForm'];
                if($model->validate()){

                    if($userArray = $this->newUser($model->email)){
                        if($this->addClient($userArray['id'],$model->name,$model->city,$model->phone)){
                            if($this->addLead($userArray['id'],$model->ask,$model->type_ask,$id_lawyer)){
                                //TODO (todo) Отправить емеил констатацией регестрации
                                echo json_encode(array('email'=>$model->email,'id_user'=>$userArray['id'],'pass'=>$userArray['pass'],'status'=>'ok_next'));
                                Yii::app()->end();
                            }
                        }
                    }
                }
            }else{
                $model = new AskForm('guest=false&step=new');
                $model->attributes = $_POST['AskForm'];
                if($model->validate()){
                    if($this->addLead(Yii::app()->user->getId(),$model->ask,$model->type_ask,$id_lawyer)){
                        echo json_encode(array('status'=>'ok_end'));
                        Yii::app()->end();
                    }
                }
            }
        }
        echo json_encode(array('status'=>'error'));
        Yii::app()->end();
    }

    public function actionSavePassword(){

        if(isset($_POST['AskForm'])){
            $scenario = 'guest=true&step=3';
            $model = new AskForm($scenario);
            $model->attributes = $_POST['AskForm'];
            //print_r($_POST['AskForm']);
            if($model->validate()){
                $user = User::model()->findByAttributes(array('id'=>$model->id_user));
                //echo CPasswordHelper::verifyPassword($model->pass_hidden, $user->password);
                if(($user !== null)&&(CPasswordHelper::verifyPassword($model->pass_hidden, $user->password))){

                    if($model->pass != ''){
                        $user->password = CPasswordHelper::hashPassword($model->pass);
                        $pass = $model->pass;
                    }else{
                        $pass = $model->pass_hidden;
                    }

                    $user->last_login = time();

                    if($user->save()){
                        //Вхід
                        $model=new LoginForm;
                        $model->username = $user->login;
                        $model->password = $pass;
                        $model->rememberMe = false;
                        if($model->validate() && $model->login()){
                            echo json_encode(array('status'=>'ok_end'));
                            Yii::app()->end();
                        }
                    }
                }
            }
        }
        echo json_encode(array('status'=>'error'));
        Yii::app()->end();
    }

    public function actionValidStep($guest,$step){
        $scenario = $this->getScenarioOnRequest($guest,$step);
        $model = new AskForm($scenario);
        if(isset($_POST['ajax']) && $_POST['ajax']==='index-'.$step.'-main-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetForm(){
        $id_lawyer = Yii::app()->request->getPost('id_lawyer');

        $guest = Yii::app()->user->isGuest;
        $model1 = new AskForm($this->getScenarioOnRequest($guest,1));
        $model2 = new AskForm($this->getScenarioOnRequest($guest,2));
        $model3 = new AskForm($this->getScenarioOnRequest($guest,3));

        $this->renderPartial('__form',array('modelArray'=>array(null,$model1,$model2,$model3),'id_lawyer'=>$id_lawyer),false,true);
    }

    public function getScenarioOnRequest($guest,$step){
        if($guest == 1){
            if($step == 1){
                $scenario = 'guest=true&step=1';
            }
            if($step == 2){
                $scenario = 'guest=true&step=2';
            }
            if($step == 3){
                $scenario = 'guest=true&step=3';
            }
        }else{
            if($step == 1){
                $scenario = 'guest=false&step=1';
            }
            if($step == 2){
                $scenario = 'guest=false&step=2';
            }
            if($step == 3){
                $scenario = 'guest=false&step=3';
            }
        }
        return $scenario;
    }

    public function newUser($email){
        Yii::import('main.controllers.RegistryController');
        //return array('id'=>25,'pass'=>'qwerty');

        $user = new User;
        $pass = RegistryController::generatePassword(16);
        $user->role = User::CLIENT;
        $user->login = $email;
        $user->password = CPasswordHelper::hashPassword($pass);
        $user->activate_link = NULL;
        $user->ts_reg = time();
        $user->last_login = time();
        if($user->save()){
            return array('id'=>$user->id,'pass'=>$pass);
        }else{
            return null;
        }
    }

    public function addClient($id,$name,$city,$phone){

        //return true;

        $client = new Client;
        $client->id = $id;
        $client->name = $name;
        $client->first_name = null;
        $client->city = $city;
        $client->phone = $phone;
        if($client->save(true)){
            return true;
        }else{
            return false;
        }
    }

    //Створення питання
    public function addLead($id_client,$ask,$type_ask,$id_lawyer = 0){

        //return true;

        if($id_lawyer !== 0){
            $lead = new Lead;
            $lead->id_client = $id_client;
            $lead->id_request_lead = 0;
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
                return $lead->id;
            }else{
                return null;
            }
        }else{
            $lead = new Lead;
            $lead->id_client = $id_client;
            $lead->id_request_lead = 0;
            $lead->status = 'make';
            $lead->ask = $ask;
            $lead->direct = 0;
            $lead->type_ask = $type_ask;
            $lead->time_make = time();
            if($lead->save()){
                return $lead->id;
            }else{
                return null;
            }
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
                'actions'=>array('AddAsk','SavePassword','ValidStep','GetForm'),
                'roles'=>array(
                    User::CLIENT,
                    User::GUEST
                )
            ),
            array('deny',
                'actions'=>array('AddAsk','SavePassword','ValidStep','GetForm'),
                'users'=>array('*')
            ),
        );
    }
}