<?php
$this->setPageTitle(Yii::t('LdmModule.model', 'Order'));
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", [
    #"label"=>Yii::t("LdmModule.crud","Cancel"),
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : ["{$this->id}/admin"],
    "visible" => (Yii::app()->user->checkAccess("Ldm.PfOrder.*") || Yii::app()->user->checkAccess("Ldm.PfOrder.View")),
    "htmlOptions" => [
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("LdmModule.crud", "Back"),
    ]
        ], true);
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton; ?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-file-text-alt"></i>
                <?php echo Yii::t('LdmModule.model', 'Order'); ?>  
            </h1>
        </div>
        <div class="btn-group">
            <?php
            if (Yii::app()->user->checkAccess("audittrail")) {
                Yii::import('audittrail.*');
                $this->widget("vendor.dbrisinajumi.audittrail.widgets.AudittrailViewTbButton", [
                    'model_name' => get_class($model),
                    'model_id' => $model->getPrimaryKey(),
                ]);
            }

            echo CHtml::link('<img src="images/excel48.png">', array('viewExcel', 'id' => $model->id, 'lang' => Yii::app()->language));

            $this->widget("bootstrap.widgets.TbButton", [
                "label" => Yii::t("LdmModule.crud", "Delete"),
                "type" => "danger",
                "icon" => "icon-trash icon-white",
                "size" => "large",
                "htmlOptions" => [
                    "submit" => ["delete", "id" => $model->{$model->tableSchema->primaryKey}, "returnUrl" => (Yii::app()->request->getParam("returnUrl")) ? Yii::app()->request->getParam("returnUrl") : $this->createUrl("admin")],
                    "confirm" => Yii::t("LdmModule.crud", "Do you want to delete this item?")
                ],
                "visible" => (Yii::app()->request->getParam("id")) && (Yii::app()->user->checkAccess("Ldm.PfOrder.*") || Yii::app()->user->checkAccess("Ldm.PfOrder.Delete"))
            ]);
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span5">

        <?php
        $this->widget(
                'TbAceDetailView', [
            'data' => $model,
            'attributes' => [

                [
                    'name' => 'number',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'attribute' => 'number',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                            ], true
                    )
                ],
                [
                    'name' => 'client_ccmp_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'select',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'source' => CHtml::listData(CcmpCompany::model()->findAll(['limit' => 1000]), 'ccmp_id', 'itemLabel'),
                        'attribute' => 'client_ccmp_id',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'order_date',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'date',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'attribute' => 'order_date',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'desired_date',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'date',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'attribute' => 'desired_date',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'planed_delivery_type',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'select',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'source' => CHtml::listData(PfDeliveryType::model()->findAll(['limit' => 1000]), 'id', 'itemLabel'),
                        'attribute' => 'planed_delivery_type',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'groupage',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'attribute' => 'groupage',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                            ], true
                    )
                ],
                [
                    'name' => 'loading_meters',
                ],
                [
                    'name' => 'm3',
                ],
                [
                    'name' => 'planed_dispatch_date',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'date',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'attribute' => 'planed_dispatch_date',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'planed_delivery_date',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'date',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'attribute' => 'planed_delivery_date',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'status',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'type' => 'select',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                        'source' => $model->getEnumFieldLabels('status'),
                        'attribute' => 'status',
                            //'placement' => 'right',
                            ], true
                    )
                ],
                [
                    'name' => 'loading_meters',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'attribute' => 'loading_meters',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                            ], true
                    )
                ],
                [
                    'name' => 'notes',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', [
                        'model' => $model,
                        'attribute' => 'notes',
                        'url' => $this->createUrl('/ldm/pfOrder/editableSaver'),
                            ], true
                    )
                ],
            ],
        ]);
        ?><br/><?php
        $this->widget('d2FilesWidget', ['module' => $this->module->id, 'model' => $model]);
        ?>
    </div>


    <div class="span7">
        <?php $this->renderPartial('_view-relations_grids', ['modelMain' => $model, 'ajax' => false,]); ?>    
    </div>
</div>

<?php
echo $cancel_buton;
