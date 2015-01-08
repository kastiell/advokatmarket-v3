<?php $this->beginContent('/layouts/panelClient');

    $nameSelected = array(
        'clientGeneral'=>'',
        'clientchlogin'=>'',
    );
    $nameSelected[strtolower($this->action->id)] = 'active-li';

?>
    <div class="grid panel-top-client">
        <div class="col-flash">
            <?php $this->widget('application.components.widgets.getflash.GetFlashWidget'); ?>
        </div>
        <div class="col-top">
                <div class="<?=$nameSelected['clientgeneral']?>"><?=CHtml::link('Общая информация',array('edit/clientGeneral'))?></div>
                <div class="<?=$nameSelected['clientchlogin']?>"><?=CHtml::link('Информация логина',array('edit/clientchlogin'))?></div>
                <!--<li><?=CHtml::link('Уведомления',array('edit/price'))?></li>-->
        </div>
        <div class="col-content">
            <div class="content_end">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>