
<?php
    if($data->status == 'list'){
?>
    <div class="grid item_grid">
        <div class="col-left1">
            <div class="title-tape"><?=CHtml::link($data->title_ask,array('leadControl/CInfo','id_lead'=>$data->id),array('class'=>'a-com'))?></div>
            <div class="content-tape"><?=$data->ask?></div>
            <div class="button-bot">
                <div>
                    <span><?=CHtml::link('ПОСМОТРЕТЬ',array('leadControl/CInfo','id_lead'=>$data->id),array('class'=>'button'))?></span>
                    <span><?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlLead','id_lead'=>$data->id),array('class'=>'button b-red'))?></span>
                </div>
            </div>
        </div>
        <div class="col-right1">
            <div class="right-time"><?=date(' d.m.Y в H:m',$data->time_make)?></div>
        </div>
    </div>
<?php
    }else if($data->status == 'make'){
?>
        <div class="grid item_grid">
            <div class="col-left1">
                <!--<div class="title-tape"><?=CHtml::link($data->ask,array('leadControl/CInfo','id_lead'=>$data->id),array('class'=>'a-com'))?></div>-->
                <div class="content-tape"><?=$data->ask?></div>
                <div class="button-bot">
                    <div>
                        <span><?=CHtml::link('ПОСМОТРЕТЬ',array('leadControl/CInfo','id_lead'=>$data->id),array('class'=>'button'))?></span>
                        <span><?=CHtml::link('ОТМЕНИТЬ',array('leadControl/CCnlMake','id_lead'=>$data->id),array('class'=>'button b-red'))?></span>
                    </div>
                </div>
            </div>
            <div class="col-right1">
                <div class="right-time"><?=date(' d.m.Y в H:m',$data->time_make)?></div>
            </div>
        </div>
<?php
    }
?>




