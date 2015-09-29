<?php

/**
 * This is the model base class for the table "pf_order_items".
 *
 * Columns in table "pf_order_items" available as properties of the model:
 * @property string $id
 * @property string $order_id
 * @property string $manufakturer_ccmp_id
 * @property string $planed_ready_date
 * @property string $load_meters
 * @property string $m3
 * @property string $notes
 *
 * Relations of table "pf_order_items" available as properties of the model:
 * @property PfOrder $order
 * @property CcmpCompany $manufakturerCcmp
 */
abstract class BasePfOrderItems extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pf_order_items';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('order_id', 'required'),
                array('manufakturer_ccmp_id, planed_ready_date, load_meters, m3, notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('load_meters, m3', 'type','type'=>'float'),
                array('order_id, manufakturer_ccmp_id', 'length', 'max' => 10),
                array('load_meters', 'length', 'max' => 6),
                array('m3', 'length', 'max' => 11),
                array('planed_ready_date, notes', 'safe'),
                array('id, order_id, manufakturer_ccmp_id, planed_ready_date, load_meters, m3, notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->order_id;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'order' => array(self::BELONGS_TO, 'PfOrder', 'order_id'),
                'manufakturerCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'manufakturer_ccmp_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('LdmModule.model', 'ID'),
            'order_id' => Yii::t('LdmModule.model', 'Order'),
            'manufakturer_ccmp_id' => Yii::t('LdmModule.model', 'Manufacturer'),
            'planed_ready_date' => Yii::t('LdmModule.model', 'Planed ready date'),
            'load_meters' => Yii::t('LdmModule.model', 'Load meters'),
            'm3' => Yii::t('LdmModule.model', 'Cubic meters'),
            'notes' => Yii::t('LdmModule.model', 'Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.order_id', $this->order_id);
        $criteria->compare('t.manufakturer_ccmp_id', $this->manufakturer_ccmp_id);
        $criteria->compare('t.planed_ready_date', $this->planed_ready_date, true);
        $criteria->compare('t.load_meters', $this->load_meters, true);
        $criteria->compare('t.m3', $this->m3, true);
        $criteria->compare('t.notes', $this->notes, true);


        return $criteria;

    }

}
