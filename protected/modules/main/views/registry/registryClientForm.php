<?php
    Yii::app()->clientScript->registerCoreScript('main.login');
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('maskedinput');
    Yii::app()->clientScript->registerPackage('jquery-ui');
?>

<script>
    $(function(){
        $( "#RegistryClientForm_city" ).autocomplete({source: "index.php?r=main/registry/city",minLength:2});
        $("#RegistryClientForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
    });
</script>

<div class="all">
    <div class="grid gridBlock">
        <div class="title-login">Регестрация клиента</div>
        <div class="content-login">
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'cregistry-add-form',
                    'enableClientValidation'=>false,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>false,
                    ),
                    'enableAjaxValidation'=>true,
                )); ?>
                <div class="row">
                    <?php echo $form->textField($model,'name',array('placeholder'=>'Имя')); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textField($model,'email',array('placeholder'=>'Email')); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
                <div class="row">
                    <?php echo $form->passwordField($model,'password',array('placeholder'=>'Пароль')); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textField($model,'phone',array('placeholder'=>'Телефон')); ?>
                    <?php echo $form->error($model,'phone'); ?>
                </div>
                <div class="row">
                    <?php echo $form->textField($model,'city',array('placeholder'=>'Город')); ?>
                    <?php echo $form->error($model,'city'); ?>
                </div>
                <div class="row buttons grid">
                    <div class="col-btn">
                        <?php echo CHtml::submitButton('ЗАРЕГЕСТРИРОВАТЬСЯ',array('class'=>'button')); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="col-or-reg content-login">
            <div>
                Или вы можете <a href="#" class="my-a">войти</a>
            </div>
        </div>
    </div>
</div>