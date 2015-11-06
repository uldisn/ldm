<?php

Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');

$addButton = $this->widget(
        'bootstrap.widgets.TbButton', [
    'buttonType' => 'Button',
    'type' => 'primary',
    'size' => 'mini',
    'icon' => 'icon-plus',
    'url' => [
        '//ldm/pfOrderItems/create',
        'order_id' => $modelMain->primaryKey,
    ],
    'htmlOptions' => [
        'title' => Yii::t('LdmModule.crud', 'Add new Item'),
        'data-toggle' => 'tooltip',
    ],
        ], true
);

$criteria = new CDbCriteria;
$criteria->compare('order_id', $modelMain->primaryKey);
$orderItems = PfOrderItems::model()->searchClient($criteria)->getData();

$boxTable = $this->renderPartial('_box_table', ['orderItems' => $orderItems], true);
$this->widget('AceBoxTable', array(
    'header_text' => Yii::t('LdmModule.model', 'Order Items'),
    'toolbar' => $addButton,
    //'info_allert' => $info_allert,
    'tableHead' => ['Manufacturer', 'Planed ready date', 'Load meters', 'Cubic meters', 'Notes'],
    'body' => $boxTable,
));
