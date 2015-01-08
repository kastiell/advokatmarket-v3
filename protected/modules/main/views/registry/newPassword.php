<?php
Yii::app()->clientScript->registerCoreScript('main.login');
?>

<div class="all">
    <div class="grid gridBlock">
        <div class="title-login" style="width: 470px;margin-left: -60px;">Подтверждение регестрации</div>
        <div class="title-login blue-color"><?=$email?></div>
        <div class="content-login">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'newpassword-actlink-form',
                    'enableClientValidation'=>false,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>false,
                    ),
                    'enableAjaxValidation'=>true,
                )); ?>

                <div class="row">
                    <?php echo $form->passwordField($model,'password',array('placeholder'=>'Пароль')); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>

                <div class="row">
                    <?php echo $form->passwordField($model,'password_repeat',array('placeholder'=>'Повторите пароль')); ?>
                    <?php echo $form->error($model,'password_repeat'); ?>
                </div>

                <div class="row buttons grid">
                    <div class="col-btn">
                        <?php echo $form->hiddenField($model,'link'); ?>
                        <?php echo CHtml::submitButton('СОХРАНИТЬ ПАРОЛЬ',array('class'=>'button')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>