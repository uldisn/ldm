<?php
$userPersonId = Yii::app()->getModule('user')->user()->profile->person_id;
foreach ($notes as $note) {
    ?>
    <tr>
        <td><?= $note->created ?></td>
        <td><?= pfOrder::$lists['pprs'][$note->from_pprs_id] ?></td>
        <td><?= pfOrder::$lists['pprs'][$note->to_pprs_id] ?></td>
        <td><?= $note->message ?></td>
        <td><?php
            if (empty($note->readed) && $userPersonId == $note->to_pprs_id) {
                $this->widget(
                        'bootstrap.widgets.TbButton', [
                    'buttonType' => 'Button',
                    'type' => 'danger',
                    'size' => 'mini',
                    'label' => Yii::t('LdmModule.crud', 'Mark as read'),
                    //'icon' => 'icon-plus',
                    'url' => [
                        'pfOrderItemNotes/markAsRead',
                        'id' => $note->primaryKey,
                    ],
                        ]
                );
            } else {
                echo $note->readed;
            }
            ?></td>
    </tr>
    <?php
}
