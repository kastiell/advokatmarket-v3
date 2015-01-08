<?php

/*
 * Контроллер відповідає за відображення профілю юриста
 */

class ProfileController extends Controller
{
    //Выводим главную страницу
    public function actionIndex($id)
    {
        Yii::import('main.controllers.AskController');
        $user = User::model()->findByPk(array('id'=>$id,'role'=>'lawyer'));
        if($user===null){
            throw new CHttpException(404, 'Такого юриста не существует!');
            Yii::app()->end();
        }

        $guest = Yii::app()->user->isGuest;
        $model1 = new AskForm(AskController::getScenarioOnRequest($guest,1));
        $model2 = new AskForm(AskController::getScenarioOnRequest($guest,1));
        $model3 = new AskForm(AskController::getScenarioOnRequest($guest,1));

        $lawyer = Lawyer::model()->findByPk(array('id'=>$user->id));
        $__form = $this->renderPartial('/ask/__form',array('modelArray'=>array(null,$model1,$model2,$model3),'id_lawyer'=>$lawyer->id),true,false);

        $this->render('index',array('lawyer'=>$lawyer,'__form'=>$__form,'id_lawyer'=>$lawyer->id));
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
                 'actions'=>array('Index'),
                 'users'=>array('*')
             ),
             array('deny',
                 'actions'=>array('Index'),
                 'users'=>array('*')
             ),
         );
     }
}