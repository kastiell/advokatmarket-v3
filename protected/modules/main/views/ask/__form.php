<div class="float-modal-top1">
</div>
<div class="form-block-all">
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('maskedinput');
    Yii::app()->clientScript->registerPackage('jquery-ui');
    Yii::app()->clientScript->registerCoreScript('yiiactiveform');
    Yii::app()->clientScript->registerPackage('jgrow');
?>

<div class="step-all form-1-open">
<div class="step-1">
    <div class="close_btn">
        <span onclick="$('.col-add-ask').empty()">ЗАКРЫТЬ</span><div class="close_cr"></div>
    </div>
    <div class="float-modal-top">
        <span>Пожалуйста, заполните контактные данные.<br> Чтобы юрист смог свами в дальнейшем связаться</span>
    </div>
    <div class="block-margin">

    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'action'=>array('/main/ask/ValidStep','guest'=>Yii::app()->user->isGuest,'step'=>1),
        'id'=>'index-1-main-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnChange'=>false,
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:function(form,data,hasError){if(!hasError){window.FORM.callStep(form,data,hasError);}}'
        ),
        'enableAjaxValidation'=>true,
        'htmlOptions'=>array('data-id_lawyer'=>$id_lawyer)
    )); ?>
    <div class="grid send-msg-index">
        <div class="grid maxwidth">
            <div class="col-input-send">
                <?php echo $form->textArea($modelArray[1],'ask',array('placeholder'=>'Задайте вопрос юристу','class'=>'input-ask-field','style'=>'height:100px;')); ?>
                <?php echo $form->error($modelArray[1],'ask'); ?>
            </div>
            <div class="col-inp-name field-on-logout">
                <?php echo $form->textField($modelArray[1],'name',array('placeholder'=>'Имя')); ?>
                <?php echo $form->error($modelArray[1],'name'); ?>
            </div>
            <div class="col-inp-phone field-on-logout">
                <?php echo $form->textField($modelArray[1],'phone',array('placeholder'=>'Телефон')); ?>
                <?php echo $form->error($modelArray[1],'phone'); ?>
            </div>
            <div class="col-inp-email field-on-logout">
                <?php echo $form->textField($modelArray[1],'email',array('placeholder'=>'E-mail')); ?>
                <?php echo $form->error($modelArray[1],'email'); ?>
            </div>
            <div class="col-inp-city field-on-logout">
                <?php echo $form->textField($modelArray[1],'city',array('placeholder'=>'Город')); ?>
                <?php echo $form->error($modelArray[1],'city'); ?>
            </div>
            <div class="col-inp-file">
                Добавить файл
            </div>
            <div class="col-inp-submit">
                <input type="submit" class="button" value="ОТПРАВИТЬ">
            </div>
        </div>
    <?php $this->endWidget(); ?>
    </div>
</div>
</div>
<div class="step-2">
    <div class="close_btn" onclick="$('.col-add-ask').empty()">
        <span onclick="$('.col-add-ask').empty()">ЗАКРЫТЬ</span><div class="close_cr"></div>
    </div>
    <div class="float-modal-top">
        <span>Какой сложности консультация вам нужна?</span>
    </div>
    <div class="block-margin">
        <?php
        $form=$this->beginWidget('CActiveForm', array(
            'action'=>array('/main/ask/ValidStep','guest'=>Yii::app()->user->isGuest,'step'=>2),
            'id'=>'index-2-main-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnChange'=>false,
                'validateOnSubmit'=>true,
                'afterValidate'=>'js:function(form,data,hasError){if(!hasError){window.FORM.callStep(form,data,hasError);}}'
            ),
            'enableAjaxValidation'=>true,
            'htmlOptions'=>array('data-id_lawyer'=>$id_lawyer)
        )); ?>

            <div class="row">
                <?php echo $form->error($modelArray[3],'type_ask'); ?>
                <div class="radio-to">
                    <label><?php echo $form->radioButton($modelArray[2], 'type_ask', array('value'=>'simple','uncheckValue'=>null
                        )).' Ответ на вопрос (Простой ответ на заданный вопрос)';
                    ?></label>
                </div>
                <div class="text-to">
                    <!--Простой ответ на заданный вопрос-->
                </div>
                <div class="radio-to">
                    <label><?php echo $form->radioButton($modelArray[2], 'type_ask', array('value'=>'detail','uncheckValue'=>null
                        )).' Детальная консультация (Нужна подробная консультация или онлайн)';
                    ?></label>
                </div>
                <div class="text-to">
                    <!--Нужна подробная консультация или онлайн-->
                </div>
                <div class="radio-to">
                    <label><?php echo $form->radioButton($modelArray[2], 'type_ask', array('value'=>'support','uncheckValue'=>null
                        )).' Сопровожденике под ключь';
                    ?></label>
                </div>
            </div>
            <div class="row buttons">
                <?php echo CHtml::submitButton('Отправить',array('class'=>'button'))?>
                <?php echo CHtml::button('Назад',array('onclick'=>'FORM.openForm[1]()','class'=>'button b-yellow'))?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="step-3">
    <div class="float-modal-top">
        <span>Мы создали для вас аккаунт<br> Теперь вы сможете общатся с юристом онлайн</span>
    </div>
    <div class="block-margin">
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'action'=>array('/main/ask/ValidStep','guest'=>Yii::app()->user->isGuest,'step'=>3),
        'id'=>'index-3-main-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnChange'=>false,
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:function(form,data,hasError){if(!hasError){window.FORM.callStep(form,data,hasError);}}'
        ),
        'enableAjaxValidation'=>true,
        'htmlOptions'=>array('data-id_lawyer'=>$id_lawyer)
    )); ?>
    <div class="content-modal-block">
        <div class="row">
            <div class="radio-to">
                Email: <span class="email-text-ins"></span>
            </div>
            <div class="text-to"></div>
            <div class="radio-to">
                Временный пароль: <span class="pass-text-ins"></span>
            </div>
            <div class="row field-on-error">
                <?php echo $form->passwordField($modelArray[3],'pass',array('class'=>'i-default','placeholder'=>"Новый пароль")); ?>
                <?php echo $form->error($modelArray[3],'pass'); ?>
                <?php echo $form->hiddenField($modelArray[3],'pass_hidden',array('id'=>'passHidden')); ?>
                <?php echo $form->hiddenField($modelArray[3],'id_user',array('id'=>'idUser')); ?>
            </div>
        </div>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('ОТПРАВИТЬ',array('class'=>'button'))?>
        <?php echo CHtml::submitButton('ЗАКРЫТЬ',array('class'=>'button b-yellow'))?>
    </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

</div>
<script>
    $("#AskForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
    $("#AskForm_city").autocomplete({source: "index.php?r=main/registry/city",minLength:2});
    window.hasLogin = '<?=!Yii::app()->user->isGuest?>';
    if(window.hasLogin){
        $('.field-on-logout').each(function(){
            $(this).addClass('close');
        });
    }
    $('.input-ask-field').jGrow({max_height: '180px'});
</script>
</div>
</div>
<div class="float-modal-bot">