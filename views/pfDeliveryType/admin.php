<?php
$this->setPageTitle(Yii::t('LdmModule.model', 'Delivery Types'));
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
                'visible' => (Yii::app()->user->checkAccess('Ldm.PfDeliveryType.*') || Yii::app()->user->checkAccess('Ldm.PfDeliveryType.Create'))
            ]);
            ?>
        </div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('LdmModule.model', 'Delivery Types'); ?>            
            </h1>
        </div>
    </div>
</div>

<?php
Yii::beginProfile('PfDeliveryType.view.grid');
$this->widget('TbGridView', [
    'id' => 'pf-delivery-type-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    #'responsiveTable' => true,
    'template' => '{items}',
    'columns' => [
        [
            //varchar(20)
            'class' => 'editable.EditableColumn',
            'name' => 'name',
            'editable' => [
                'url' => $this->createUrl('/ldm/pfDeliveryType/editableSaver'),
            //'placement' => 'right',
            ]
        ],
        [
            //decimal(10,2)
            'class' => 'editable.EditableColumn',
            'name' => 'load_meters',
            'editable' => [
                'url' => $this->createUrl('/ldm/pfDeliveryType/editableSaver'),
            //'placement' => 'right',
            ]
        ],
        [
            //decimal(10,2) unsigned
            'class' => 'editable.EditableColumn',
            'name' => 'cubic_meters',
            'editable' => [
                'url' => $this->createUrl('/ldm/pfDeliveryType/editableSaver'),
            //'placement' => 'right',
            ]
        ],
    ]
        ]
);

Yii::endProfile('PfDeliveryType.view.grid');
