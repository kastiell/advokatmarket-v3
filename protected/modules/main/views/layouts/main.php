<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/assets/main/css/common.css" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/form.css" />-->
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="main_god">
    <div id="header">
        <div id="top-header-block">
            <div id="top-header-content">
                <div class="grid maxwidth">
                    <div class="col-i-header-left">
                        <div class="grid maxwidth">
                            <div class="col-i-ua selected-local">
                                <div>
                                    <span>УКР</span>
                                </div>
                            </div>
                            <div class="col-i-ru">
                                <div>
                                    <span>РУС</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-i-header-right">
                        <div class="grid maxwidth">
                            <?php
                                if(Yii::app()->user->isGuest){
                            ?>
                                    <div class="rcol-i-login">
                                        <div>
                                            <span><a href="<?=CController::createUrl('/main/registry/addClient')?>" class="inherit-a">РЕГИСТРАЦИЯ</a></span> / <span><a href="<?=CController::createUrl('/main/registry/login')?>"  class="inherit-a">ВХОД</a></span>
                                        </div>
                                    </div>
                                    <div class="rcol-i-lawyer">
                                        <div>
                                            <span><a href="<?=CController::createUrl('/main/registry/offer')?>" class="inherit-a">РЕГИСТРАЦИЯ ЮРИСТА</a></span>
                                        </div>
                                    </div>
                            <?php
                                }else{
                            ?>
                                    <div class="rcol-i-login">
                                        <div>
                                            <span><a href="<?=CController::createUrl('/main/registry/logout')?>" class="inherit-a">Выйти (<?=Yii::app()->user->name?>)</a></span>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <div class="rcol-i-phone">
                                <div>
                                    <span>ТЕЛ: +38(044)123-45-67</span>
                                </div>
                            </div>
                            <div class="rcol-i-iphone">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="top-header-logo">
            <div id="logo-block-header">
                <div class="grid maxwidth">
                    <div class="col-logo-left">
                        <div id="logo-i">
                            <a href="<?=CController::createUrl('/')?>" class="inherit-a"><img src="public/assets/main/images/logoAD.png" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-logo-right">
                        <div id="but-index">
                            <?php
                                $nameSelected[strtolower($this->uniqueid)] = 'selected';
                            ?>
                            <div class="grid but-logo-b">
                                <?php
                                    /*if(!Yii::app()->user->checkAccess('open_panel_lawyer')){
                                ?>
                                        <div class="col-i-but <?=$nameSelected['main/index']?>"><a href="<?=CController::createUrl('/')?>" class="inherit-a">НАЙТИ ЮРИСТА</a></div>
                                <?php
                                    }
                                ?>
                                        <div class="col-i-but <?=$nameSelected['main/catalog']?>"><a href="<?=CController::createUrl('/main/catalog/index')?>" class="inherit-a">КАТАЛОГ ЮРИСТОВ</a></div>
                                <?php
                                    if(Yii::app()->user->getRole() == User::CLIENT){
                                ?>
                                        <div class="col-i-but <?=strpos(strtolower($this->uniqueid),'profile')!==false?'selected':''?>"><a href="<?=CController::createUrl('/profile/CTape/T1')?>" class="inherit-a">МОЯ СТОРІНКА</a></div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if(Yii::app()->user->checkAccess('open_panel_lawyer')){
                                ?>
                                        <div class="col-i-but <?=strpos(strtolower($this->uniqueid),'profile')!==false?'selected':''?>"><a href="<?=CController::createUrl('/profile/LTape/T1')?>" class="inherit-a">МОЯ СТОРІНКА</a></div>
                                <?php
                                    }*/
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content_block_main">
        <?php echo $content; ?>
    </div>
    <div id="footer">
        <div class="grid maxwidth">
            <div class="col-info-i-foo">
                2014 © Все права защищены <?=$this->uniqueid?>
            </div>
            <div class="col-img-i-foo">
            </div>
            <div class="col-social-i-foo">
                <div class="foo-social-v"></div>
                <div class="foo-social-o"></div>
                <div class="foo-social-f"></div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header - ->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/main/index/index')),
				//array('label'=>'Найти юриста', 'url'=>array('/main/site/page', 'view'=>'about')),
				//array('label'=>'Понять юридический вопрос', 'url'=>array('/main/site/contact')),

                array('label'=>'Каталог юристов', 'url'=>array('/main/catalog/index')),


                array('label'=>'Страница Клиента', 'url'=>array('/profile/edit/clientGeneral'), 'visible'=>Yii::app()->user->role == 'client'),
                array('label'=>'Страница Юриста', 'url'=>array('/profile/edit/general'), 'visible'=>Yii::app()->user->checkAccess('open_panel_lawyer')),

                array('label'=>'Регистрация Клиента', 'url'=>array('/main/registry/addClient'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Регистрация Юриста', 'url'=>array('/main/registry/offer'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Вход', 'url'=>array('/main/registry/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Адмінка', 'url'=>array('/admin/views/users'), 'visible'=>Yii::app()->user->checkAccess('open_panel_admin')),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/main/registry/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>< !-- breadcrumbs - ->
	<?php endif?>


	<div class="clear"></div>

</div><!-- page -->

</body>
</html>
