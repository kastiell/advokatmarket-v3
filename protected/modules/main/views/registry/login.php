<?php
    Yii::app()->clientScript->registerCoreScript('main.login');
?>

<div class="all">
    <div class="grid gridBlock">
        <div class="title-login">Вход</div>
        <div class="content-login">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>
                <div class="row">
                    <?php echo $form->textField($model,'username',array('placeholder'=>'Email')); ?>
                    <?php echo $form->error($model,'username'); ?>
                </div>

                <div class="row">
                    <?php echo $form->passwordField($model,'password',array('placeholder'=>'Пароль')); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>

                <div class="row rememberMe">
                    <?php echo $form->checkBox($model,'rememberMe'); ?> <label for="LoginForm_rememberMe">Запомнить меня</label>
                    <?php echo $form->error($model,'rememberMe'); ?>
                </div>
                <div class="row buttons grid">
                    <div class="col-btn">
                        <?php echo CHtml::submitButton('ВОЙТИ',array('class'=>'button')); ?>
                    </div>
                    <div class="col-forgot">
                        <a href="#" class="my-a">Забыли пароль?<a>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="col-or-reg content-login">
            <div>
                Или вы можете <a href="#" class="my-a">зарегестрироватся</a>
            </div>
        </div>
    </div>
</div>