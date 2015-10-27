<?php

/**
 * This is the model base class for the table "pf_order".
 *
 * Columns in table "pf_order" available as properties of the model:
 * @property string $id
 * @property string $number
 * @property string $client_ccmp_id
 * @property string $order_date
 * @property string $desired_date
 * @property integer $planed_delivery_type
 * @property integer $groupage
 * @property string $planed_dispatch_date
 * @property string $planed_delivery_date
 * @property string $status
 * @property string $loading_meters
 * @property string $m3
 * @property string $notes
 *
 * Relations of table "pf_order" available as properties of the model:
 * @property CcmpCompany $clientCcmp
 * @property PfDeliveryType $planedDeliveryType
 * @property PfOrderItems[] $pfOrderItems
 */
abstract class BasePfOrder extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const STATUS_PLANING = 'Planing';
    const STATUS_READY = 'Ready';
    const STATUS_DELIVERY = 'Delivery';
    const STATUS_DELIVERED = 'Delivered';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pf_order';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('number', 'required'),
                array('client_ccmp_id, order_date, desired_date, planed_delivery_type, groupage, planed_dispatch_date, planed_delivery_date, status, loading_meters, m3, notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('planed_delivery_type, groupage', 'numerical', 'integerOnly' => true),
                array('loading_meters, m3', 'type','type'=>'float'),
                array('number', 'length', 'max' => 20),
                array('client_ccmp_id', 'length', 'max' => 10),
                array('loading_meters, m3', 'length', 'max' => 6),
                array('order_date, desired_date, planed_dispatch_date, planed_delivery_date, notes', 'safe'),
                array('status', 'in', 'range' => array(self::STATUS_PLANING, self::STATUS_READY, self::STATUS_DELIVERY, self::STATUS_DELIVERED)),
                array('id, number, client_ccmp_id, order_date, desired_date, planed_delivery_type, groupage, planed_dispatch_date, planed_delivery_date, status, loading_meters, m3, notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->number;
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
                'clientCcmp' => array(self::BELONGS_TO, 'CcmpCompany', 'client_ccmp_id'),
                'planedDeliveryType' => array(self::BELONGS_TO, 'PfDeliveryType', 'planed_delivery_type'),
                'pfOrderItems' => array(self::HAS_MANY, 'PfOrderItems', 'order_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('LdmModule.model', 'ID'),
            'number' => Yii::t('LdmModule.model', 'Number'),
            'client_ccmp_id' => Yii::t('LdmModule.model', 'Client Ccmp'),
            'order_date' => Yii::t('LdmModule.model', 'Date'),
            'desired_date' => Yii::t('LdmModule.model', 'Desired date'),
            'planed_delivery_type' => Yii::t('LdmModule.model', 'Planned delivery type'),
            'groupage' => Yii::t('LdmModule.model', 'Groupage'),
            'planed_dispatch_date' => Yii::t('LdmModule.model', 'Planned dispath date'),
            'planed_delivery_date' => Yii::t('LdmModule.model', 'Planned delivery date'),
            'status' => Yii::t('LdmModule.model', 'Status'),
            'loading_meters' => Yii::t('LdmModule.model', 'Loading meters'),
            'm3' => Yii::t('LdmModule.model', 'Cubic meters'),
            'notes' => Yii::t('LdmModule.model', 'Notes'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'status' => array(
               self::STATUS_PLANING => Yii::t('LdmModule.model', 'STATUS_PLANING'),
               self::STATUS_READY => Yii::t('LdmModule.model', 'STATUS_READY'),
               self::STATUS_DELIVERY => Yii::t('LdmModule.model', 'STATUS_DELIVERY'),
               self::STATUS_DELIVERED => Yii::t('LdmModule.model', 'STATUS_DELIVERED'),
           ),
            );
        return $this->enum_labels;
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }

    public function getEnumColumnLabel($column){
        return $this->getEnumLabel($column,$this->$column);
    }
    

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.number', $this->number, true);
        $criteria->compare('t.client_ccmp_id', $this->client_ccmp_id);
        $criteria->compare('t.order_date', $this->order_date, true);
        $criteria->compare('t.desired_date', $this->desired_date, true);
        $criteria->compare('t.planed_delivery_type', $this->planed_delivery_type);
        $criteria->compare('t.groupage', $this->groupage);
        $criteria->compare('t.planed_dispatch_date', $this->planed_dispatch_date, true);
        $criteria->compare('t.planed_delivery_date', $this->planed_delivery_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.loading_meters', $this->loading_meters, true);
        $criteria->compare('t.m3', $this->m3, true);
        $criteria->compare('t.notes', $this->notes, true);


        return $criteria;

    }

}
