<?php

// auto-loading
Yii::setPathOfAlias('PfOrderItems', dirname(__FILE__));
Yii::import('PfOrderItems.*');

class PfOrderItems extends BasePfOrderItems {

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__) {
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
    public function search($criteria = null) {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), [
            'criteria' => $this->searchCriteria($criteria),
        ]);
    }

    public function searchClient($criteria = null) {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->distinct = true;

        $ccuc = CcucUserCompany::model()->getPersonCompnies(
                Yii::app()->getModule('user')->user()->profile->person_id, CcucUserCompany::CCUC_STATUS_PERSON);
        $cl = [];
        foreach ($ccuc as $c) {
            if ($c->ccuc_ccmp_id == Yii::app()->sysCompany->getActiveCompany()) {
                continue;
            }
            $cl[] = $c->ccuc_ccmp_id;
        }

        if (!empty($cl)) {

            $criteria->join = "  
                INNER JOIN pf_order o 
                    ON o.id = t.order_id 
            ";
            $criteria->addCondition(" 
                    (
                    o.client_ccmp_id IN (" . implode(',', $cl) . ") 
                    OR t.manufakturer_ccmp_id IN (" . implode(',', $cl) . ")
                    OR t.manufakturer_ccmp_id IS NULL    
                    )
                    ");
        }
        $criteria = $this->searchCriteria($criteria);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
        ]);
    }

    public function afterSave() {

        $items = PfOrderItems::model()->findAllByAttributes(['order_id'=>$this->order_id]);
        $m3 = $loadingMeters = 0;
        foreach($items as $item){
            $m3 += $item->m3;
            $loadingMeters += $item->load_meters;
        }
        
        $order = PfOrder::model()->findByPk($this->order_id);
        $order->m3 = $m3;
        $order->loading_meters = $loadingMeters;
        $order->save();
        
        parent::afterSave();
    }

}
