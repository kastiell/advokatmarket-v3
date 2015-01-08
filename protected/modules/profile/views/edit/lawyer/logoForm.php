<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('jcrop');

Yii::app()->clientScript->registerCss('cs3','
        #crop{
            display:none;
        }
        #cropresult{
            border:2px solid #ddd;
        }
        .mini{
            margin:5px;
        }
');

Yii::app()->clientScript->registerScript('sc1',"
var x1, y1, x2, y2;
var crop = '';
var jcrop_api;

jQuery(function($){
	$('#target').Jcrop({
            onChange:   showCoords,
            onSelect:   showCoords,
            aspectRatio: 3.2/4
	    },function(){jcrop_api = this;}
    );
    $('#release').click(function(e) {
        release();
    });
	function showCoords(c){
        x1 = c.x; $('#x1').val(c.x);
        y1 = c.y; $('#y1').val(c.y);
        x2 = c.x2; $('#x2').val(c.x2);
        y2 = c.y2; $('#y2').val(c.y2);
        $('#w').val(c.w);
        $('#h').val(c.h);
        if(c.w > 0 && c.h > 0){
            $('#crop').show();
        }else{
            $('#crop').hide();
        }
    }
});
function release(){
    jcrop_api.release();
    $('#crop').hide();
}
// Обрезка изображение и вывод результата
jQuery(function($){
    $('#crop').click(function(e) {
        var img = $('#target').attr('src');
        $.post('".Yii::app()->createAbsoluteUrl('profile/logo/act')."', {'x1': x1, 'x2': x2, 'y1': y1, 'y2': y2, 'img': img, 'crop': crop}, function(file) {
            location.reload();
        });
    });
});
");
?>


<div class="grid logo_top">
    <div class="col-img-full-logo">
        <?php
            if($linkLogoPicture){

            ?>
                <div class="logoTitle">Главное изображение </div>
                <div class="logoTitleInf">
                    Загрузите картинку которую вы хотите поставить на аватарку.
                    Наведите на картинку и выберете область которая будет отображатся. И нажмите кнопку "ОБРЕЗАТЬ"
                </div>
                <div>
            <?php
                echo CHtml::image($linkLogoPicture,'',array('style'=>'','id'=>'target'));
            }
        ?></div>
    </div>
    <div class="col-img-small-logo">
        <div>
                <?php
                if($linkLogoPictureSmall){
                ?>
                    <div class="logoTitle2">Аватарка</div>
                <?php
                    echo CHtml::image($linkLogoPictureSmall,'',array('style'=>'height: 140px;','id'=>'target'));
                }
                ?>
        </div>
        <!--<div>
            <button id="release">Убрать выделение</button>
        </div>-->
    </div>
    <div class="col-img-form-logo">
    <div style="text-align: right;width: 400px;margin: 10px 0;"><button id="crop" class="b-yellow">ОБРЕЗАТЬ</button></div>
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            'id'=>'file-edit-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                //'validateOnSubmit'=>true,
                //'validateOnChange'=>false,
            ),
            //'enableAjaxValidation'=>true,
        )); ?>

        <div class="row">
            <?php echo $form->fileField($model,'file'); ?>
            <?php echo $form->error($model,'file'); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Сохранить картинку',array('class'=>'button')); ?>
            <?php echo CHtml::submitButton('Удалить картинку',array('class'=>'button','onclick'=>'window.location.assign("'.CController::createUrl('remove').'")')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>

    </div>
</div>



