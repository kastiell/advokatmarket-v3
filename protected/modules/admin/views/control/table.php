<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => '$data->id',
        ),
        'login',
        'password',
        array(
            'name' => 'ts_reg',
            'value' => 'date("d.m.Y h:s",$data->ts_reg)',
        ),
        'last_login',
        'role',
        'activate_link',
    ),
));
?>