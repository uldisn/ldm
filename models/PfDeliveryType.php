<?php

// auto-loading
Yii::setPathOfAlias('PfDeliveryType', dirname(__FILE__));
Yii::import('PfDeliveryType.*');

class PfDeliveryType extends BasePfDeliveryType
{

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), [
            'criteria' => $this->searchCriteria($criteria),
        ]);
    }

}
