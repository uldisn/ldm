<?php
Yii::app()->clientScript->registerCss('table_css', "

.delivered {
  background: #bbbbbb !important;
}

");

$this->setPageTitle(Yii::t('LdmModule.model', 'Orders'));

Yii::app()->clientScript->registerScript('filter_init', '
function filter_pf_order_init(){
    filter_PfOrder_order_date_range_init();
    filter_PfOrder_desired_date_range_init();
//    filter_PfOrder_planed_dispatch_date_range_init();
//    filter_PfOrder_planed_delivery_date_range_init();
}
');
?>


<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <?php
            $this->widget('bootstrap.widgets.TbButton', [
                'label' => Yii::t('LdmModule.crud', 'Create'),
                'icon' => 'icon-plus',
                'size' => 'large',
                'type' => 'success',
                'url' => ['create'],
                'visible' => (Yii::app()->user->checkAccess('Ldm.PfOrder.*') || Yii::app()->user->checkAccess('Ldm.PfOrder.Create'))
            ]);
            ?>
        </div>
        <div class="btn-group">
            <h1>
                <i class="icon-file-text-alt"></i>
                <?php echo Yii::t('LdmModule.model', 'Orders'); ?>            
            </h1>
        </div>
        <div class="btn-group">
            <?php echo CHtml::link('<img src="images/excel48.png">', array('adminExcel', 'lang' => Yii::app()->language)); ?>   
        </div>        
    </div>
</div>

<?php
$ccuc = CcucUserCompany::model()->getPersonCompnies(
        Yii::app()->getModule('user')->user()->profile->person_id, CcucUserCompany::CCUC_STATUS_PERSON);



$criteria = new CDBCriteria();
$criteria->order = 't.ccmp_name';
pfOrder::$lists['ccmp'] = CHtml::listData(CcmpCompany::model()->findAll($criteria), 'ccmp_id', 'ccmp_name');
$criteria = new CDBCriteria();
$criteria->order = 't.name';
$filterType = CHtml::listData(PfDeliveryType::model()->findAll($criteria), 'id', 'name');

Yii::beginProfile('PfOrder.view.grid');
$this->widget('TbGridView', [
    'id' => 'pf-order-grid',
    'dataProvider' => $model->searchClient(),
    'filter' => $model,
    #'responsiveTable' => true,
    'template' => '{items}{pager}',
    'afterAjaxUpdate' => 'filter_pf_order_init',
    'rowCssClassExpression' => '

        ( $data->status==PfOrder::STATUS_DELIVERED ? " delivered": null )
    ',
    'pager' => [
        'class' => 'TbPager',
        'displayFirstAndLast' => true,
    ],
    'columns' => [
        [
            'name' => 'week_number',
        ],
        [
            //varchar(20)
            'name' => 'number',
        ],
        [
            'name' => 'client_ccmp_id',
            'value' => '$data->clientCcmp?PfOrder::$lists["ccmp"][$data->client_ccmp_id]:""',
            'filter' => PfOrder::$lists['ccmp'],
        ],
        [
            'name' => 'manufakturer',
            'type' => 'raw',
            'visible' => Yii::app()->user->checkAccess('OrdersAdmin'),
        ],
        [
            'name' => 'order_date',
            'filter' => $this->widget('vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', [
                'model' => $model,
                'attribute' => 'order_date_range',
                'options' => [
                    'ranges' => ['today', 'yesterday', 'this_week', 'last_week', 'this_month', 'last_month', 'this_year'],
                ]
                    ], TRUE),
        ],
        [
            'name' => 'desired_date',
            'filter' => $this->widget('vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', [
                'model' => $model,
                'attribute' => 'desired_date_range',
                'options' => [
                    'ranges' => ['today', 'yesterday', 'this_week', 'last_week', 'this_month', 'last_month', 'this_year'],
                ]
                    ], TRUE),
        ],
//        [
//            'name' => 'planed_delivery_type',
//            'value' => '$data->planedDeliveryType?$data->planedDeliveryType->name:""',
//            'filter' => $filterType,
//        ],
        [
            'name' => 'groupage',
        ],
//        [
//            'name' => 'planed_dispatch_date',
//            'filter' => $this->widget('vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', [
//                'model' => $model,
//                'attribute' => 'planed_dispatch_date_range',
//                'options' => [
//                    'ranges' => ['today', 'yesterday', 'this_week', 'last_week', 'this_month', 'last_month', 'this_year'],
//                ]
//                    ], TRUE),
//        ],
        [
            'name' => 'planed_delivery_date',
            'filter' => $this->widget('vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', [
                'model' => $model,
                'attribute' => 'planed_delivery_date_range',
                'options' => [
                    'ranges' => ['today', 'yesterday', 'this_week', 'last_week', 'this_month', 'last_month', 'this_year'],
                ]
                    ], TRUE),
        ],
        [

            'name' => 'status',
            'value' => '$data->getEnumColumnLabel("status")',
            'filter' => $model->getEnumFieldLabels('status'),
        ],
        [
            'name' => 'loading_meters',
            'value' => "\$data->loading_meters>\$data->max_load_meters?'<span class=\"label label-important\">'.\$data->loading_meters.'</span>':\$data->loading_meters",
            'type' => 'raw',
            'htmlOptions' => [
                'class' => 'numeric-column',
            ],
        ],
        [
            'name' => 'm3',
            'value' => "\$data->m3>\$data->max_cubic_meters?'<span class=\"label label-important\">'.\$data->m3.'</span>':\$data->m3",
            'type' => 'raw',
            'htmlOptions' => [
                'class' => 'numeric-column',
            ],
        ],
        [
            'name' => 'notes',
        ],
        [
            'name' => 'new_notes',
            'type' => 'raw',
            'value' => '$data->new_notes > 0 ?
                \'
                <a href="#"> 
                    <i class="icon-envelope icon-primary"></i>
                    <span class="badge badge-warning">\' . $data->new_notes . \'</span>
                </a>
                \'
                :
                \'\'
                ',
             'filter'=>false,
        ],
        [
            'class' => 'TbButtonColumn',
            'buttons' => [
                'view' => ['visible' => 'Yii::app()->user->checkAccess("Ldm.PfOrder.View")'],
                'update' => ['visible' => 'FALSE'],
                'delete' => ['visible' => 'FALSE'],
            ],
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
            'viewButtonIcon' => 'icon-edit',
            'deleteConfirmation' => Yii::t('LdmModule.crud', 'Do you want to delete this item?'),
            'viewButtonOptions' => [
                'data-toggle' => 'tooltip',
                'title' => Yii::t("LdmModule.crud", "View & Edit"),
            ],
        ],
    ]
        ]
);

Yii::endProfile('PfOrder.view.grid');
