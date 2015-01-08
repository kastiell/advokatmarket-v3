<?php $this->beginContent('/layouts/panelLawyer'); ?>
<div>
    <div style="display: inline-block;margin-right: 20px;"><?=CHtml::link('Вхідні заявки',array('LTape/T2t'))?></div>
    <!--<div style="display: inline-block;"><?php //echo CHtml::link('Вихідні заявки',array('LTape/T2f'))?></div>-->
</div>
<div>
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
