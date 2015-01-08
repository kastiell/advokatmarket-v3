<?php

/*
 * Контроллер відповідає за маніпуляції на головній сторінці:
 * створення питання(послуги),
 * валідація даних,
 * реєстрація нового клієнта.
 */

class IndexController extends Controller
{
    //Виводимо головну сторінку та зберігаємо пароль нового користувача
    public function actionIndex()
    {
        $model = new IndexForm('logout');
        if(isset($_POST['ajax']) && $_POST['ajax']==='index-main-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['IndexForm'])){
            $model->attributes=$_POST['IndexForm'];
            //if($model->validate()){
                if($model->pass != null){
                    $user = User::model()->findByAttributes(array('login'=>$model->email));
                    if(CPasswordHelper::verifyPassword($model->pass_hidden, $user->password)){
                        $user->password = CPasswordHelper::hashPassword($model->pass);
                        $pass = $model->pass;
                        if($user->save()){

                            //Вхід
                            $model=new LoginForm;
                            $model->username = $user->login;
                            $model->password = $pass;
                            $model->rememberMe = false;
                            if($model->validate()&&$model->login()){
                                echo '0';
                                Yii::app()->end();
                            }
                        }
                    }
                }
            //}
            echo '-1';
            Yii::app()->end();
        }

        $guest = Yii::app()->user->isGuest;
        Yii::import('main.controllers.AskController');
        $model1 = new AskForm(AskController::getScenarioOnRequest($guest,1));
        $model2 = new AskForm(AskController::getScenarioOnRequest($guest,1));
        $model3 = new AskForm(AskController::getScenarioOnRequest($guest,1));


        $this->render('index',array('model'=>$model,'modelArray'=>array(null,$model1,$model2,$model3)));
    }

    //Валідуємо дані зареєстрованого користувача
    public function actionOnLogin(){
        $model = new IndexForm('login');
        if(isset($_POST['ajax']) && $_POST['ajax']==='index-main-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //Реєструємо нового користувача та зберігаємо питання
    public function actionAddAsk(){
        $model = new IndexForm('logout');
        if(isset($_POST['IndexForm'])){

            Yii::import('main.controllers.RegistryController');
            $model->attributes=$_POST['IndexForm'];
            if($model->validate()){
                if(Yii::app()->user->isGuest){
                    $user = new User;
                    $client = new Client;
                    $pass = RegistryController::generatePassword(16);
                    $user->role = User::CLIENT;
                    $user->login = $model->email;
                    $user->password = CPasswordHelper::hashPassword($pass);
                    $user->activate_link = NULL;
                    $user->ts_reg = time();
                    $user->last_login = time();

                    //Если сохранение прошло валидацию
                    if($user->save(true)){
                        $client->id = $user->id;
                        $client->name = $model->name;
                        $client->first_name = null;
                        $client->city = $model->city;
                        $client->phone = $model->phone;
                        $this->addLead($user->id,$model->ask,$model->type_ask);
                        if($client->save(true)){
                            //TODO (todo) Отправить емеил констатацией регестрации
                            echo json_encode(array('email'=>$model->email,'pass'=>$pass,'status'=>true));
                            Yii::app()->end();
                        }
                    }

                }
                $this->addLead(Yii::app()->user->getId(),$model->ask,$model->type_ask);
                echo json_encode(array('status'=>'exit'));
                Yii::app()->end();
            }
        }
        throw new CHttpException(400, 'Данные не прошли валидацию');
        Yii::app()->end();
    }

    public function addLead($id_client,$ask,$type_ask,$id_provide_lead = 0){
        $lead = new Lead;
        $lead->id_client = $id_client;
        $lead->id_request_lead = 0; // 0 когда вопрос создается в ощую ленту
        $lead->status = 'make';
        $lead->ask = $ask;
        $lead->type_ask = $type_ask;
        $lead->time_make = time();
        if($lead->save()){
            return $lead->id;
        }else{
            return null;
        }
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
                'actions'=>array('Index','AddAsk'),
                'users'=>array('*')
            ),
            array('allow',
                'actions'=>array('OnLogin'),
                'roles'=>array(
                    User::CLIENT
                )
            ),
            array('deny',
                'actions'=>array('Index','AddAsk','OnLogin'),
                'users'=>array('*')
            ),
        );
    }
}