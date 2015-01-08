<div class="grid items-block-ch">
    <div class="col-left-ch">
        <div class="title-df"><?=CHtml::link($data->title_ask,array('/profile/msg/index','id'=>$data->id_consultation),array('class'=>'a-com'))?></div>
        <div class="content-tape"><span><?=$data->ask?></span></div>
        <div class="content-btn-ch">
            <?php
                if($data->status == 'process'){
            ?>
                <?=CHtml::link('ОТКРЫТЬ',array('/profile/msg/index','id'=>$data->id_consultation),array('class'=>'button'))?>
            <?php
                }else if($data->status == 'accepted'){
            ?>
                    <?=CHtml::link('ОТКРЫТЬ',array('leadControl/LInfo','id_lead'=>$data->id),array('class'=>'button'))?>
                    <?=CHtml::link('ОПЛАТИТЬ',array('leadControl/LPay','id_lead'=>$data->id),array('class'=>'button'))?>
                    <?=CHtml::link('ОТМЕНИТЬ',array('leadControl/LCnlRqstDirect','id_lead'=>$data->id),array('class'=>'button b-red'))?>
            <?php
                }
            ?>
        </div>
    </div>
</div>