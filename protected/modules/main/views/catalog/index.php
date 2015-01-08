<?php
    Yii::app()->clientScript->registerPackage('main.catalog');

Yii::app()->clientScript->registerCoreScript('jquery');
//Yii::app()->clientScript->registerPackage('main.index');
Yii::app()->clientScript->registerCoreScript('maskedinput');
Yii::app()->clientScript->registerCoreScript('ask');
Yii::app()->clientScript->registerPackage('jquery-ui');
//Yii::app()->clientScript->registerCoreScript('yiiactiveform');

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
</script>

<div class="block-catalog">
    <div class="grid">
       <div class="col-title-top-c title-index">
           <span>Каталог исполнителей</span>
       </div>

       <div class="col-left-cpanel">
       <div class="grid maxwidth">
           <div class="col-top-cc">
               <div class="padding_wrap">
                   <?php
                   $form=$this->beginWidget('CActiveForm', array(
                       'action'=>CController::createUrl('/main/catalog/index'),
                       'method'=>'GET'
                   ),array('id'=>'find-city')); ?>
                        <input type="text" name="city" placeholder="Город"><button class="b-search"></button>
                   <?php $this->endWidget(); ?>
               </div>
           </div>
           <div class="col-bot-cc">
               <div class="title-spec">Специализация</div>
               <ul class="catalog_lawyer_category">
                   <?php
                   //TODO Вібрать локализацию

                   $sp = Yii::app()->request->getQuery('sp', null);
                   foreach($category as $k=>$v){
                       $link = CHtml::encode(CController::createUrl('/main/catalog/index',array('sp'=>$v->ru)));
                       $classSelected = $sp == $v->ru ? 'selected-sp' : '';
                       $s = '<li><a href="'.$link.'" class="fill-a '.$classSelected.'">';
                       $s .= $v->ru;
                       $s .= '</a></li>';
                       echo $s;
                   }
                   ?>
               </ul>
           </div>
       </div>
       </div>
        <div class="col-ccontent">
            <div class="top-radius">
            </div>
            <div class="content-block-catalog">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'application.modules.main.views.catalog._list', // представление для одной записи
                    'ajaxUpdate'=>false, // отключаем ajax поведение
                    'emptyText'=>'<div class="empty-find"><span>'.Yii::app()->params['emptyFind'].'</span>'.
                        CHtml::button('Очистить фильтр',array('class'=>'button b-yellow','onclick'=>'window.location.assign("'.CController::createUrl('/main/catalog/index').'")')).'</div>',
                    'summaryText'=>"",
                    'pager' => array(
                        'header' => '',
                        'nextPageLabel' => '&rarr;',
                        'prevPageLabel' => '&larr;',
                        //'lastPageCssClass' => 'pLast',
                        'nextPageCssClass' => 'pNext',
                        'previousPageCssClass' => 'pPrevious',
                        'selectedPageCssClass' => 'pSelected',
                        'internalPageCssClass' => 'pPage',
                    ),
                )); ?>

            </div>
            <div class="bot-list-radius">

            </div>
        </div>
    </div>
</div>