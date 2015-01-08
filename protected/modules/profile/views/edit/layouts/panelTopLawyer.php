<?php $this->beginContent('/layouts/panelLawyer');
    $nameSelected = array(
        'general'=>'',
        'chlogin'=>'',
        'edu'=>'',
        'index'=>'',
        'contact'=>'',
    );

    $nameSelected[strtolower($this->action->id)] = 'active-li';
?>
    <div class="grid panel-top-lawyer">
        <div class="col-top">
            <div class="<?=$nameSelected['general']?>"><?=CHtml::link('Общее',array('edit/general'))?></div>
            <div class="<?=$nameSelected['chlogin']?>"><?=CHtml::link('Логин',array('edit/chlogin'))?></div>
            <div class="<?=$nameSelected['edu']?>"><?=CHtml::link('Образование',array('edit/edu'))?></div>
            <div class="<?=$nameSelected['index']?>"><?=CHtml::link('Аватарка',array('logo/index'))?></div>
            <div class="<?=$nameSelected['contact']?>"><?=CHtml::link('Контакты',array('edit/contact'))?></div>
                <!--<li><?=CHtml::link('Уведомления',array('edit/price'))?></li>-->
        </div>
        <div class="col-content">
            <div class="content_end">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>