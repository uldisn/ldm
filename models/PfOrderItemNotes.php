<?php

// auto-loading
Yii::setPathOfAlias('PfOrderItemNotes', dirname(__FILE__));
Yii::import('PfOrderItemNotes.*');

class PfOrderItemNotes extends BasePfOrderItemNotes
{

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors() {
        return array_merge(
            parent::behaviors(), 	
            [
                'LoggableBehavior'=> [
                    'class' => 'audittrail.behaviors.LoggableBehavior',
                ],
            ]
        );
    }


    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), [
            'criteria' => $this->searchCriteria($criteria),
            'pagination' => ['pageSize' => 25],
           // 'sort'=>array(
           //     'defaultOrder'=>'id DESC',
           // ),                        
        ]);
    }

}
