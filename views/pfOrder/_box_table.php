<?php
$ccmpList = CHtml::listData(CcmpCompany::model()->findAll(array('order' => 'ccmp_name')), 'ccmp_id', 'itemLabel');
pfOrder::$lists['pprs'] = CHtml::listData(PprsPerson::model()->findAll(), 'pprs_id', 'itemLabel');
foreach ($orderItems as $item) {
    ?>
    <tr>
        <td>
            <?php
            $this->widget(
                    'EditableField', array(
                'model' => $item,
                'type' => 'select',
                'url' => $this->createUrl('/ldm/pfOrderItems/editableSaver'),
                'source' => $ccmpList,
                'attribute' => 'manufakturer_ccmp_id',
                    //'placement' => 'right',
                    )
            )
            ?>
        </td>
        <td>
            <?php
            $this->widget(
                    'EditableField', array(
                'model' => $item,
                'type' => 'date',
                'url' => $this->createUrl('/ldm/pfOrderItems/editableSaver'),
                'attribute' => 'planed_ready_date',
                    //'placement' => 'right',
                    )
            )
            ?>
        </td>
        <td>
            <?php
            $this->widget(
                    'EditableField', array(
                'model' => $item,
                'attribute' => 'load_meters',
                'url' => $this->createUrl('/ldm/pfOrderItems/editableSaver'),
                    )
            );
            ?>
        </td>
        <td>
            <?php
            $this->widget(
                    'EditableField', array(
                'model' => $item,
                'attribute' => 'm3',
                'url' => $this->createUrl('/ldm/pfOrderItems/editableSaver'),
            ));
            ?>
        </td>
        <td>
            <?php
            $this->widget(
                    'EditableField', array(
                'model' => $item,
                'attribute' => 'notes',
                'url' => $this->createUrl('/ldm/pfOrderItems/editableSaver'),
            ));
            ?>
        </td>
        <td>
            <?php
            $this->widget(
                    'bootstrap.widgets.TbButton', [
                'buttonType' => 'Button',
                'type' => 'primary',
                'size' => 'mini',
                'icon' => 'icon-trash',
                'url' => [
                    '//ldm/pfOrderItems/delete',
                    'id' => $item->primaryKey,
                ],
                'htmlOptions' => [
                    'title' => Yii::t('LdmModule.crud', 'Delete Item'),
                    'data-toggle' => 'tooltip',
                ],
                    ]
            );
            ?>
        </td>
    </tr><tr>
        <td></td>
        <td colspan="5">

            <?php
            $addButton = $this->widget(
                    'bootstrap.widgets.TbButton', [
                'buttonType' => 'Button',
                'type' => 'primary',
                'size' => 'mini',
                'icon' => 'icon-plus',
                'url' => [
                    '//ldm/pfOrderItemNotes/create',
                    'order_item_id' => $item->primaryKey,
                ],
                'htmlOptions' => [
                    'title' => Yii::t('LdmModule.crud', 'Add new Note'),
                    'data-toggle' => 'tooltip',
                ],
                    ], true
            );

            $userPersonId = Yii::app()->getModule('user')->user()->profile->person_id;

            $criteria = new CDbCriteria();
            $criteria->condition = "t.from_pprs_id = " . $userPersonId . " OR t.to_pprs_id=" . $userPersonId;
            $criteria->compare('t.order_item_id', $item->primaryKey);

            $notes = PfOrderItemNotes::model()->findAll($criteria);

            $boxTable = $this->renderPartial('_box_table_notes', ['notes' => $notes], true);
            $this->widget('AceBoxTable', array(
                'header_color' => '',
                'header_text' => Yii::t('LdmModule.model', 'Item Notes'),
                'toolbar' => $addButton,
                //'info_allert' => $info_allert,
                'tableHead' => ['Created', 'From', 'To', 'Message', 'Readed'],
                'body' => $boxTable,
            ));

            $this->widget('d2FilesWidget', array('module' => $this->module->id, 'model' => $item, 'hideTitle' => true));
            ?>
        </td>
    </tr>
    <?php
}