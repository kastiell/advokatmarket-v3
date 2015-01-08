<?php
//Добавление ресурсов (модулей)
//http://appossum.com/appsite/techdetail/yii-resources
/*
 * Использовать:
 * //Если нужно зарание подключить jquery
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('magicsuggest');
 *
 * Here is the list of available core scripts:
    jquery
    jquery.ui
    yii
    yiitab
    yiiactiveform
    bgiframe
    ajaxqueue
    autocomplete
    maskedinput //http://i-leon.ru/udobnoe-pole-input-dlya-telefona/
    cookie
    treeview
    multifile
    rating
    metadata
    bbq
    history
    punycode

    Подключение с помощю Yii::app()->clientScript->registerCoreScript('jquery');
 *
*/

return array(
    //Подключение модулей
    'magicsuggest' => array(
        'baseUrl'=>'public/module/magicsuggest',
        'js'=>array('magicsuggest-1.3.1.js'),
        'css'=>array('magicsuggest-1.3.1.css'),
    ),
    'jquery-ui' => array(
        'baseUrl'=>'public/module/jquery-ui',
        'js'=>array('jquery-ui.js'),
        'css'=>array('jquery-ui.css'),
    ),
    'maskedinput' => array(
        'baseUrl'=>'public/module/maskedinput',
        'js'=>array('jquery.maskedinput.min.js'),
    ),
    'jcrop' => array(
        'baseUrl'=>'public/module/jcrop',
        'js'=>array('js/jquery.Jcrop.min.js'),
        'css'=>array('css/jquery.Jcrop.css'),
    ),
    'simplemodal' => array(
        'baseUrl'=>'public/module/simplemodal',
        'js'=>array('js/jquery.simplemodal.js'),
        'css'=>array('css/simple.css'),
    ),
    'ask' => array(
        'baseUrl'=>'public/module/ask',
        'js'=>array('js/ask.js'),
        'css'=>array('css/style.css'),
    ),
    'strophe' => array(
        'baseUrl'=>'public/module/strophe',
        'js'=>array('js/strophe.js','js/strophe.muc.js','js/strophe.roster.js'),
    ),
    'jquery-xmpp' => array(
        'baseUrl'=>'public/module/xamppjquery',
        'js'=>array('js/xampp.js'),
    ),
    'jgrow' => array(
        'baseUrl'=>'public/module/jgrow',
        'js'=>array('js/jgrow.js'),
    ),


    /*
     * Подключение ресурсов к модуля/контроллера
     * Нотация названия пакета module.controller.action
    */
    'profile.edit' => array(
        'baseUrl'=>'public/assets/profile',
        //'js'=>array('js/myXMPP.js'),
        'css'=>array('css/file.css','css/tape.css','css/description.css'),
    ),
    'profile.msg' => array(
        'baseUrl'=>'public/assets/profile',
        //'js'=>array('js/myXMPP.js'),
        'css'=>array('css/msg.css'),
    ),
    'main.catalog' => array(
        'baseUrl'=>'public/assets/main',
        'css'=>array('css/catalog.css'),
    ),
    'main.profile' => array(
        'baseUrl'=>'public/assets/main',
        'css'=>array('css/profile.css'),
    ),
    'main.index' => array(
        'baseUrl'=>'public/assets/main',
        'css'=>array('css/index.css'),
    ),
    'main.login' => array(
        'baseUrl'=>'public/assets/main',
        'css'=>array('css/login.css'),
    ),
    'admin.index' => array(
        'baseUrl'=>'public/assets/admin',
        'css'=>array('css/index.css'),
    ),

);