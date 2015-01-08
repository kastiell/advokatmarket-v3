<?php
if(Yii::app()->user->hasFlash($params['flash-name'])||$params['show']){
    ?>
    <div class="<?=$params['style-class']?> edit-flash-block">
        <div class="flash-block">
            <div class="grid">
                <div class="col-fl-text"><span><?php
                    if($params['text'] == null){
                        echo Yii::app()->user->getFlash('edit-status');
                    }else{
                        echo $params['text'];
                    }
                    ?></span></div>
                <div class="col-fl-close"><?=CHtml::link('×','javascript:void(0)',array('onclick'=>'$(this).parents(".edit-flash-block").fadeOut("slow");'))?></div>
            </div>
        </div>
    </div>
<?php
}
?>