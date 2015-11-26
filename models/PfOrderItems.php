<?php

// auto-loading
Yii::setPathOfAlias('PfOrderItems', dirname(__FILE__));
Yii::import('PfOrderItems.*');

class PfOrderItems extends BasePfOrderItems {

    public $label;
    
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
    
    public function findPlaningOtherOrderItems($order_id) {
        $criteria = new CDbCriteria;

        $criteria->select = "t.id,concat(concat(YEAR(planed_dispatch_date),'/',WEEK(planed_dispatch_date,1)), ' | ', o.number, ' | ', client.ccmp_name, ' | ', manufacturer.ccmp_name) label";
        
        $criteria->join = "  
            INNER JOIN pf_order o 
              ON o.id = t.order_id 
            INNER JOIN ccmp_company `client` 
              ON o.client_ccmp_id = `client`.ccmp_id 
            INNER JOIN ccmp_company manufacturer 
              ON t.manufakturer_ccmp_id = manufacturer.ccmp_id 
            ";
        $criteria->compare('o.status', PfOrder::STATUS_PLANING);
        $criteria->addCondition('t.order_id != ' . $order_id);
        
        $criteria->order = 'o.planed_dispatch_date DESC,o.number';
                
        return $this->findAll($criteria);
    }

}
