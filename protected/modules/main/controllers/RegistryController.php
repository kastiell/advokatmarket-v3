<?php
/*
 * Контроллер відповідає за вхід та реєстрацію користувачів
 */
class RegistryController extends Controller
{
    public function actionLogin()
    {
        $model=new LoginForm;
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('login',array('model'=>$model));
    }

    public function actionLogout($mode = null)
    {
        Yii::app()->user->logout();
        if($mode == null){
            $this->redirect(Yii::app()->homeUrl);
        }else{
            $this->redirect(array($mode));
        }
    }

    //Ф. показ комерческого предложения перед регистрацией юриста
    public function actionOffer()
    {
        $this->render('offer');
    }

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    //Активируем юриста по ссылке
    public function actionActLink(){
        if($link = $_REQUEST['link']){
            $user = User::model()->findByAttributes(array('activate_link'=>$link));
            if(($user===null)or($user->activate_link==null)){
                throw new CHttpException(400, 'Помилка1');
                Yii::app()->end();
            }else{
                $model=new NewPassword;
                $model->link = $link;
                if(isset($_POST['ajax']) && $_POST['ajax']==='newpassword-actlink-form')
                {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                }

                if(isset($_POST['NewPassword']))
                {
                    $model->attributes=$_POST['NewPassword'];
                    if($model->validate()){
                        $user->password = CPasswordHelper::hashPassword($model->password_repeat);
                        $user->activate_link = NULL;
                        $pass = $model->password_repeat;
                        if($model->validate() && $user->save()){

                            //Вхід
                            $model=new LoginForm;
                            $model->username = $user->login;
                            $model->password = $pass;
                            $model->rememberMe = false;
                            if($model->validate() && $model->login()){
                                $this->redirect($this->createAbsoluteUrl('/profile/edit/general'));
                                $this->doneRegistry('Вы успешно сохранили пароль)');
                                Yii::app()->end();
                            }else{
                                throw new CHttpException(400, 'Помилка2');
                                Yii::app()->end();
                            }
                        }else{
                            throw new CHttpException(400, 'Помилка3');
                            Yii::app()->end();
                        }
                    }
                }
                $this->render('newPassword',array('model'=>$model,'email'=>$user->login));
            }
        }
    }

    //Регистрация юриста
    public function actionAddLawyer()
    {
        $model=new RegistryLawyerForm;
        if(isset($_POST['ajax']) && $_POST['ajax']==='registry-add-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        //Реєструємо юриста
        if(isset($_POST['RegistryLawyerForm']))
        {
            $pass = $this->generatePassword(16);
            $model->attributes=$_POST['RegistryLawyerForm'];
            if($model->validate()){
                $activated_link = $this->generatePassword(32);
                $user = new User;
                $lawyer = new Lawyer;
                $lawyerOption = new LawyerOptions;

                $user->role = User::DLAWYER; //Роль неактивированный юрист
                $user->login = $model->email;
                $user->password = CPasswordHelper::hashPassword($pass);
                $user->activate_link = $activated_link;
                $user->ts_reg = time();
                $user->last_login = time();

                //Если сохранение прошло валидацию
                if($user->save(true)){
                    $lawyer->id = $user->id;
                    $lawyer->name = $model->name;
                    $lawyer->first_name = $model->first_name;
                    $lawyer->phone = $model->phone;
                    if($lawyer->save(true)){
                        $lawyerOption->id = $user->id;
                        $lawyerOption->success_profile = 0;
                        if($lawyerOption->save(false)){
                            //TODO (todo) Відправити email з лінком
                            $link = $this->createAbsoluteUrl('/main/registry/actLink',array('link'=>$activated_link));
                            $this->doneRegistry('Вы успешно зарегестрировались) Вам на емеил пришло письмо с подтверждением: '.$link.' <br>pass = '.$pass);
                            Yii::app()->end();
                        }
                    }
                }
            }
            throw new CHttpException(400, 'Данные не прошли валидацию');
            Yii::app()->end();
        }

        // display the login form
        $this->render('registryLawyerForm',array('model'=>$model));
    }

    //Регестрация клиента
    public function actionAddClient()
    {
        $model=new RegistryClientForm;

        //Проводим валидацию
        if(isset($_POST['ajax']) && $_POST['ajax']==='cregistry-add-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        //Регестрируем клиента
        if(isset($_POST['RegistryClientForm']))
        {
            $model->attributes=$_POST['RegistryClientForm'];
            if($model->validate()){
                $user = new User;
                $client = new Client;

                $user->role = User::CLIENT;
                $user->login = $model->email;
                $user->password = CPasswordHelper::hashPassword($model->password);
                $user->activate_link = NULL;
                $user->ts_reg = time();
                $user->last_login = time();
                $pass = $model->password;
                //Если сохранение прошло валидацию
                if($user->save(true)){
                    $client->id = $user->id;
                    $client->name = $model->name;
                    $client->first_name = null;
                    $client->city = $model->city;
                    $client->phone = $model->phone;
                    if($client->save(true)){
                        //TODO (todo) отправить емеил констатацией регестрации

                        //Вхід
                        $model=new LoginForm;
                        $model->username = $user->login;
                        $model->password = $pass;
                        $model->rememberMe = false;
                        if($model->validate() && $model->login()){
                            $this->redirect($this->createAbsoluteUrl('/profile/edit/clientGeneral'));
                            $this->doneRegistry('Вы успешно зарегестрировались)');
                            Yii::app()->end();
                        }else{
                            throw new CHttpException(400, 'Помилка');
                            Yii::app()->end();
                        }
                    }
                }
            }
            throw new CHttpException(400, 'Данные не прошли валидацию');
            Yii::app()->end();
        }


        $this->render('registryClientForm',array('model'=>$model));
    }

    //Ф. возвращает города (max=10) по ключевому слову (term)
    public function actionCity($term)
    {
        $local = 'ru'; //Нужная локализация

        $term = '%'.$term.'%';
        $region = $this->getRegion($local);
        $from = 'city_'.$local;
        $str = '';
        $locatedCity = LocatedCity::model()->findAll($from.' like :search LIMIT 10', array(':search'=>$term));
        $tmp=0;
        $type = $local=='ua'?'м':'г';
        foreach($locatedCity as $k=>$v){
            $tmp = $tmp===0 ? '' : ',';
            $a = (array)$v->attributes;
            $str.=$tmp.'{"'.$a['id'].'":"'.$a[$from].'","label":"'.$type.'. '.$a[$from].', '.$region[$a['region']].'","value":"'.$a[$from].'"}';
        }
        echo '['.$str.']';
    }

    //Вывод массива с областями
    public function getRegion($local){
        $locatedRegion = LocatedRegion::model()->findAll();
        $arr = array();
        foreach($locatedRegion as $k=>$v){
            $a = (array)$v->attributes;
            $arr[$a['id']] = $a['region_full_'.$local];
        }
        return $arr;
    }

    //TODO общая функция
    public function generatePassword($length = 8){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    //TODO общая функция
    public function doneRegistry($message){
        $this->render('main.views.registry.done',array('message'=>$message));
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
                'actions'=>array('offer','AddClient','AddLawyer','ActLink','Login'),
                'roles'=>array(
                    User::GUEST
                )
            ),
            array('allow',
                'actions'=>array('Logout'),
                'users'=>array('@'),
            ),
            array('deny',
                'actions'=>array('Offer','ActLink','AddLawyer','AddClient','Logout'),
                'users'=>array('*')
            ),
        );
    }
}