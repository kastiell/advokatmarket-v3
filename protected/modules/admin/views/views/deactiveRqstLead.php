<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'lead_client.name',
        array(
            'name' => 'time_make',
            'value' => 'date("d.m.Y h:s",$data->time_make)',
        ),
        array(
            'name' => 'Имя юриста',
            'value' => '(Lawyer::model()->findByPk($data->lead_request->id_lawyer)->name)',
        ),
        array(
            'name' => 'Прізвище юриста',
            'value' => '(Lawyer::model()->findByPk($data->lead_request->id_lawyer)->first_name)',
        ),
        array(
            'name' => 'Ціна ліда',
            'value' => '$data->cost_lead',
        ),
        array(
            'name' => 'Ціна послуги',
            'value' => '$data->lead_request->cost_service',
        ),
        array(
            'name' => 'Имя юриста',
            'value' => '(Lawyer::model()->findByPk($data->lead_request->id_lawyer)->phone)',
        ),
        array(
            'name' => 'ID ліда',
            'value' => '$data->id_request_lead',
        ),
        array(
            'name' => 'Деактивувати',
            'type'=>'html',
            'value' => 'CHtml::link("Деактивувати лід",array("/admin/control/DeactivateLead","id_lead"=>$data->id))',
        ),
    ),
));
?>