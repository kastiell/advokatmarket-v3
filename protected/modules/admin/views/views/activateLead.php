<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'lead_client.name',
        'lead_client.city',
        array(
            'name' => 'time_make',
            'value' => 'date("d.m.Y h:s",$data->time_make)',
        ),
        'id_request_lead',
        array(
            'name' => 'Активувати лід',
            'type'=>'html',
            'value' => 'CHtml::link("Активувати лід",array("/admin/control/OpenLead","id_lead"=>$data->id))',
        ),
    ),
));
?>