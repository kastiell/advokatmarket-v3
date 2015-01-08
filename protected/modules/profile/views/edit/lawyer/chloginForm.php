<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'chlogin-edit-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>

    <div class="grid maxwidth">
        <div class="col-titleField"><?php echo $form->labelEx($model,'email'); ?>:</div>
        <div class="col-inpField"><?php echo $form->textField($model,'email'/*,array('disabled'=>"true")*/); ?>
            <?php echo $form->error($model,'email'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'password_old'); ?>:</div>
        <div class="col-inpField"><?php echo $form->passwordField($model,'password_old'); ?>
            <?php echo $form->error($model,'password_old'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'password'); ?>:</div>
        <div class="col-inpField"><?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?></div>

        <div class="col-titleField"><?php echo $form->labelEx($model,'password_repeat'); ?>:</div>
        <div class="col-inpField"><?php echo $form->passwordField($model,'password_repeat'); ?>
            <?php echo $form->error($model,'password_repeat'); ?></div>

        <div class="col-titleField"></div>
        <div class="col-inpField buttons"><?php echo CHtml::submitButton('СОХРАНИТЬ',array('class'=>'button')); ?></div>
    </div>

    <?php $this->endWidget(); ?>
</div>