<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('maskedinput');
Yii::app()->clientScript->registerPackage('jquery-ui');
?>

<script>
    $(function(){
        $("#GeneralClientForm_city").autocomplete({source: "index.php?r=main/registry/city",minLength:2});
    });
    $(function(){
        $("#GeneralClientForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
    });
</script>

<div class="form general_form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'client-general-edit-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="title_form">Общая иформация</div>
    </div>
    <div class="row">
        <?php echo $form->textField($model,'name',array('placeholder'=>'Имя')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="row">
        <?php echo $form->textField($model,'phone',array('placeholder'=>'Телефон')); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
    <div class="row">
        <?php echo $form->textField($model,'city',array('placeholder'=>'Город')); ?>
        <?php echo $form->error($model,'city'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('СОХРАНИТЬ',array('class'=>'button')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>