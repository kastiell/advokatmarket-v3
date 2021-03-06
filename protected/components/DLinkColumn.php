<?php
/**
* @author ElisDN <mail@elisdn.ru>
* @link http://www.elisdn.ru
*/

Yii::import('zii.widgets.grid.CDataColumn');

class DLinkColumn extends CDataColumn
{
public $link;

protected function renderDataCellContent($row, $data)
{
$url = $this->getItemUrl($row, $data);
$value = $this->getItemValue($row, $data);
$text = $this->grid->getFormatter()->format($value, $this->type);
echo $value === null ? $this->grid->nullDisplay : CHtml::link($text, $url);
}

protected function getItemValue($row, $data)
{
if (!empty($this->value))
return $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
elseif (!empty($this->name))
return CHtml::value($data, $this->name);
return null;
}

protected function getItemUrl($row, $data)
{
if (!empty($this->link))
return $this->evaluateExpression($this->link, array('data' => $data, 'row' => $row));
elseif ($this->link !== false)
return Yii::app()->controller->createUrl('update', array('id' => $data->getPrimaryKey()));
return '';
}
}