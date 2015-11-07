<?php

PfOrder::$lists['ccmp'] = CHtml::listData(CcmpCompany::model()->findAll(), 'ccmp_id', 'ccmp_name');

$this->widget('tlbExcelView', [
    'id' => 'excel-grid',
    'dataProvider' => $model->searchClient(),
    'grid_mode' => 'export', // Same usage as EExcelView v0.33
    //'template'           => "{summary}\n{items}\n{exportbuttons}\n{pager}",
    // 'report_template'      =>  Yii::app()->controller->module->getBasePath().'/templates/report.xlsx'  ,    
    'title' => 'Orders - ' . date('d-m-Y - H-i-s'),
    'creator' => Yii::app()->user->first_name . ' ' . Yii::app()->user->last_name,
    'filename' => 'Orders_ ' . date('Ymd_His'),
    'subject' => mb_convert_encoding('Orders', 'ISO-8859-1', 'UTF-8'),
    'description' => mb_convert_encoding('Orders', 'ISO-8859-1', 'UTF-8'),
    'lastModifiedBy' => Yii::app()->user->first_name . ' ' . Yii::app()->user->last_name,
    'sheetTitle' => 'Orders ' . date('m-d-Y H-i'),
    'keywords' => '',
    'category' => '',
    'landscapeDisplay' => true, // Default: false
    'A4' => true, // Default: false - ie : Letter (PHPExcel default)
    'pageFooterText' => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
    'automaticSum' => false, // Default: false
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
    'columns' => [

        [
            //'header' =>  Yii::t('FuelingModule.crud', 'Date'),
            'name' => 'week_number',
        //'value' => 'CHtml::value($data, \'bfrfBcbd.bcbd_date\')',  
        ],
        [
            'name' => 'number',
        ],
        [
            'name' => 'client_ccmp_id',
            'value' => '$data->clientCcmp?PfOrder::$lists["ccmp"][$data->client_ccmp_id]:""',
        ],
        [
            'name' => 'manufakturer',
            'value' => 'str_replace("<BR/>",", ",$data->manufakturer)',
        ],
        [
            'name' => 'desired_date',
        ],
        [
            'name' => 'groupage',
        ],
        [
            'name' => 'planed_delivery_date',
        ],
        [
            'name' => 'status',
            'value' => '$data->getEnumColumnLabel("status")',
        ],
        [
            'name' => 'loading_meters',
        ],
        [
            'name' => 'm3',
        ],
        [
            'name' => 'notes',
        ],
    ]
]);
