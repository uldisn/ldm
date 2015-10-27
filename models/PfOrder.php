<?php

// auto-loading
Yii::setPathOfAlias('PfOrder', dirname(__FILE__));
Yii::import('PfOrder.*');

class PfOrder extends BasePfOrder {

    public $week_number;
    public $order_date_range;
    public $desired_date_range;
    public $planed_dispatch_date_range;
    public $planed_delivery_date_range;
    private $_userPersonCompanies = false;

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        return parent::init();
    }

    public function getItemLabel() {
        return parent::getItemLabel();
    }

    public function behaviors() {
        return array_merge(
                parent::behaviors(), []
        );
    }

    public function rules() {
        return array_merge(
                parent::rules(), [
            ['
                    id, number, client_ccmp_id, order_date, desired_date, 
                    planed_delivery_type, groupage, planed_dispatch_date, 
                    planed_delivery_date, status, loading_meters, m3, 
                    notes, week_number, order_date_range, desired_date_range,
                    planed_dispatch_date_range,planed_delivery_date_range', 'safe', 'on' => 'search'],
                ]
        );
    }

    public function attributeLabels() {
        return array_merge(
                parent::attributeLabels(), [
            [ 'week_number' => Yii::t('LdmModule.model', 'Week Number'),]
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
        $criteria->select = 't.*';
        /**
         * add column week_number
         */
        $criteria->select .= ",concat(YEAR(planed_dispatch_date),'/',WEEK(planed_dispatch_date,1)) week_number";
        $criteria->compare("concat(YEAR(planed_dispatch_date),'/',WEEK(planed_dispatch_date,1))", $this->week_number, true);
//planed_dispatch_date_range,planed_delivery_date_range

        if (!empty($this->order_date_range)) {
            $criteria->AddCondition("t.order_date >= '" . substr($this->order_date_range, 0, 10) . "'");
            $criteria->AddCondition("t.order_date <= '" . substr($this->order_date_range, -10) . "'");
        }

        if (!empty($this->desired_date_range)) {
            $criteria->AddCondition("t.desired_date >= '" . substr($this->desired_date_range, 0, 10) . "'");
            $criteria->AddCondition("t.desired_date <= '" . substr($this->desired_date_range, -10) . "'");
        }

        if (!empty($this->planed_dispatch_date_range)) {
            $criteria->AddCondition("t.planed_dispatch_date >= '" . substr($this->planed_dispatch_date_range, 0, 10) . "'");
            $criteria->AddCondition("t.planed_dispatch_date <= '" . substr($this->planed_dispatch_date_range, -10) . "'");
        }

        if (!empty($this->planed_delivery_date_range)) {
            $criteria->AddCondition("t.planed_delivery_date >= '" . substr($this->planed_delivery_date_range, 0, 10) . "'");
            $criteria->AddCondition("t.planed_delivery_date <= '" . substr($this->planed_delivery_date_range, -10) . "'");
        }

        /**
         * filtrs klientiem un pircejiem 
         * orderam vai itemam jabut savas kompanijas
         */
        if (Yii::app()->user->checkAccess('Orders')
                && !Yii::app()->user->checkAccess('Administrator')) {
            
            $cl = $this->getUserPersonCompaniesIds();
            
            /**
             * ja nav pievienota neviena kompanija lietotjama, sarakstu nerada
             */
            if (count($cl) == 0) {
                $cl = ['0'];
            }
            
            $criteria->join = "  
                LEFT OUTER JOIN pf_order_items items 
                    ON t.id = items.order_id 
            ";
            $criteria->condition = "
                       t.client_ccmp_id           in (" . implode(',', $cl) . ") 
                    or items.manufakturer_ccmp_id in (" . implode(',', $cl) . ")";
        }
        $criteria = $this->searchCriteria($criteria);
        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 25),
            'sort'=>array(
                'defaultOrder'=>'week_number DESC',
            ),            
        ]);
    }

    public function getUserPersonCompanies() {

        if ($this->_userPersonCompanies) {
            return $this->_userPersonCompanies;
        }

        $personId = Yii::app()->getModule('user')->user()->profile->person_id;
        $this->_userPersonCompanies = CcucUserCompany::model()->getPersonCompnies($personId, CcucUserCompany::CCUC_STATUS_PERSON);

        return $this->_userPersonCompanies;
    }

    public function getUserPersonCompaniesIds() {
        $ccuc = $this->getUserPersonCompanies();
        $cl = [];
        if ($ccuc) {
            foreach ($ccuc as $c) {
                if ($c->ccuc_ccmp_id == Yii::app()->sysCompany->getActiveCompany()) {
                    continue;
                }
                $cl[] = $c->ccuc_ccmp_id;
            }
        }
        return $cl;
    }

}
