<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('admin.index');
?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="grid">
        <div class="col-left">
            <ul>
                <li><?=CHtml::link('Користувачі',array('/admin/views/users'))?></li>
                <li><?=CHtml::link('Активувати',array('/admin/views/activate'))?></li>
                <li><?=CHtml::link('Активувати Лід',array('/admin/views/activateLead'))?></li>
                <li><?=CHtml::link('Деактивувати заявку юриста',array('/admin/views/deactiveRqstLead'))?></li>
            </ul>
        </div>
        <div class="col-right">
            <div class="content">
                <div class="col-flash">
                    <?php $this->widget('application.components.widgets.getflash.GetFlashWidget'); ?>
                </div>
                <?php echo $content; ?>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>