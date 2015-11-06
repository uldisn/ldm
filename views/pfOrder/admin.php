<?php
//Yii::app()->clientScript->registerCss('hide_for_print', "
//   
//@media print {
//	.btn {
//		display: none !important;
//	}
//
//	#navbar {
//		display: none !important;
//	}
//
//	#sidebar {
//		display: none !important;
//	}
//
//
//	.button-column {
//		display: none !important;
//	}
//    
//	.main-content{
//		margin-left: 0px !important;
//	}
//    
//    .editable-click, a.editable-click {
//        border-bottom: none !important;
//    }
//    
//    #pf-order-grid tr.filters{
//		display: none !important;
//	}
//    
//    div.pagination{
//		display: none !important;
//	}
//
//    a[href]:after{content:none} 
//}
//");
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
    filter_PfOrder_planed_dispatch_date_range_init();
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
    </div>
</div>

<?php
$ccuc = CcucUserCompany::model()->getPersonCompnies(
        Yii::app()->getModule('user')->user()->profile->person_id, CcucUserCompany::CCUC_STATUS_PERSON);

$criteria = new CDBCriteria();
$criteria->order = 't.ccmp_name';


$filterCcmp = CHtml::listData(CcmpCompany::model()->findAll($criteria), 'ccmp_id', 'ccmp_name');

$criteria = new CDBCriteria();
$criteria->order = 't.name';
$filterType = CHtml::listData(PfDeliveryType::model()->findAll($criteria), 'id', 'name');
//PfOrder::STATUS_DELIVERED
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
            'value' => '$data->clientCcmp?$data->clientCcmp->ccmp_name:""',
            'filter' => $filterCcmp,
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
            'name' => 'groupage'
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
        ],
        [
            'name' => 'm3',
            'value' => "\$data->m3>\$data->max_cubic_meters?'<span class=\"label label-important\">'.\$data->m3.'</span>':\$data->m3",
            'type' => 'raw',
        ],
        [
//            'class' => 'editable.EditableColumn',
            'name' => 'notes',
//            'editable' => [
//                'type' => 'textarea',
//                'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
//            //'placement' => 'right',
//            ]
        ],
        [
            'class' => 'TbButtonColumn',
            'buttons' => [
                'view' => ['visible' => 'Yii::app()->user->checkAccess("Ldm.PfOrder.View")'],
                'update' => ['visible' => 'FALSE'],
                'delete' => ['visible' => 'FALSE'],
            ],
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
            //'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
            'deleteConfirmation' => Yii::t('LdmModule.crud', 'Do you want to delete this item?'),
            'viewButtonOptions' => ['data-toggle' => 'tooltip'],
        //'deleteButtonOptions' => ['data-toggle' => 'tooltip'],
        ],
    ]
        ]
);

Yii::endProfile('PfOrder.view.grid');
