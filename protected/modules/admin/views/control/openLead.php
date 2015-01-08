<div>
    <div>Дата створення: <span><?=date("d.m.Y H:m:s",$lead->time_make)?></span></div>
    <div><span><?=CHtml::encode($lead->ask)?></span></div>
    <div><?=CHtml::link('Відмінити',array('/admin/control/deactivateLead','id_lead'=>$lead->id))?></div>
</div>
<div class="box-desc">
    <div class="form">
        <?php
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'open-admin-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>false,
            ),
            'enableAjaxValidation'=>true,
        )); ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <div class="row">
            <?php echo $form->labelEx($model,'cost_lead'); ?>
            <?php echo $form->textField($model,'cost_lead'/*,array('disabled'=>"true")*/); ?>
            <?php echo $form->error($model,'cost_lead'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'title_ask'); ?>
            <?php echo $form->textField($model,'title_ask'); ?>
            <?php echo $form->error($model,'title_ask'); ?>
        </div>
        <div class="row">
            <?php echo $form->hiddenField($model,'id_lead'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Відправити пропозицію'); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
