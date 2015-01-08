<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'artist',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->artist->name),
                         array("artist/view","id" => $data->artist->id))',
        ),
        array(
            'name' => 'album',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->album->name),
                         array("album/view","id" => $data->album->id))',
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->name),
                         array("view","id" => $data->id))',
        ),
        'duration',
        'bitrate',
        'frequency',
        'format',
        'filesize',
    ),
));
?>