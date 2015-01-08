<?php
Yii::app()->clientScript->registerPackage('profile.tape');

switch($lead->type_ask){
    case 'support': $type_q = 'Консультация под ключь';
    case 'detail': $type_q = 'Детальная консультация';
    case 'simple': $type_q = 'Простая консультация';
}

?>

<div class="wrap-margin-info">
    <div class="title-info-b"><?=CHtml::encode($lead->title_ask)?><span class="cost-linfo-span"><span></span><?=$lead->cost_lead?> грн</span></div>
    <div class="text-info-b"><?=CHtml::encode($lead->ask)?></div>
    <div class="grid mmm-cont">
        <div class="col-type-info-b"><span>Тип требуемой услуги: </span><span><?=CHtml::encode($type_q)?></span></div>
        <div class="col-time-info-b"><?=date(' d.m.Y в H:m',$lead->time_make)?></div>
    </div>

    <?php
        if($this->mode == 'no_request'){
    ?>
    <div class="send-form-block">
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'box-description-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false,
        ),
        'enableAjaxValidation'=>true,
    )); ?>
        <div class="grid form-send">

            <div class="col-title-linfo-form">
                Стоимость услуги
            </div>
            <div class="col-input-linfo-form">
                <span>
                    <?php echo $form->textField($model,'cost'/*,array('disabled'=>"true")*/); ?>
                    <?php echo $form->error($model,'cost'); ?>
                </span>
                <span>
                    грн
                </span>
            </div>

            <div class="col-title-linfo-form">
                Срок выполнения
            </div>
            <div class="col-input-linfo-form">
                <span>
                    <?php echo $form->textField($model,'data_success'); ?>
                    <?php echo $form->error($model,'data_success'); ?>
                </span>
                <span>
                    дней
                </span>
            </div>

            <div class="col-radio-linfo-form">
                <?php echo CHtml::activeRadioButtonList($model,'type_work',array('online'=>'Оказать услугу только онлайн','online&offline'=>'Оказать услугу можно как онлайн так и оффлайн','offline'=>'Оказать услугу оффлайн'));?>
                <?php echo $form->error($model,'type_work'); ?>
            </div>

            <div class="col-btn-linfo-form">
                <?php echo $form->hiddenField($model,'id_lead'); ?>
            </div>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('ОТПРАВИТЬ ПРЕДЛОЖЕНИЕ',array('class'=>'button')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php
        }else if($this->mode == 'exist_request'){
        $request_lead = RequestLead::model()->findByAttributes(array('id_lead'=>$lead->id,'id_lawyer'=>Yii::app()->user->getId()));
    ?>
    <div class="ss-block-linfo-form">
        <div class="cost-ss-block"><span>Цена услуги: </span><span><?=CHtml::encode($request_lead->cost_service)?> грн</span></div>
        <div class="cost-ss-block"><?=CHtml::link('Відмінити',array('leadControl/LCnlRqst','id_lead'=>$lead->id),array('class'=>'button'))?></div>
    </div>
    <?php
        }else if($this->mode == 'chat_open'){
        $request_lead = RequestLead::model()->findByAttributes(array('id_lead'=>$lead->id,'id_lawyer'=>Yii::app()->user->getId()));
    ?>
    <div class="ss-block-linfo-form">
            <div class="cost-ss-block"><span>Цена услуги: </span><span><?=CHtml::encode($request_lead->cost_service)?> грн</span></div>
            <div class="cost-ss-block">
                <?=CHtml::link('ОПЛАТИТЬ',array('leadControl/LPay','id_lead'=>$lead->id),array('class'=>'button'))?>
                <?=CHtml::link('ОТМЕНИТЬ',array('leadControl/LCnlRqstDirect','id_lead'=>$lead->id),array('class'=>'button b-red'))?>
            </div>
        </div>
    <?php
        }
    ?>
</div>