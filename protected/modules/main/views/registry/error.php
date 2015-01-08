<?php
//Страница вывода ошибок
//TODO Крассиво оформить эту страницу

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>
<h4>Что то пошло не так(</h4>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>