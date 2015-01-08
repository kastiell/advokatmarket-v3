<?php
/*
 * Файлик с описанием ролей и операций
 * Роль может наследовать т.е быть потомком
 * или операции или другой роли
 */


return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'guest',
        'bizRule' => null,
        'data' => null
    ),
    'client' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'client',
        'children' => array(
            'guest',          // позволим клиенту всё, что позволено гостю
        ),
        'bizRule' => null,
        'data' => null
    ),
    'dactv_lawyer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'lawyer',
        'children' => array(
            'guest',          // позволим юристу всё, что позволено гостю
            'open_panel_lawyer', //Потомок операции т.е есть права исполнять данную операцию
            'close_index_page_for_lawyer',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'lawyer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'lawyer',
        'children' => array(
            'dactv_lawyer',          // позволим юристу всё, что позволено гостю
        ),
        'bizRule' => null,
        'data' => null
    ),
    'dactv_company' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'lawyer',
        'children' => array(
            'guest',          // позволим юристу всё, что позволено гостю
        ),
        'bizRule' => null,
        'data' => null
    ),
    'company' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'lawyer',
        'children' => array(
            'dactv_company',          // позволим юристу всё, что позволено гостю
        ),
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'administrator',
        'children' => array(
            'moderator',         // позволим админу всё, что позволено модератору
            'open_panel_admin',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'administrator',
        'children' => array(
            'guest',         // позволим админу всё, что позволено модератору
        ),
        'bizRule' => null,
        'data' => null
    ),

    //ОПЕРАЦИИ
    'open_panel_lawyer' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Открыть панель (Страница юриста) для юриста',
        /*'children' => array(
            'dactv_lawyer',
        ),*/
        'bizRule' => null,
        'data' => null
    ),
    'open_panel_admin' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Открыть панель (Адмінка) для адміна',
        /*'children' => array(
            'dactv_lawyer',
        ),*/
        'bizRule' => null,
        'data' => null
    ),
    'close_index_page_for_lawyer' =>array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редирект юриста з головної сторінки на мою сторінку',
        'bizRule' => null,
        'data' => null
    )
);