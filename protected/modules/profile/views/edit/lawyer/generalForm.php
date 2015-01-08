<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerPackage('magicsuggest');

    $lang = 'ru';
    $str = '';
    $category = Category::model()->findAll();
    foreach($category as $v){
        $a = (array)$v->attributes;
        $str .= $a[$lang].',';
    }
?>

<script>
    $(function(){
        $('#GeneralLawyerForm_spec').magicSuggest({
            resultAsString: true,
            width: 290,
            maxSelection:3,
            //value: [],
            data: '<?=$str?>'
        });
    });
</script>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'general-edit-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="grid maxwidth">
        <div class="col-titleField"><?php echo $form->labelEx($model,'name'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'first_name'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'first_name'); ?>
        <?php echo $form->error($model,'first_name'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'last_name'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'last_name'); ?>
        <?php echo $form->error($model,'last_name'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'exp'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textArea($model,'exp'); ?>
        <?php echo $form->error($model,'exp'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'type_work'); ?>:</div>
        <div class="col-inpField"><?php echo $form->dropDownList($model,'type_work',array('lawyer'=>'Юристконсул','notary'=>'Нотаріус','advocate'=>'Адвокат')); ?>
        <?php echo $form->error($model,'type_work'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'spec'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'spec'); ?>
        <?php echo $form->error($model,'spec'); ?></div>

        <div class="col-titleField"></div>
        <div class="col-inpField buttons"><?php echo CHtml::submitButton('СОХРАНИТЬ',array('class'=>'button')); ?></div>
    </div>

    <?php $this->endWidget(); ?>
</div>