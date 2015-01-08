<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerPackage('profile.edit');

    $nameSelected = array(
        'clientGeneral'=>'',
        't1'=>'',
        't2'=>'',
        't3'=>'',
    );
    $nameSelectedID = array(
        'profile/edit'=>'',
    );
    $nameSelected[strtolower($this->action->id)] = 'active-li';
    $nameSelectedID[strtolower($this->uniqueid)] = 'active-li';

?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="grid panel-client">
        <div class="col-left">
            <ul>
                <li class="<?=$nameSelected['t1']?> "><?=CHtml::link('Мои вопросы',array('CTape/t1'))?></li>
                <li class="<?=$nameSelected['t2']?>"><?=CHtml::link('Мои предложения',array('CTape/t2'))?></li>
                <li class="<?=$nameSelected['t3']?>"><?=CHtml::link('Сообщения',array('CTape/t3'))?></li>
                <li class="<?=$nameSelectedID['profile/edit']?>"><?=CHtml::link('Редактировать профиль',array('edit/clientGeneral'))?></li>
            </ul>
        </div>
        <div class="col-right">
            <div class="content">
                <div class="col-flash">
                    <?php $this->widget('application.components.widgets.getflash.GetFlashWidget'); ?>
                </div>
                <div class="col-aaa maxwidth">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>