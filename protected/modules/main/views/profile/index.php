<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('simplemodal');
Yii::app()->clientScript->registerPackage('ask');
Yii::app()->clientScript->registerPackage('main.profile');
Yii::app()->clientScript->registerPackage('main.catalog');
Yii::app()->clientScript->registerCoreScript('maskedinput');



//TODO Добавить online
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
            function(){
                $('.step-all').addClass('form-1-open').removeClass('form-2-open').removeClass('form-3-open');
            },
            function(){
                $('.step-all').addClass('form-2-open').removeClass('form-1-open').removeClass('form-3-open');
            },
            function(){
                $('.step-all').addClass('form-3-open').removeClass('form-2-open').removeClass('form-1-open');
            }
        ];
    });

    $(function(){
        $('#call-lawyer').click(function(){
            $('#basic-modal-content').modal({
                persist:true
            });
        });

        $("#AskForm_phone").mask('<?=Yii::app()->params['maskPhone']?>');
        $("#AskForm_city").autocomplete({source: "index.php?r=main/registry/city",minLength:2});

    });
</script>
<div id="basic-modal-content">

    <?php
        echo $__form;
    ?>

</div>

<div id="all">
    <div id="contentInAll">
        <div class="grid">
            <div class="col-top-title">
                <span class="title-login">Профиль юриста</span>
            </div>
            <div class="col-main-left-1">
                <div class="grid">
                    <div class="col-main-1">
                        <div class="grid">
                            <div class="col-1-1">
                                <div id="logoLawyer">
                                    <?php $this->widget('application.components.widgets.logo.LogoWidget',array('params'=>array('id'=>$lawyer->id,
                                        'htmlOptions'=>array('style'=>'width:100%;height:100%;')))); ?>
                                </div>
                                <div id="onlineLawyer">offline</div>
                            </div>
                            <div class="col-1-2">
                                <div id="nameLawyer"><?=$lawyer->name.' '.$lawyer->first_name?></div>
                                <div id="starLawyer">
                                </div>
                                <div id="cityLawyer">

                                    Учебное заведение: <?=$lawyer->vnz?>,<br>Факультет: <?=$lawyer->faculty?>,<br> Год окончания: <?=$lawyer->year_leave?>

                                </div>
                            </div>
                            <div class="col-1-3">
                                <?php
                                    if(!Yii::app()->user->checkAccess('close_index_page_for_lawyer')){
                                ?>
                                    <button class="btn btn-primary b-yellow" id="call-lawyer">ЗАКАЗАТЬ УСЛУГУ</button>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-main-2">
                        <div class="grid grid_padding">
                            <div class="col-3-1 ">
                                Практики
                            </div>
                            <div class="col-3-2">
                                <?php
                                    //TODO Здесь тоже очень очень криво
                                    $spec = substr($lawyer->spec,2,-2);
                                    if($spec != ''){
                                        $arr_spec = explode('","',$spec);
                                        $spec = '<div class="spec_class">  — ';
                                        foreach($arr_spec as $v){
                                            $spec .= $v.'</div><div class="spec_class">  — ';
                                        }
                                        $spec = substr($spec,0,-30);
                                    }
                                    echo $spec;
                                ?>
                            </div>
                            <div class="col-3-3">
                                Опыт
                            </div>
                            <div class="col-3-4">
                                <?=$lawyer->exp?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>