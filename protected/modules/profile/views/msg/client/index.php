<?php

Yii::app()->clientScript->registerScript('js3','
    var XMPP = {};
    XMPP.hash = "'.$dataXAMPP['hash'].'";
    XMPP.idMe = "'.$info['me']['id'].'";
    XMPP.idTo = "'.$info['to']['id'].'";
    XMPP.idCons = "'.$dataXAMPP['idCons'].'";
    XMPP.status = "'.$dataXAMPP['status'].'";
    XMPP.cost = "'.$dataXAMPP['cost'].'";

    XMPP.ROLE_CLIENT = "'.User::CLIENT.'";
    XMPP.ROLE_LAWYER = "'.User::LAWYER.'";

    XMPP.info = {
        me:{
            name:"'.$info['me']['name'].'",
            first_name:"'.$info['me']['first_name'].'",
            phone:"'.$info['me']['phone'].'",
            email:"'.$info['me']['email'].'",
        },
        to:{
            name:"'.$info['to']['name'].'",
            first_name:"'.$info['to']['first_name'].'",
            phone:"'.$info['to']['phone'].'",
            email:"'.$info['to']['email'].'",
        }
    };

    XMPP.type_user = "'.$info['me']['type_user'].'";
    XMPP.uri_server = "'.CController::createUrl('/profile/chat/addmsg').'".replace(/(.*\/).*/,"$1");
',CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('webroot.public.assets.profile.js').'/myXMPP.js'
),CClientScript::POS_END);

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('jquery-ui');
Yii::app()->clientScript->registerPackage('strophe');
Yii::app()->clientScript->registerPackage('simplemodal');
Yii::app()->clientScript->registerPackage('profile.msg');
?>

<?php
    if($info['me']['type_user'] === User::LAWYER){
?>
<div id="basic-modal-content">
    <?php
    $scenario = 'pay';
    $form=$this->beginWidget('CActiveForm', array(
        'action'=>array('/profile/msg/ValidStep','scenario'=>$scenario),
        'id'=>'chat-'.$scenario.'-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnChange'=>false,
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:function(form,data,hasError){if(!hasError){VII.sendPay(form,data,hasError);}}'
        ),
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="title-modal">
        Вы можете отправить запрос на оплату
    </div>
    <div class="content-modal">
        <?php echo $form->textField($models['pay'],'pay_cost',array('placeholder'=>'Введите цену консультации')); ?>
        <?php echo $form->error($models['pay'],'pay_cost'); ?>
    </div>
    <div class="btn-modal">
        <?php echo CHtml::submitButton('ОТПРАВИТЬ',array('id'=>'submit_pay_cost','class'=>'button'))?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
    }
?>

<?php
    if($info['me']['type_user'] === User::CLIENT){
?>
<div id="basic-modal-content-reviews" style="display: none;">
    <?php
    $scenario = 'reviews';
    $form=$this->beginWidget('CActiveForm', array(
        'action'=>array('/profile/msg/ValidStep','scenario'=>$scenario),
        'id'=>'chat-'.$scenario.'-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnChange'=>false,
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:function(form,data,hasError){if(!hasError){VII.sendReviews(form,data,hasError);}}'
        ),
        'enableAjaxValidation'=>true,
    )); ?>
    <div class="title-modal">
        Вы можете написать отзыв о юристе
    </div>
    <div class="content-modal">
        <?php echo $form->textArea($models['reviews'],'txt',array('placeholder'=>'Напишите отзыв')); ?>
        <?php echo $form->error($models['reviews'],'txt'); ?>
    </div>
    <div class="btn-modal">
        <?php echo CHtml::submitButton('Отправить',array('id'=>'submit_reviews','class'=>'button'))?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
    }
?>
<div class="all-chat">
    <div class="grid maxwidth">
        <div class="col-z1">
            <div class="grid maxwidth">
                <?php
                    if(Yii::app()->user->role == User::CLIENT){
                ?>
                        <div class="col-i1">
                            <div class="logo">
                                <?php $this->widget('application.components.widgets.logo.LogoWidget',array('params'=>array('id'=>$info['to']['id'],
                                    'htmlOptions'=>array('style'=>'width:100%;height:100%;')))); ?>
                            </div>
                        </div>
                        <div class="col-i2">
                            <div class="name"><span class="name1"><?=$info['to']['first_name'].' '.$info['to']['name']?></span> <span class="presence1 offline"></span></div>
                            <div class="phone"><span>Телефон:</span><?=$info['to']['phone']?></div>
                            <div class="email"><span>E-mail:</span><?=$info['to']['email']?></div>
                        </div>
                        <div class="col-i5">
                            <!--<div>Стоимость услуги:</div>
                            <div> грн</div>-->
                        </div>
                <?php
                    }else{
                ?>
                    <div class="col-i2-n">
                        <div class="name"><span class="name1"><?=$info['to']['first_name'].' '.$info['to']['name']?></span> <span class="presence1 offline"></span></div>
                        <div class="phone"><span>Телефон:</span><?=$info['to']['phone']?></div>
                        <div class="email"><span>E-mail:</span><?=$info['to']['email']?></div>
                    </div>
                    <div class="col-i5-n">
                        <div><span></span><span><?=Client::model()->findByPk($info['to']['id'])->city?></span></div>
                    </div>
                <?php
                    }
                ?>

                <div class="col-i3">
                    <div id="cons-st">

                    </div>
                    <div id="options-block">
                        <div class="block-start block-pay block-cons">
                            <?=CHtml::button('ЗАВЕРШЫТЬ',array('id'=>'close_consultation','class'=>'button b-red'))?>
                        </div>
                        <?php
                            if(($info['me']['type_user'] === User::LAWYER)&&($dataXAMPP['status'] === 'start')){
                        ?>
                                <div class="block-start" id="pay_button">
                                    <?=CHtml::button('Відправити запит на оплату',array('id'=>'pay_consultation','class'=>'button'))?>
                                </div>
                        <?php
                            }
                        ?>
                        <div class="block-review" id="review_button">
                            <?=CHtml::button('Відправити відклик',array('id'=>'review_consultation','class'=>'button'))?>
                        </div>
                    </div>
                </div>
                <div class="col-i4">
                    <div><span>Тема: </span><span><?=Lead::model()->findByAttributes(array('id_consultation'=>$idCons))->title_ask?></span></div>
                </div>
            </div>
        </div>
        <div class="col-z2">
            <div class="item grid maxwidth me">
                <div class="col-d1"><?php
                    $id_client = Lead::model()->findByAttributes(array('id_consultation'=>$idCons))->id_client;
                    if($info['me']['id'] == $id_client){
                        echo $info['me']['name'];
                    }else{
                        echo $info['to']['name'];
                    }
                    ?>:
                </div>
                <div class="col-d2"><?=Lead::model()->findByAttributes(array('id_consultation'=>$idCons))->ask?></div>
            </div>
            <?php $this->renderMsg($dataMsg,$info,$info['me']['type_user']); ?>
        </div>
        <div class="col-z3">
            <div id='login'>
                <div><textarea id="msg-value"></textarea></div>
                <div class="send-block grid">
                    <div class="col-left-send"><input type="button" id="send" value="ОТПРАВИТЬ" class="button"></div>
                    <div class="col-right-send"><a href="#" class="a-com">Прикрепить файл</a></div>
                </div>
            </div>
        </div>
    </div>
</div>