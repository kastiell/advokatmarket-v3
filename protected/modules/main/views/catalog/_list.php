<?php


    $lawyer = Lawyer::model()->findByPk($data->id); //Не знаю но думаю что это сделано криво
    $arr_type = array('lawyer'=>'Юристконсул','notary'=>'Нотаріус','advocate'=>'Адвокат');

    $spec = substr($lawyer->spec,2,-2);
    if($spec != ''){
        $arr_spec = explode('","',$spec);
        $spec = '';
        foreach($arr_spec as $v){
            $spec .= '<div class="col-sp-float"><a href="'.CController::createUrl('/main/catalog/index',array('sp'=>$v)).'">'.$v.'</a></div>';
        }
        //$spec = substr($spec,0,-5);
    }
?>

<div class="list">
    <div class="cgrid">
    <div class="grid col-ff">
        <div class="col-logo">
            <?php $this->widget('application.components.widgets.logo.LogoWidget',array('params'=>array('id'=>$lawyer->id,'htmlOptions'=>array('class'=>'logo-aimg')))); ?>
        </div>
    <div class="col-info">
        <div class="top-title-block">
            <div class="info-pib"><?=CHtml::link($lawyer->first_name.' '.$lawyer->name.' '.$lawyer->last_name,array('profile/index','id'=>$lawyer->id),array('class'=>'link-name'))?></div>
            <div class="info-city"><span class="city-img">&nbsp;</span>&nbsp;<a href="<?=CController::createUrl('/main/catalog/index',array('city'=>$lawyer->city))?>"><?php $this->widget('application.components.widgets.translateCity.TranslateCityWidget',array('params'=>array('city'=>$lawyer->city,'lang'=>'ru','separator'=>'')));?></a></div>
        </div>
        <div class="edu-data">
            <?=$lawyer->vnz?>,
            факультет <?=$lawyer->faculty?>,
            год окончания <?=$lawyer->year_leave?>
        </div>
        <div class="about-me">
            <div class="grid spec-block-float">
                <?=$spec?>
            </div>
        </div>
        <div class="but-start"><?php
            if(!Yii::app()->user->checkAccess('close_index_page_for_lawyer')){
                echo CHtml::ajaxButton('ЗАКАЗАТЬ УСЛУГУ', array('/main/ask/GetForm'), array(
                        'type' => 'POST',
                        'data'=>array('id_lawyer'=>$lawyer->id),
                        'update' => '#col-add-ask-'.$lawyer->id,
                        'beforeSend'=>'function(){$(".col-add-ask").empty()}'
                    ),
                    array('class'=>'button b-little-height'));
            }

            ?>
        </div>
    </div>

</div>
<div class="col-add-ask" id="col-add-ask-<?=$lawyer->id?>"></div>
</div>
</div>