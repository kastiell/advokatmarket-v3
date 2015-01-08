<?php

    switch($data->type_ask){
        case 'support': $type_q = 'Консультация под ключь';
        case 'detail': $type_q = 'Детальная консультация';
        case 'simple': $type_q = 'Простая консультация';
    }

    if(date('d.m.Y',$data->time_make)===date('d.m.Y',time())){
        $d = 'Сегодня';
    }else{
        $d = date('d.m.Y',$data->time_make);
    }

    if($data->status == 'list'){
?>
        <div class="grid items">
            <div class="col-left-11">
                <div class="title-df"><?=CHtml::link($data->title_ask,array('leadControl/LInfo','id_lead'=>$data->id),array('class'=>'a-com'))?></div>
                <div class="content-tape"><?=$data->ask?></div>
                <div class="type-df">
                    <div class="grid spec-block-float">
                        <div class="col-sp-float"><a href="<?=CController::createUrl('/main/catalog/index',array('sp'=>$type_q))?>"><?=$type_q?></a></div>
                    </div>
                </div>
            </div>
            <div class="col-right-11">
                <div class="cost-dv"><span></span><?=$data->cost_lead?> грн</div>
                <div class="time-dv"><span></span><?=$d?></div>
                <div class="city-dv"><span></span><?=Client::model()->findByPk($data->id_client)->city?></div>
            </div>

        </div>
<?php
    }
?>




