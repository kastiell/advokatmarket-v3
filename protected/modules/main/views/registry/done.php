<?php
//Страница вывода сообщений об успешном завершении
//TODO Крассиво оформить эту страницу

$this->pageTitle=Yii::app()->name . ' - Success';
$this->breadcrumbs=array(
    'Success',
);
?>

<h2>Ура</h2>
<h4><?php echo CHtml::encode($message); ?></h4>