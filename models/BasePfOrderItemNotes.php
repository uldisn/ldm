<?php

/**
 * This is the model base class for the table "pf_order_item_notes".
 *
 * Columns in table "pf_order_item_notes" available as properties of the model:
 * @property string $id
 * @property string $order_item_id
 * @property string $created
 * @property integer $from_pprs_id
 * @property integer $to_pprs_id
 * @property string $message
 * @property string $readed
 *
 * Relations of table "pf_order_item_notes" available as properties of the model:
 * @property PprsPerson $fromPprs
 * @property PprsPerson $toPprs
 * @property PfOrderItems $orderItem
 */
abstract class BasePfOrderItemNotes extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pf_order_item_notes';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('order_item_id, created, from_pprs_id', 'required'),
                array('to_pprs_id, message, readed', 'default', 'setOnEmpty' => true, 'value' => null),
                array('from_pprs_id, to_pprs_id', 'numerical', 'integerOnly' => true),
                array('order_item_id', 'length', 'max' => 10),
                array('message, readed', 'safe'),
                array('id, order_item_id, created, from_pprs_id, to_pprs_id, message, readed', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->order_item_id;
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
                'fromPprs' => array(self::BELONGS_TO, 'PprsPerson', 'from_pprs_id'),
                'toPprs' => array(self::BELONGS_TO, 'PprsPerson', 'to_pprs_id'),
                'orderItem' => array(self::BELONGS_TO, 'PfOrderItems', 'order_item_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('LdmModule.model', 'ID'),
            'order_item_id' => Yii::t('LdmModule.model', 'Order Item'),
            'created' => Yii::t('LdmModule.model', 'Created'),
            'from_pprs_id' => Yii::t('LdmModule.model', 'From'),
            'to_pprs_id' => Yii::t('LdmModule.model', 'To'),
            'message' => Yii::t('LdmModule.model', 'Message'),
            'readed' => Yii::t('LdmModule.model', 'Readed'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.order_item_id', $this->order_item_id);
        $criteria->compare('t.created', $this->created, true);
        $criteria->compare('t.from_pprs_id', $this->from_pprs_id);
        $criteria->compare('t.to_pprs_id', $this->to_pprs_id);
        $criteria->compare('t.message', $this->message, true);
        $criteria->compare('t.readed', $this->readed, true);


        return $criteria;

    }
    
    public function delete() {

        /**
        * delete related records
        */
        foreach ($this->relations() as $relName => $relation) {
            if ($relation[0] != self::HAS_MANY && $relation[0] != self::HAS_ONE) {
                continue;
            }
            foreach ($this->$relName as $relRecord)
                $relRecord->delete();
        }
        return parent::delete();
    }    

}
