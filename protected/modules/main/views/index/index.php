<?php

if(Yii::app()->user->checkAccess('close_index_page_for_lawyer')){
    $this->redirect(CController::createUrl('/profile/edit/general'));
}

$this->pageTitle=Yii::app()->name;
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('yiiactiveform');
Yii::app()->clientScript->registerPackage('simplemodal');
Yii::app()->clientScript->registerPackage('main.index');
Yii::app()->clientScript->registerCoreScript('maskedinput');
Yii::app()->clientScript->registerPackage('jquery-ui');
Yii::app()->clientScript->registerPackage('ask');
Yii::app()->clientScript->registerPackage('jgrow');

//TODO Когда будет реализовано выпадание полей телефон, емаил и т.д нужно будет создать класс который будет отображать или скрывать ошибки валидации
?>

<script>
    $(function(){

        window.hasLogin = '<?=!Yii::app()->user->isGuest?>';

        window.FORM.reload2link = function(){
            location.assign('<?=CController::createUrl('/profile/CTape/T1')?>');
        }

        window.FORM.callStep.callObj = [null,
            function(form,step){
                window.FORM.DATA[step] = $(form).serialize();
                FORM.openForm[2]();
            },
            function(form,step){
                window.FORM.DATA[step] = '&'+$(form).find('input[name="AskForm[type_ask]"]').serialize();
                var id_lawyer = 0;
                if($(form).attr('data-id_lawyer')){
                    id_lawyer = parseInt($(form).attr('data-id_lawyer'));
                }
                $.ajax({
                    url:"<?=CController::createUrl('/main/ask/addAsk')?>"+"&id_lawyer="+id_lawyer,
                    data:FORM.DATA[1]+FORM.DATA[2],
                    type:'POST',
                    dataType:'json'
                }).always(function(msg){
                    console.log( "Data Saved: ",msg );
                    if(msg)
                        if(msg.status)
                            switch(msg.status){
                                case 'ok_next':{

                                    $('.email-text-ins').text(msg.email);
                                    $('.pass-text-ins').text(msg.pass);
                                    $('#passHidden').val(msg.pass);
                                    $('#idUser').val(msg.id_user);

                                    FORM.openForm[3]();

                                    break;
                                }
                                case 'ok_end':{
                                    FORM.reload2link();
                                    break;
                                }
                                case 'error':{
                                    alert('Виникла помилка!');
                                    break;
                                }
                            }
                });
            },
            function(form,step){
                $.ajax({
                    url:"<?=CController::createUrl('/main/ask/SavePassword')?>",
                    data:$(form).serialize(),
                    type:'POST',
                    dataType:'json'
                }).always(function(msg){
                    console.log( "Data Saved: ",msg );
                    if(msg)
                        if(msg.status)
                            switch(msg.status){
                                case 'ok_end':{
                                    FORM.reload2link();
                                    break;
                                }
                                case 'error':{
                                    alert('Виникла помилка!');
                                    break;
                                }
                            }
                });
            }
        ];

        FORM.openForm = [null,
            function(){},
            function(){
                $('.step-2').addClass('open_form').removeClass('close_form');
                $('.step-3').removeClass('open_form').addClass('close_form');
                $('#basic-modal-content').modal({
                    persist:true
                });
            },
            function(){
                $('.step-3').addClass('open_form').removeClass('close_form');
                $('.step-2').removeClass('open_form').addClass('close_form');

                $('.modalCloseImg.simplemodal-close').css('display','none');
            }
        ];

        $("#IndexForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
        $("#IndexForm_city").autocomplete({source: "index.php?r=main/registry/city",minLength:2});
        window.hasLogin = '<?=!Yii::app()->user->isGuest?>';
        if(window.hasLogin){
            $('.field-on-logout').each(function(){
                $(this).addClass('close');
            });
        }

        $('#call-lawyer').click(function(){
            $('#basic-modal-content').modal({
                persist:true
            });
        });

        $("#AskForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
        $("#AskForm_city").autocomplete({source: "index.php?r=main/registry/city",minLength:2});

        function changeState(){
            $('#send-ask').addClass('full-ask-status');
            $('#send-ask').removeClass('piece-ask-status');
            $('.input-ask-field').focus();
        }
        $('.first-status-change').click(function(){
            if(!window.hasLogin)
                changeState();
        });
        $('.input-ask-field').keyup(function a(){
            var msg = $(this).val();
            if(msg.length > 0){
                if(!window.hasLogin)
                    changeState();
                $(this).off('keyup',a);
            }
        });

        $('.input-ask-field').jGrow({max_height: '300px'});

    });
</script>

<div class="content-index">
    <div class="find-block-index">
        <div class="title-index">Найди юриста и получи консльтуцию онлайн</div>
        <div class="grid find-lawyer-index">
            <?php
            $form=$this->beginWidget('CActiveForm', array(
                'action'=>CController::createUrl('/main/catalog/index'),
                'method'=>'GET'
            ),array('id'=>'find-city-sp')); ?>
            <div class="col-select-find-index">
                <select name="sp" id="sel_sp">
                    <option value="">Выберете тип проблемы</option>
                    <?php
                        $category = Category::model()->findAll();
                        $s = '';
                        foreach($category as $k=>$v){
                            $s .= '<option value="'.$v->ru.'">';
                            $s .= $v->ru;
                            $s .= '</option>';
                        }
                    echo $s;
                    ?>
                </select>
            </div>
            <div class="col-input-find-index">
                    <input type="text" name="city" id="inp_name" placeholder="Введите ваш город">
            </div>
            <div class="col-but-find-index">
                    <button onclick="if(($('#inp_name').val()=='')&&($('#sel_sp').val()=='')){return false;}">НАЙТИ ЮРИСТА</button>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<div class="content-index piece-ask-status" id="send-ask">
    <?php
    $id_lawyer = 0;
    $form=$this->beginWidget('MCActiveForm', array(
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
    <div class="find-block-index">
        <div class="title-index title-free-block"><span>Или задайте вопрос прямо сейчас</span><div class="title-free"></div></div>
        <div class="grid send-msg-index">
            <div class="grid maxwidth">
                <div class="col-input-send">
                    <?php echo $form->textArea($modelArray[1],'ask',array('placeholder'=>'Задайте вопрос юристу','class'=>'input-ask-field')); ?>
                    <?php echo $form->error($modelArray[1],'ask'); ?>
                </div>
                <div  class="col-button-send">
                    <input class="b-yellow button first-status-change"
                           <?php
                                if(!Yii::app()->user->isGuest){
                                    echo 'type="submit"';
                                }else{
                                    echo 'type="button"';
                                }
                           ?> value="ЗАДАТЬ ВОПРОС">
                </div>
                <div class="col-info-send-msg-index">
                    Отправив запрос Вы получите предложения помощи от нескольких юристов
                </div>

            <div class="col-inp-name">
                <?php echo $form->textField($modelArray[1],'name',array('placeholder'=>'Имя')); ?>
                <?php echo $form->error($modelArray[1],'name'); ?>
            </div>
            <div class="col-inp-phone">
                <?php echo $form->textField($modelArray[1],'phone',array('placeholder'=>'Телефон')); ?>
                <?php echo $form->error($modelArray[1],'phone'); ?>
            </div>
            <div class="col-inp-email">
                <?php echo $form->textField($modelArray[1],'email',array('placeholder'=>'E-mail')); ?>
                <?php echo $form->error($modelArray[1],'email'); ?>
            </div>
            <div class="col-inp-city">
                <?php echo $form->textField($modelArray[1],'city',array('placeholder'=>'Город')); ?>
                <?php echo $form->error($modelArray[1],'city'); ?>
            </div>
            <div class="col-inp-file">
                Добавить файл
            </div>
            <div class="col-inp-submit">
                <input type="submit" class="button b-yellow" value="ОТПРАВИТЬ">
            </div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
</div>
</div>

<div class="bot-box">
    <div class="grid maxwidth content-index-box">
        <div class="col-left-box-i">
            <div class="grid maxwidth">
                <div class="col-info-box">
                    НАЙТИ ЮРИСТА ПО МЕСТОПОЛОЖЕНИЮ
                </div>
                <div class="col-wrap-grid">
                    <div class="grid">
                        <?php
                        $form=$this->beginWidget('CActiveForm', array(
                        'action'=>CController::createUrl('/main/catalog/index'),
                        'method'=>'GET'
                        ),array('id'=>'find-city')); ?>
                        <div class="col-input-box">
                            <select name="city">
                                <option value="Киев">Киев</option>
                                <option value="Харьков">Харьков</option>
                                <option value="Донецк">Донецк</option>
                                <option value="Одесса">Одесса</option>
                            </select>
                        </div>
                        <div class="col-btn-box">
                            <button class="b-search">&nbsp;</button>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-right-box-i">
            <div class="grid maxwidth">
                <div class="col-info-box">
                    НАЙТИ ЮРИСТА ПО ОБЛАСТИ ПРАВА
                </div>
                <div class="col-wrap-grid">
                    <div class="grid">
                        <?php
                        $form=$this->beginWidget('CActiveForm', array(
                            'action'=>CController::createUrl('/main/catalog/index'),
                            'method'=>'GET'
                        ),array('id'=>'find-sp')); ?>
                        <div class="col-input-box">
                            <select name="sp">
                                <?=$s?>
                            </select>
                        </div>
                        <div class="col-btn-box">
                            <button class="b-search">&nbsp;</button>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="basic-modal-content">
    <div class="step-2 close_form">
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
            <?php echo CHtml::button('Назад',array('onclick'=>'$(".modalCloseImg.simplemodal-close").click()','class'=>'button b-yellow'))?>
        </div>
        <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="step-3 close_form">
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
                <div class="text-to"></div>
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





