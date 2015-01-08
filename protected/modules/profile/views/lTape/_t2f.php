<?php
    if($data->status == 'expected'){
    $data = Lead::model()->findByPk($data->id_lead);
?>
    <div style="border: 1px solid #000;margin: 10px 0;">
        <div>
            <span><?=CHtml::link($data->title_ask,array('leadControl/LInfo','id_lead'=>$data->id))?></span>
            <div><?=$data->ask?></div>
            <span><?=CHtml::link('Переглянути',array('leadControl/LInfo','id_lead'=>$data->id))?></span>
            <span><?=CHtml::link('Відмінити',array('leadControl/LCnlRqst','id_lead'=>$data->id))?></span>
        </div>
    </div>
<?php
    }
?>