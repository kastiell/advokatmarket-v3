<?php
    Yii::app()->clientScript->registerPackage('profile.tape');

    switch($data->type_ask){
        case 'support': $type_q = 'Консультация под ключь';
        case 'detail': $type_q = 'Детальная консультация';
        case 'simple': $type_q = 'Простая консультация';
    }
?>

<div class="wrap-margin-info">

    <div class="title-info-b"><?=CHtml::encode($data->title_ask)?></div>
    <div class="text-info-b"><?=CHtml::encode($data->ask)?></div>
    <div class="grid mmm-cont">
        <div class="col-type-info-b"><span>Тип требуемой услуги: </span><span><?=CHtml::encode($type_q)?></span></div>
        <div class="col-time-info-b"><?=date(' d.m.Y в H:m',$data->time_make)?></div>
    </div>

    <?php
    if($mode == 'lead'){
        if($data->status == 'make'){
            ?>
            <div class="button-info-b"><?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlMake','id_lead'=>$data->id),array('class'=>'button'))?></div>
        <?php
        }else if($data->status == 'list'){
        ?>
            <div class="button-info-b"><?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlLead','id_lead'=>$data->id),array('class'=>'button b-red'))?></div>
        <?php
        }
    }else if($mode == 'request'){
        if($request->status == 'expected'){
        ?>
            <div class="button-info-b"><?=CHtml::link('ПРИНЯТЬ',array('leadControl/CAcptRqst','id_request'=>$request->id),array('class'=>'button'))?> <?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlRqst','id_request'=>$request->id),array('class'=>'button b-red'))?></div>
        <?php
        }else{
        ?>
            <div class="button-info-b"><?=CHtml::link('ПРИНЯТЬ',array('leadControl/CAcptDirect','id_request'=>$request->id),array('class'=>'button'))?> <?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlRqst','id_request'=>$request->id),array('class'=>'button b-red'))?></div>
        <?php
        }
    }
        ?>
</div>
