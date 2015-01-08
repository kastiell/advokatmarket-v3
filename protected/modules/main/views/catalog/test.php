<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('yiiactiveform');
    //Yii::app()->clientScript->registerPackage('myyiiactiveform');
    Yii::app()->clientScript->registerPackage('jquery-ui');
?>

<script>
    $(function(){

        window.FORM = {};
        window.FORM.DATA = [];

        FORM.serialazeForm = function(count_call){
            window.FORM.DATA[count_call] = $(FORM.nameForm[count_call]).serialize();
        }

        FORM.callStep = function(c,data){
            console.log('1',c,data);
            FORM.calls(FORM.callStep.callObj[c],c);
        }

        FORM.calls = function(o,count_call){
            console.log('2',o);
            if(o != undefined){
                $.each(o,function(c,v){
                    console.log('3');
                    v(count_call);
                });
            }
        }

        window.FORM.nameForm = [null,'#test-1-main-form','#test-2-main-form'];
        window.FORM.callStep.callObj = [null,
            [
                function(c){
                    FORM.serialazeForm(c);
                    console.log('sad');
                    $('.form1').css('display','none');
                    $('.form2').css('display','block');
                }
            ],
            [
                function(c){
                    FORM.serialazeForm(c);
                    console.log('form2',window.FORM.DATA);
                }
            ]
        ];


    });
</script>

<div class="form1" style="display: block;">
<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>array('/main/catalog/test'),
    'id'=>'test-1-main-form',
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnChange'=>false,
        'validateOnSubmit'=>true,
        'afterValidate'=>'js:function(form,data,hasError){if(!hasError){window.FORM.callStep(1,data);}}'
    ),
    'enableAjaxValidation'=>true,
));
?>
    1
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="row field-on-logout">
        <?php echo $form->labelEx($model,'test'); ?>
        <?php echo $form->textField($model,'test'); ?>
        <?php echo $form->error($model,'test'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить')?>
    </div>
<?php $this->endWidget(); ?>
</div>

<div class="form2" style="display: none;">
<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>array('/main/catalog/test'),
    'id'=>'test-2-main-form',
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnChange'=>false,
        'validateOnSubmit'=>true,
        'afterValidate'=>'js:function(form,data,hasError){if(!hasError){window.FORM.callStep(2);}}'
    ),
    'enableAjaxValidation'=>true,
));
?>
    2
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="row field-on-logout">
        <?php echo $form->labelEx($model,'test'); ?>
        <?php echo $form->textField($model,'test'); ?>
        <?php echo $form->error($model,'test'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить')?>
    </div>
<?php $this->endWidget(); ?>
</div>