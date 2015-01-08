<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('jquery-ui');
?>

<script>
    $(function(){
        $("#EduLawyerForm_city_edu").autocomplete({source: "index.php?r=main/registry/city",minLength:2});
    });
</script>

<div class="grid maxwidth">

<div class="col-left-1">

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'edu-edit-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <?php echo $form->textField($model,'vnz',array('placeholder'=>'ВНЗ')); ?>
        <?php echo $form->error($model,'vnz'); ?>
    </div>
    <div class="row">
        <?php echo $form->textField($model,'faculty',array('placeholder'=>'Факультет')); ?>
        <?php echo $form->error($model,'faculty'); ?>
    </div>
    <div class="row">
        <?php echo $form->textField($model,'year_leave',array('placeholder'=>'Год выпуска')); ?>
        <?php echo $form->error($model,'year_leave'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('СОХРАНИТЬ',array('class'=>'button')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

</div>
<div class="col-right-1">
    <div class="grid maxwidth">
        <div class="loadEduTitle">
            Загрузить диплом
        </div>
        <div class="loadEduInf">
            Чтобы загрузить диплом, нажмите кнопку "Выберете файл" выберете файл и нажмите "Сохранить диплом"
        </div>
    <div class="col-img-edu maxwidth">

        <?php
            if($linkEduPicture){
               echo CHtml::image($linkEduPicture,'',array('style'=>'height: 334px;'));
            }
        ?>

    </div>
        <div class="col-form-edu">


    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            'id'=>'file-edit-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>false,
            ),
            'enableAjaxValidation'=>true,
        )); ?>

        <div class="row file">
            <?php echo $form->fileField($model_file,'file');?>
            <?php echo $form->error($model_file,'file'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Сохранить диплом',array('class'=>'button')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
        </div>

</div>
</div>

</div>