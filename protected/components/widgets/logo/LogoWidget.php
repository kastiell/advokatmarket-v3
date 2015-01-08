<?php

//< ?php $this->widget('application.components.widgets.getflash.GetFlashWidget'); ? >

class LogoWidget extends CWidget{

    private $params = array(
        'id'=>null,
        'htmlOptions'=>array('style'=>'width:65px;height:82px;'),
    );

    public function setParams($params){
        $this->params = array_merge($this->params, $params);
    }

    public function run(){
        $dir_small = Yii::getPathOfAlias('application.data.uploads.logo.small');
        $path = 'logo.jpg';
        if($this->params['id'] == null) Yii::app()->end();
        $lawyer = Lawyer::model()->findByPk($this->params['id']);
        if($lawyer===null){
            throw new CHttpException(400, 'Пустой массив юриста');
            Yii::app()->end();
        }
        if($lawyer->logo_small != null){
            $path = $lawyer->logo_small;
        }
        $linkLogoPictureSmall = Yii::app()->assetManager->publish($dir_small.'/'.$path);
        //$linkLogoPictureSmall = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.Yii::app()->assetManager->publish($dir_small.'/'.$path);

        $this->params['link'] = $linkLogoPictureSmall;

        $this->render('logoWidget',array('params'=>$this->params));
    }
}