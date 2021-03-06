<?php

/**
 * This is the model base class for the table "pf_delivery_type".
 *
 * Columns in table "pf_delivery_type" available as properties of the model:
 * @property integer $id
 * @property string $name
 * @property string $load_meters
 * @property string $cubic_meters
 *
 * Relations of table "pf_delivery_type" available as properties of the model:
 * @property PfOrder[] $pfOrders
 */
abstract class BasePfDeliveryType extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pf_delivery_type';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('name', 'required'),
                array('load_meters, cubic_meters', 'default', 'setOnEmpty' => true, 'value' => null),
                array('load_meters, cubic_meters', 'type','type'=>'float'),
                array('name', 'length', 'max' => 20),
                array('load_meters, cubic_meters', 'length', 'max' => 11),
                array('id, name, load_meters, cubic_meters', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->name;
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
                'pfOrders' => array(self::HAS_MANY, 'PfOrder', 'planed_delivery_type'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('LdmModule.model', 'ID'),
            'name' => Yii::t('LdmModule.model', 'Delivery type'),
            'load_meters' => Yii::t('LdmModule.model', 'Load meters'),
            'cubic_meters' => Yii::t('LdmModule.model', 'Cubic Meters'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.load_meters', $this->load_meters, true);
        $criteria->compare('t.cubic_meters', $this->cubic_meters, true);


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
