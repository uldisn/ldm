<?php
if(!$ajax){
    Yii::app()->clientScript->registerCss('rel_grid',' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');     
}

if(!$ajax || $ajax == 'pf-order-items-grid'){
    Yii::beginProfile('order_id.view.grid');
        
    $grid_error = '';
    $grid_warning = '';
    
    if (empty($modelMain->pfOrderItems)) {
        $model = new PfOrderItems;
        $model->order_id = $modelMain->primaryKey;
        if(!$model->save()){
            $grid_error .= implode('<br/>',$model->errors);
        }
        unset($model);
    }     
?>

<div class="table-header">
    <?=Yii::t('LdmModule.model', 'Order Items')?>
    <?php    
        
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'ajaxButton', 
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini',
            'icon' => 'icon-plus',
            'url' => [
                '//ldm/pfOrderItems/ajaxCreate',
                'field' => 'order_id',
                'value' => $modelMain->primaryKey,
                'ajax' => 'pf-order-items-grid',
            ],
            'ajaxOptions' => [
                    'success' => 'function(html) {$.fn.yiiGridView.update(\'pf-order-items-grid\');}'
                    ],
            'htmlOptions' => [
                'title' => Yii::t('LdmModule.crud', 'Add new record'),
                'data-toggle' => 'tooltip',
            ],                 
        ]
    );        
    ?>
</div>
 
<?php 

    if(!empty($grid_error)){
        ?>
        <div class="alert alert-error"><?php echo $grid_error?></div>
        <?php
    }  

    if(!empty($grid_warning)){
        ?>
        <div class="alert alert-warning"><?php echo $grid_warning?></div>
        <?php
    }  

    $model = new PfOrderItems();
    $model->unsetAttributes();
    $model->order_id = $modelMain->primaryKey;

    $internalNotesVisible = false;
    if(Yii::app()->user->checkAccess('SysAdmin')){
        $internalNotesVisible = false;
    }elseif(Yii::app()->user->checkAccess('OrdersAdmin')){    
        $internalNotesVisible = true;
    }else{
        $ccuc = CcucUserCompany::model()->getPersonCompnies(
                    Yii::app()->getModule('user')->user()->profile->person_id, CcucUserCompany::CCUC_STATUS_PERSON);    
        foreach ($ccuc as $c) {
            if ($c->ccuc_ccmp_id == Yii::app()->sysCompany->getActiveCompany()) {
                continue;
            }
            $internalNotesVisible = $internalNotesVisible || $c->ccuc_ccmp_id != $modelMain->client_ccmp_id;
        }    
    }
    
    // render grid view

    $this->widget('TbGridView',
        [
            'id' => 'pf-order-items-grid',
            'dataProvider' => $model->searchClient(),
            'template' => '{summary}{items}',
            'summaryText' => '&nbsp;',
            'htmlOptions' => [
                'class' => 'rel-grid-view'
            ],            
            'columns' => [
                [
                'class' => 'editable.EditableColumn',
                'name' => 'manufakturer_ccmp_id',
                'editable' => [
                    'type' => 'select',
                    'url' => $this->createUrl('//ldm/pfOrderItems/editableSaver'),
                    'source' => CHtml::listData(CcmpCompany::model()->findAll(['limit' => 1000]), 'ccmp_id', 'itemLabel'),
                    //'placement' => 'right',
                ]
            ],
            [
                'class' => 'editable.EditableColumn',
                'name' => 'planed_ready_date',
                'editable' => [
                    'type' => 'date',
                    'url' => $this->createUrl('//ldm/pfOrderItems/editableSaver'),
                    //'placement' => 'right',
                ]
            ],
            [
                //decimal(5,2)
                'class' => 'editable.EditableColumn',
                'name' => 'load_meters',
                'editable' => [
                    'url' => $this->createUrl('//ldm/pfOrderItems/editableSaver'),
                    //'placement' => 'right',
                ]
            ],
            [
                //decimal(10,2)
                'class' => 'editable.EditableColumn',
                'name' => 'm3',
                'editable' => [
                    'url' => $this->createUrl('//ldm/pfOrderItems/editableSaver'),
                    //'placement' => 'right',
                ]
            ],
            [
                'class' => 'editable.EditableColumn',
                'name' => 'notes',
                'editable' => [
                    'type' => 'textarea',
                    'url' => $this->createUrl('//ldm/pfOrderItems/editableSaver'),
                    //'placement' => 'right',
                ]
            ],

            array(
                'class' => 'editable.EditableColumn',
                'name' => 'notes_admin_manufacturer',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('//ldm/pfOrderItems/editableSaver'),
                    //'placement' => 'right',
                ),
                'visible' => $internalNotesVisible,
            ),                

                [
                    'class' => 'TbButtonColumn',
                    'buttons' => [
                        'view' => ['visible' => 'FALSE'],
                        'update' => ['visible' => 'FALSE'],
                        'delete' => ['visible' => 'Yii::app()->user->checkAccess("Ldm.PfOrder.DeletepfOrderItems")'],
                    ],
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/ldm/pfOrderItems/delete", array("id" => $data->id))',
                    'deleteConfirmation'=>Yii::t('LdmModule.crud','Do you want to delete this item?'),   
                    'deleteButtonOptions'=>['data-toggle'=>'tooltip'],                    
                ],
            ]
        ]
    );

    Yii::endProfile('order_id.view.grid');
}    

