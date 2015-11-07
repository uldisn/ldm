<?php

$title = 'Order ' . $model->number;

/**
 * all company list
 */
$criteria = new CDBCriteria();
$criteria->order = 't.ccmp_name';
pfOrder::$lists['ccmp'] = CHtml::listData(CcmpCompany::model()->findAll($criteria), 'ccmp_id', 'ccmp_name');
unset($criteria);

/**
 * person list for 
 */
pfOrder::$lists['pprs'] = CHtml::listData(PprsPerson::model()->findAll(), 'pprs_id', 'itemLabel');

/**
 * order items list
 */
$criteria = new CDbCriteria;
$criteria->compare('order_id', $model->primaryKey);
$orderItems = PfOrderItems::model()->searchClient($criteria)->getData();
unset($criteria);

$tableRows = [];

/**
 * for notes filter
 */
$userPersonId = Yii::app()->getModule('user')->user()->profile->person_id;

$header = [
    'manufakturer_ccmp_id' => 'Manufacturer',
    'planed_ready_date' => 'Planed ready date',
    'load_meters' => 'Load meters',
    'm3' => 'Cubic meters',
    'notes' => 'Notes'];
foreach ($orderItems as $oi) {
    $tableRows[] = [
        'manufakturer_ccmp_id' => pfOrder::$lists['ccmp'][$oi->manufakturer_ccmp_id],
        'planed_ready_date' => $oi->planed_ready_date,
        'load_meters' => $oi->load_meters,
        'm3' => $oi->m3,
        'notes' => $oi->notes,
    ];
    $notesCriteria = new CDbCriteria();
    $notesCriteria->condition = "t.from_pprs_id = " . $userPersonId . " OR t.to_pprs_id=" . $userPersonId;
    $notesCriteria->compare('t.order_item_id', $oi->primaryKey);
    $notes = PfOrderItemNotes::model()->findAll($notesCriteria);
    $noteRows = [];
    foreach ($notes as $note) {
        $noteRows[] = [
            'created' => $note->created,
            'from_pprs_id' => pfOrder::$lists['pprs'][$note->from_pprs_id],
            'to_pprs_id' => pfOrder::$lists['pprs'][$note->to_pprs_id],
            'message' => $note->message,
            'readed' => $note->readed,
        ];
    }
    $tableRows[] = [
        'manufakturer_ccmp_id' => null,
        'planed_ready_date' => [
            'type' => tlbExcel::DATA_TYPE_TABLE,
            'header' => [
                'created' => 'Created',
                'from_pprs_id' => 'From',
                'to_pprs_id' => 'To',
                'message' => 'Message',
                'readed' => 'Readed',
            ],
            'rows' => $noteRows,
        ],
    ];
}

$this->widget('tlbExcel', [
    'id' => 'excel-grid',
    'title' => $title,
    'creator' => Yii::app()->user->first_name . ' ' . Yii::app()->user->last_name,
    'filename' => 'Orders_ ' . $model->number . '_' . date('Ymd_His'),
    'subject' => mb_convert_encoding($title, 'ISO-8859-1', 'UTF-8'),
    'lastModifiedBy' => Yii::app()->user->first_name . ' ' . Yii::app()->user->last_name,
    'sheetTitle' => $title,
    'keywords' => '',
    'category' => '',
    'landscapeDisplay' => true, // Default: false
    'A4' => true, // Default: false - ie : Letter (PHPExcel default)
    'pageFooterText' => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
    'decimalSeparator' => '.', // Default: '.'
    'thousandsSeparator' => '', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    //'sumLabel' => Yii::t('dbr_app', 'Total') . ' :', // Default: 'Totals'
    'borderColor' => '000000', // Default: '000000'
    'bgColor' => 'FFFFFF', // Default: 'FFFFFF'
    'textColor' => '000000', // Default: '000000'
    'rowHeight' => 20, // Default: 15
    'headerBorderColor' => '000000', // Default: '000000'
    'headerBgColor' => 'FFFF00', // Default: 'CCCCCC'
    'headerTextColor' => '0000FF', // Default: '000000'
    'headerHeight' => 30, // Default: 20
    'footerBorderColor' => '000000', // Default: '000000'
    'footerBgColor' => 'FFFF00', // Default: 'FFFFCC'
    'footerTextColor' => '000000', // Default: '0000FF'
    'footerHeight' => 30, // Default: 20
    'zoomScale' => 100, // Default: 100
    //'sumColumns' => [6, 7, 8],
    'caption' => '',
    //'offset'      => 9,    
    'data' => [
        [
            'type' => tlbExcel::DATA_TYPE_CAPTION,
            'x' => 1,
            'y' => 1,
            'width' => 9,
            'caption' => $title,
        ],
        [
            'type' => tlbExcel::DATA_TYPE_VIEW_MODEL,
            'x' => 1,
            'y' => 3,
            'model' => $model,
            'attributes' => [
                [
                    'name' => 'number',
                ],
                [
                    'name' => 'client_ccmp_id',
                ],
                [
                    'name' => 'order_date',
                ],
                [
                    'name' => 'desired_date',
                ],
                [
                    'name' => 'planed_delivery_type',
                    'value' => $model->clientCcmp ? $model->clientCcmp->ccmp_name : '',
                ],
                [
                    'name' => 'groupage',
                ],
                [
                    'name' => 'loading_meters',
                ],
                [
                    'name' => 'm3',
                ],
                [
                    'name' => 'planed_dispatch_date',
                ],
                [
                    'name' => 'planed_delivery_date',
                ],
                [
                    'name' => 'status',
                    'value' => $model->getEnumColumnLabel('status'),
                ],
                [
                    'name' => 'loading_meters',
                ],
                [
                    'name' => 'notes',
                ],
            ],
        ],
        [
            'type' => tlbExcel::DATA_TYPE_TABLE,
            'x' => 3,
            'y' => 3,
            'header' => $header,
            'rows' => $tableRows,
        ],
    ],
]);
