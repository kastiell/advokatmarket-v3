<div class="form chlogin_form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'client-chlogin-edit-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="row">
        <div class="title_form">Данные логина</div>
    </div>

    <div class="row">
        <?php echo $form->textField($model,'email',array('placeholder'=>"email")); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'password_old',array('placeholder'=>"Старьій пароль",'class'=>'i-default')); ?>
        <?php echo $form->error($model,'password_old'); ?>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'password',array('placeholder'=>"Новьій пароль",'class'=>'i-default')); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'password_repeat',array('placeholder'=>"Повторите пароль",'class'=>'i-default')); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('СОХРАНИТЬ',array('class'=>'button')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>