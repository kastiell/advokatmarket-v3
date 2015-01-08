<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'lawyer.login',
        'lawyer.role',
        'success_profile',
        array(
            'name' => 'Активувати',
            'type'=>'html',
            'value' => 'CHtml::link("Активувати",array("/admin/control/ActivateLawyer","id_lawyer"=>$data->id))',
        ),
    ),
));
?>