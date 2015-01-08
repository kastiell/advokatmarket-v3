<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('maskedinput');
Yii::app()->clientScript->registerPackage('jquery-ui');
?>

<script>
    $(function(){
        $("#ContactLawyerForm_city").autocomplete({source: "index.php?r=main/registry/city",minLength:2});
    });
    $(function(){
        $("#ContactLawyerForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
    });
</script>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contact-edit-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>

    <div class="grid maxwidth">
        <div class="col-titleField"><?php echo $form->labelEx($model,'city'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'city'); ?>
            <?php echo $form->error($model,'city'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'street'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'street'); ?>
            <?php echo $form->error($model,'street'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'apartment'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'apartment'); ?>
            <?php echo $form->error($model,'apartment'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'phone'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'phone'); ?>
            <?php echo $form->error($model,'phone'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'site'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'site'); ?>
            <?php echo $form->error($model,'site'); ?></div>

        <div class="col-titleField"></div>
        <div class="col-inpField buttons"><?php echo CHtml::submitButton('СОХРАНИТЬ',array('class'=>'button')); ?></div>
    </div>

    <?php $this->endWidget(); ?>
</div>