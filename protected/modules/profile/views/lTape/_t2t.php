<?php
    if($data->status == 'expected'){
    $request_lead = $data;
    $data = Lead::model()->findByPk($data->id_lead);
    $client = Client::model()->findByPk($data->id_client);

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


?>

    <div class="grid items">
        <div class="col-left-11">
            <div class="title-df"><?=CHtml::link($data->title_ask,array('leadControl/LInfo','id_lead'=>$data->id),array('class'=>'a-com'))?></div>
            <div class="content-tape"><?=$data->ask?></div>
            <div class="type-df">
                <div class="grid spec-block-float">
                    <div class="col-sp-float"><a href="<?=CController::createUrl('/main/catalog/index',array('sp'=>$type_q))?>"><?=$type_q?></a></div>
                    <!--<div class="col-name"><?=$client->name?></div>-->
                </div>
            </div>
        </div>
        <div class="col-right-11">
            <div class="cost-dv"><span></span><?=$data->cost_lead?> грн</div>
            <div class="time-dv"><span></span><?=$d?></div>
            <div class="city-dv"><span></span><?=Client::model()->findByPk($data->id_client)->city?></div>
        </div>

    </div>

    <!--<div style="border: 1px solid #000;margin: 10px 0;">
        <div>
            <span><?=CHtml::link($data->title_ask,array('leadControl/LInfo','id_lead'=>$data->id))?></span>
            <div><?=$data->ask?></div>
            <span><?=CHtml::link('Переглянути',array('leadControl/LInfo','id_lead'=>$data->id))?></span>
            <span><?=CHtml::link('Відмінити',array('leadControl/LCnlRqstDirect','id_lead'=>$data->id))?></span>
        </div>
    </div>-->
<?php
    }
?>





