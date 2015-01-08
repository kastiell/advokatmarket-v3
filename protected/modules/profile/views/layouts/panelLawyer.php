<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerPackage('profile.edit');

    $nameSelected = array(
        'clientGeneral'=>'',
        't1'=>'',
        't2t'=>'',
        't2'=>'',
        't3'=>'',
    );
    $nameSelectedID = array(
        'profile/edit'=>'',
        'profile/logo'=>''
    );
    $nameSelected[strtolower($this->action->id)] = 'active-li';
    $nameSelectedID[strtolower($this->uniqueid)] = 'active-li';
?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="grid panel-lawyer">
        <?php
            if(Yii::app()->user->role == User::DLAWYER){
        ?>
                    <?php
                        $lawyerOptions = LawyerOptions::model()->findByPk(Yii::app()->user->getId());
                        if($lawyerOptions===null){
                            Yii::app()->end();
                        }else
                            if($lawyerOptions->success_profile == 'fill'){
                    ?>
                                <?php $this->widget('application.components.widgets.getflash.GetFlashWidget',
                                    array('params'=>array('style-class'=>'warning-flash',
                                        'text'=>'Если вы доконца заполнили профиль вы можете отправить запрос на активацию '.CHtml::link('Отправить запрос',array('activate'),array('class'=>'a-com')),
                                        'show'=>true))); ?>
                    <?php
                    }else if($lawyerOptions->success_profile == 'init'){
                    ?>
                                <?php $this->widget('application.components.widgets.getflash.GetFlashWidget',
                                    array('params'=>array('style-class'=>'alert-flash','text'=>'Заполните полностью профиль для полного доступа к функциям сайта','show'=>true))); ?>

                    <?php
                            }else if($lawyerOptions->success_profile == 'activate'){
                    ?>
                                <?php $this->widget('application.components.widgets.getflash.GetFlashWidget',
                                    array('params'=>array('style-class'=>'alert-flash',
                                        'text'=>'Вы отправили запрос на активацию профиля подождите пока мы проверим вашы данные '.CHtml::link('Отменить запрос',array('cancelactivate'),array('class'=>'a-com')),
                                        'show'=>true))); ?>
                    <?php
                            }
                    ?>
        <?php
            }
        ?>
        <div class="col-flash">
            <?php $this->widget('application.components.widgets.getflash.GetFlashWidget',array('params'=>array('style-class'=>'success-flash'))); ?>
        </div>
        <div class="col-left">
            <ul>
                <li class="<?=$nameSelected['t1']?>"><?=CHtml::link('Лента запросов',array('LTape/T1'))?></li>
                <li class="<?=$nameSelected['t2t']?>"><?=CHtml::link('Прямые запросы',array('LTape/T2t'))?></li>
                <li class="<?=$nameSelected['t3']?>"><?=CHtml::link('Сообщения',array('LTape/T3'))?></li>
                <li class="<?=$nameSelectedID['profile/edit'].' '.$nameSelectedID['profile/logo']?>"><?=CHtml::link('Редактировать профиль',array('edit/general'))?></li>
                <!--<li><?=CHtml::link('Мой счет',array('#'))?></li>
                <li><?=CHtml::link('Мой рейтинг',array('#'))?></li>-->
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