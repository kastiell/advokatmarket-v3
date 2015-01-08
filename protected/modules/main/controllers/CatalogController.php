<?php
/*
 * Контроллер відповідає за виведення каталогу юристів
 */

//TODO (todo) Добавити фільтри каталогу
class CatalogController extends Controller
{
    public function actionValidStep($guest,$step){

        $scenario = $this->getScenarioOnRequest($guest,$step);
        $model = new IndexAskForm($scenario);
        if(isset($_POST['ajax']) && $_POST['ajax']==='index-'.$step.'-main-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionIndex()
    {
        $city = Yii::app()->request->getQuery('city', null);
        $sp = Yii::app()->request->getQuery('sp', null);

        $params = array(':role'=>User::LAWYER);
        if(($city == null)&&($sp == null)){
            $condition = "t.role = :role";
        }else if(($city !== null)&&($sp == null)){
            $condition = '(t.role = :role) AND (lawyer_tbl.city = :city)';
            $params[':city'] = $city;
        }else if(($city == null)&&($sp !== null)){
            $condition = "(t.role = :role) AND (lawyer_tbl.spec LIKE :sp)";
            $params[':sp'] = '%'.$sp.'%';
        }else if(($city !== null)&&($sp !== null)){
            $condition = "(t.role = :role) AND (lawyer_tbl.city = :city) AND (lawyer_tbl.spec LIKE :sp)";
            $params[':city'] = $city;
            $params[':sp'] = '%'.$sp.'%';
        }

        $category = Category::model()->findAll();
        $dataProvider = new CActiveDataProvider('User',array(
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'criteria'=>array(
                'condition'=>$condition,
                'with'=>array('lawyer_tbl'),
                'params'=>$params,
            )
        ));
        $this->render('index',array('category'=>$category,'dataProvider'=>$dataProvider));
    }

    public function actionGetForm(){
        $id_lawyer = Yii::app()->request->getPost('id_lawyer');

        $guest = Yii::app()->user->isGuest;
        $model1 = new IndexAskForm($this->getScenarioOnRequest($guest,1));
        $model2 = new IndexAskForm($this->getScenarioOnRequest($guest,2));
        $model3 = new IndexAskForm($this->getScenarioOnRequest($guest,3));

        $this->renderPartial('__form',array('modelArray'=>array(null,$model1,$model2,$model3)),false,true);
    }

    public function actionTest(){

        $model = new TestForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='test-1-main-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['ajax']) && $_POST['ajax']==='test-2-main-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $this->render('test',array('model'=>$model));
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

    public function  getScenarioOnRequest($guest,$step){
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
}