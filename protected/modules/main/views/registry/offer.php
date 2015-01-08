<?php
    Yii::app()->clientScript->registerCoreScript('main.login');
?>

<div class="main-god">
    <div class="top-info">
        <div class="h1-info">Вы не знаете как найти клиента через Интернет?</div>
        <div class="h1-info">У Вас есть сайт в Интернете, но он не приносит клиентов?</div>
        <div class="me-info">С Адвокатмаркет Вы можете забыть об этих проблемах.</div>
        <div class="btn-top-info"><?=CHtml::link('ЗАРЕГЕСТРИРОВАТСЯ',array('registry/addLawyer'),array('class'=>'button b-yellow'))?></div>
    </div>
    <div class="laptop-cnt">
        <div class="laptop-img"><?=CHtml::image('/public/assets/main/images/Promo1.png','')?></div>
        <div class="line-img"></div>
    </div>
    <div class="step-cnt grid">
        <div class="col-info left">
            <div class="oo-promo"></div>
            <div class="img-info-pos">
                Шаг 1. Вы регестрируетесь на сайте
            </div>
        </div>
        <div class="col-img">
            <?=CHtml::image('/public/assets/main/images/PromoImg1.png','')?>
        </div>
        <div class="col-img left">
            <?=CHtml::image('/public/assets/main/images/PromoImg2.png','')?>
        </div>
        <div class="col-info right">
            <div class="oo-promo"></div>
            <div class="img-info-pos">
                Шаг 2. Далее вы получаете запросы от клиентов с описанием их проблем
            </div>
        </div>
        <div class="col-info left">
            <div class="oo-promo"></div>
            <div class="img-info-pos">
                Шаг 3. Вы предлагаете приблизительную стоимость проблемы
            </div>
        </div>
        <div class="col-img">
            <?=CHtml::image('/public/assets/main/images/PromoImg3.png','')?>
        </div>
        <div class="col-img left exep">
            <?=CHtml::image('/public/assets/main/images/PromoImg4.png','')?>
        </div>
        <div class="col-info right">
            <div class="oo-promo"></div>
            <div class="img-info-pos">
                Шаг 4. Если клиент решает вас нанать
            </div>
        </div>
        <div class="col-bot-info">
            <div class="oo-promo-bot"></div>
            <div class="h1-info">То Вы оплачиваете стоимость заказа и получаете контакты <br/> клиента, а также возможность общения в чате</div>
        </div>
        <div class="col-bot-promo">
            <?=CHtml::image('/public/assets/main/images/Promo2.png','')?>
        </div>

    </div>
    <div class="bot-info">
        <div class="h1-info">Вы не знаете как найти клиента через Интернет?</div>
        <div class="me-info">Зарегестрируйтесь сейчас и получите 1 запрос бесплатно!</div>
        <div class="btn-top-info"><?=CHtml::link('ЗАРЕГЕСТРИРОВАТСЯ',array('registry/addLawyer'),array('class'=>'button b-yellow'))?></div>
    </div>
</div>
