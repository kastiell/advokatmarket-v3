<?php
    if($data->deadline == 1){
        $deadline = '1 день';
    }else if(($data->deadline > 1)and($data->deadline < 5)){
        $deadline = $data->deadline.' дня';
    }else{
        $deadline = $data->deadline.' дней';
    }

    $lead = Lead::model()->findByPk($data->id_lead);
    $lawyer = Lawyer::model()->findByPk($data->id_lawyer);
?>
    <!--<div style="border: 1px solid #000;margin: 10px 0;">
        <div>
            <span>COMMON</span>
            <span><?=CHtml::link($lead->title_ask,array('leadControl/CInfo','id_request'=>$data->id))?></span>
            <div><?=$lead->ask?></div>
            <span><?=CHtml::link('Переглянути',array('leadControl/CInfo','id_request'=>$data->id))?></span>
            <span><?=CHtml::link('Відмінити',array('leadControl/CCnlRqst','id_request'=>$data->id))?></span>
            <span><?=CHtml::link('Прийняти',array('leadControl/CAcptRqst','id_request'=>$data->id))?></span>
        </div>
    </div>-->

    <div class="grid item_grid t2">
        <div class="col-logo">
            <div>
                <?php $this->widget('application.components.widgets.logo.LogoWidget',array('params'=>array('id'=>$data->id_lawyer,
                    'htmlOptions'=>array('style'=>'width:100%;height:100%;')))); ?>
            </div>
        </div>
        <div class="col-left1">
            <div class="title-tape"><?=CHtml::link($lawyer->first_name.' '.$lawyer->name,array('/main/profile/index','id'=>$lawyer->id),array('class'=>'a-com'))?></div>
            <div class="content-tape"><?=$lead->title_ask?></div>
            <div class="button-bot">
                <div>
                    <span><?=CHtml::link('ПОСМОТРЕТЬ',array('leadControl/CInfo','id_request'=>$data->id),array('class'=>'button'))?></span>
                    <?php
                        if($data->status == 'expected'){
                    ?>
                        <span><?=CHtml::link('ПРИНЯТЬ',array('leadControl/CAcptRqst','id_request'=>$data->id),array('class'=>'button'))?></span>
                    <?php
                        }else{
                    ?>
                        <span><?=CHtml::link('ПРИНЯТЬ',array('leadControl/CAcptDirect','id_request'=>$data->id),array('class'=>'button'))?></span>
                        <?php
                        }
                    ?>
                    <span><?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlRqst','id_request'=>$data->id),array('class'=>'button b-red'))?></span>
                </div>
            </div>
        </div>
        <div class="col-right1">
            <div class="pay-bd"><span></span><?=$data->cost_service?> грн</div>
            <div class="lo-bd"><span></span><?=$deadline?></div>
        </div>
    </div>