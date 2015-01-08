<?php

/*
 * Контроллер відповідає за роботу з редактуванням сторінки юриста та користувача
 * Для всіх запитів до дій юриста приставки в назві дії немає.
 */

class EditController extends Controller
{
    //Смотрим заполнены ли все обязательные поля
    public function beforeAction($action){

        //Проверяем нет ли у юриста всех прав
        if(Yii::app()->user->role === User::LAWYER){
            return true;
        }
        if(Yii::app()->user->role=== User::CLIENT){
            return true;
        }

        if(Yii::app()->user->role === User::DLAWYER){
            if(User::model()->findByPk(Yii::app()->user->getId())->role == User::LAWYER){
                Yii::import('main.controllers.RegistryController');
                RegistryController::actionLogout('/main/registry/login');
            }
            return true;
        }

        $lawyerOptions = LawyerOptions::model()->findByPk(Yii::app()->user->getId());
        if($lawyerOptions===null){
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }

        $mode = $lawyerOptions->success_profile == 'init' ? 'fill' :$lawyerOptions->success_profile;

        $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
        if($lawyer===null){
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }else{
            foreach((array)$lawyer->attributes as $k=>$v){
                if($k == 'site') continue; //Т.к сайт не обязательное поле его можно пропустить
                if($k == 'city_edu') continue; //Т.к сайт не обязательное поле его можно пропустить
                if($k == 'country') continue; //Т.к сайт не обязательное поле его можно пропустить
                if(($v == null)||(($k=='spec')&&($v=='[]'))){
                    $mode = 'init';
                    break;
                }
            }
            $lawyerOptions->success_profile = $mode;
            $lawyerOptions->save(false);
        }
        return true;
    }

    public function actionCancelActivate(){

        $lawyerOptions = LawyerOptions::model()->findByPk(Yii::app()->user->getId());
        if($lawyerOptions===null){
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }else{
            if($lawyerOptions->success_profile != 'activate'){
                throw new CHttpException(400, 'Помилка');
                Yii::app()->end();
            }
            $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
            if($lawyer===null){
                throw new CHttpException(400, 'Помилка');
                Yii::app()->end();
            }else{
                $lawyerOptions->success_profile = 'fill';
                $lawyerOptions->save(false);
            }
        }
        $this->redirect(array('general'));
    }

    public function actionActivate(){

        $lawyerOptions = LawyerOptions::model()->findByPk(Yii::app()->user->getId());
        if($lawyerOptions===null){
            throw new CHttpException(400, 'Помилка');
            Yii::app()->end();
        }else{
            if($lawyerOptions->success_profile != 'fill'){
                throw new CHttpException(400, 'Помилка');
                Yii::app()->end();
            }
            $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
            if($lawyer===null){
                throw new CHttpException(400, 'Помилка');
                Yii::app()->end();
            }else{
                $lawyerOptions->success_profile = 'activate';
                $lawyerOptions->save(false);
                Yii::import('main.controllers.RegistryController');
                //RegistryController::actionLogout();
            }
        }
        $this->redirect(array('general'));
    }

    public function actionClientChLogin()
    {
        $model = new ChLoginClientForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='client-chlogin-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $user = User::model()->findByPk(Yii::app()->user->getId());
        if($user===null){
            throw new CHttpException(400, 'Пустой массив user');
            Yii::app()->end();
        }else{

            if(isset($_POST['ChLoginClientForm']))
            {
                $model->attributes=$_POST['ChLoginClientForm'];
                if($model->validate()){
                    if(!empty($model->email))
                        $user->login = $model->email;
                    if(!empty($model->password))
                        $user->password = CPasswordHelper::hashPassword($model->password);
                    $user->save(false);
                    Yii::app()->user->setFlash('edit-status',"Данные успешно сохранены");
                    $this->refresh();
                }
            }
            $model->email = $user->login;
        }

        $model->password_old = null;
        $model->password = null;
        $model->password_repeat = null;

        $this->layout='/edit/layouts/panelTopClient';
        $this->render('client/chloginForm',array('model'=>$model));
    }

    public function actionClientGeneral()
    {
        $model = new GeneralClientForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='client-general-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $client = Client::model()->findByPk(Yii::app()->user->getId());
        if($client===null){
            throw new CHttpException(400, 'Пустой массив клиента');
            Yii::app()->end();
        }else{
            if(isset($_POST['GeneralClientForm']))
            {
                $model->attributes=$_POST['GeneralClientForm'];
                if($model->validate()){
                    $client->attributes = $model->attributes;
                    $client->save(true);
                    Yii::app()->user->setFlash('edit-status',"Данные успешно сохранены");
                    $this->refresh();
                }
            }
            $model->attributes = $client->attributes;
        }

        $this->layout='/edit/layouts/panelTopClient';
        $this->render('client/generalForm',array('model'=>$model));
    }

    public function actionGeneral()
    {
        $model = new GeneralLawyerForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='general-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
        if($lawyer===null){
            throw new CHttpException(400, 'Пустой массив юриста');
            Yii::app()->end();
        }else{
            if(isset($_POST['GeneralLawyerForm']))
            {
                $model->attributes=$_POST['GeneralLawyerForm'];
                if($model->validate()){
                    $lawyer->attributes = $model->attributes;
                    $lawyer->save(true);
                    Yii::app()->user->setFlash('edit-status',"Данные успешно сохранены");
                    $this->refresh();
                }
            }
            $model->attributes = $lawyer->attributes;
        }

        $this->layout='/edit/layouts/panelTopLawyer';
        $this->render('lawyer/generalForm',array('model'=>$model));
    }

    public function actionChLogin()
    {
        $model = new ChLoginLawyerForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='chlogin-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $user = User::model()->findByPk(Yii::app()->user->getId());
        if($user===null){
            throw new CHttpException(400, 'Пустой массив user');
            Yii::app()->end();
        }else{
            if(isset($_POST['ChLoginLawyerForm']))
            {
                $model->attributes=$_POST['ChLoginLawyerForm'];
                if($model->validate()){
                    if(!empty($model->email))
                        $user->login = $model->email;
                    if(!empty($model->password))
                        $user->password = CPasswordHelper::hashPassword($model->password);
                    $user->save(true);
                    Yii::app()->user->setFlash('edit-status',"Данные успешно сохранены");
                    $this->refresh();
                }
            }
            $model->email = $user->login;
        }

        $model->password_old = null;
        $model->password = null;
        $model->password_repeat = null;

        $this->layout='/edit/layouts/panelTopLawyer';
        $this->render('lawyer/chloginForm',array('model'=>$model));
    }

    public function actionEdu()
    {
        $model = new EduLawyerForm;
        $model_file = new EduFile;
        $dir = Yii::getPathOfAlias('application.data.uploads.edu');
        $uploaded = false;
        $fullLink = false;


        if(isset($_POST['ajax']) && $_POST['ajax']==='edu-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['ajax']) && $_POST['ajax']==='file-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
        if($lawyer===null){
            throw new CHttpException(400, 'Пустой массив юриста');
            Yii::app()->end();
        }else{
            if(isset($_POST['EduLawyerForm']))
            {
                $model->attributes=$_POST['EduLawyerForm'];
                if($model->validate()){
                    $lawyer->attributes = $model->attributes;
                    $lawyer->save(true);
                    Yii::app()->user->setFlash('edit-status',"Данные успешно сохранены");
                    $this->refresh();
                }
            }

            //TODO (todo) Может быть нужно сделать удаление предыдущей фотки когда загружаешь новую но пока оставлю все
            if((isset($_POST['EduFile'])))
            {
                $model_file->attributes=$_POST['EduFile'];
                $file = CUploadedFile::getInstance($model_file,'file');
                if($model_file->validate()){
                    Yii::import('main.controllers.RegistryController');
                    $fileName = $lawyer->id.'_'.RegistryController::generatePassword(64);
                    $fullName = $fileName.'.'.$this->getExtensionOnType($file->getType());
                    $fullLink = $dir.'/'.$fullName;
                    $uploaded = $file->saveAs($fullLink);
                    if($uploaded){
                        $lawyer->edu_picture = $fullName;
                        $lawyer->save(false);
                        Yii::app()->user->setFlash('edit-status',"Диплом загружен");
                        $this->refresh();
                    }
                }
            }
            $model->attributes = $lawyer->attributes;
            if($lawyer->edu_picture!=null){
                $linkEduPicture = Yii::app()->assetManager->publish($dir).'/'.$lawyer->edu_picture;
            }
        }
        if($model->year_leave == 0) $model->year_leave = '';
        if(!isset($linkEduPicture)) $linkEduPicture=false;
        $this->layout='/edit/layouts/panelTopLawyer';
        $this->render('lawyer/eduForm',array('model'=>$model,'model_file'=>$model_file,'linkEduPicture'=>$linkEduPicture));
    }

    public function actionContact()
    {
        $model = new ContactLawyerForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='contact-edit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
        if($lawyer===null){
            throw new CHttpException(400, 'Пустой массив юриста');
            Yii::app()->end();
        }else{
            if(isset($_POST['ContactLawyerForm']))
            {
                $model->attributes=$_POST['ContactLawyerForm'];
                if($model->validate()){
                    $lawyer->attributes = $model->attributes;
                    $lawyer->save(true);
                    Yii::app()->user->setFlash('edit-status',"Данные успешно сохранены");
                    $this->refresh();
                }
            }
            $model->attributes = $lawyer->attributes;
        }

        $this->layout='/edit/layouts/panelTopLawyer';
        $this->render('lawyer/contactForm',array('model'=>$model));
    }

    public function getExtension($f) {
        return substr(strrchr($f, '.'), 1);
    }

    public function getExtensionOnType($f){
        $arr = explode('/',$f);
        return $arr[1];
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
                'actions'=>array('ClientChLogin','ClientGeneral'),
                'roles'=>array(
                    User::CLIENT
                )
            ),
            array('allow',
                'actions'=>array('Activate','CancelActivate','General','ChLogin','Edu','Contact'),
                'roles'=>array(
                    User::DLAWYER
                )
            ),
            array('deny',
                'actions'=>array('ClientChLogin','ClientGeneral','Activate','CancelActivate','General','ChLogin','Edu','Contact'),
                'users'=>array('*')
            ),
        );
    }
}