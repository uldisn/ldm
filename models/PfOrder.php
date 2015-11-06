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
    public $manufakturer;
    
    public $max_load_meters;
    public $max_cubic_meters;


    private $_userPersonCompanies = false;

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

    public function rules() {
        return array_merge(
                parent::rules(), [
            ['
                    id, number, client_ccmp_id, order_date, desired_date, 
                    planed_delivery_type, groupage, planed_dispatch_date, 
                    planed_delivery_date, status, loading_meters, m3, 
                    notes, week_number, order_date_range, desired_date_range,
                    planed_dispatch_date_range,planed_delivery_date_range,
                    manufakturer', 'safe', 'on' => 'search'],
                ]
        );
    }

    public function attributeLabels() {
        return array_merge(
                parent::attributeLabels(), [
            [ 
                'week_number' => Yii::t('LdmModule.model', 'Week Number'),
                'manufakturer' => Yii::t('LdmModule.model', 'Manufakturer'),
                ]
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
        $criteria = $this->searchCriteria($criteria);
        

        $criteria->select = 't.*';

        $criteria->join .= "  
            LEFT OUTER JOIN pf_delivery_type 
                ON t.planed_delivery_type = pf_delivery_type.id   
        ";
        
        $criteria->select .= ', pf_delivery_type.load_meters max_load_meters, pf_delivery_type.cubic_meters max_cubic_meters';        

        
        $criteria->join .= "  
            LEFT OUTER JOIN pf_order_items items 
                ON t.id = items.order_id 
        ";        
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
        
            $criteria->condition = "
                       t.client_ccmp_id           in (" . implode(',', $cl) . ") "      //orders ir usera kompānija
                    . " or items.manufakturer_ccmp_id in (" . implode(',', $cl) . ") "  //itema ražotājs ir user kompānija
                    . " or items.manufakturer_ccmp_id is null";                         //orderim vēl nav neviens items
        }
        
        /**
         * add column week_number
         */
        $criteria->select .= ",concat(YEAR(planed_dispatch_date),'/',WEEK(planed_dispatch_date,1)) week_number";
        $criteria->compare("concat(YEAR(planed_dispatch_date),'/',WEEK(planed_dispatch_date,1))", $this->week_number, true);

        /**
         * manufakturer
         */
        $criteria->select .= ",GROUP_CONCAT(DISTINCT ccmp.ccmp_name SEPARATOR  '<BR/>') manufakturer";
        $criteria->join .= "  
            LEFT OUTER JOIN ccmp_company ccmp 
                ON items.manufakturer_ccmp_id = ccmp.ccmp_id 
        ";
        $criteria->compare("ccmp.ccmp_name", $this->manufakturer, true);
        
        /**
         * order_date_range
         */
        if (!empty($this->order_date_range)) {
            $criteria->AddCondition("t.order_date >= '" . substr($this->order_date_range, 0, 10) . "'");
            $criteria->AddCondition("t.order_date <= '" . substr($this->order_date_range, -10) . "'");
        }

        /**
         * desired_date_range
         */
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

        $criteria->group = 't.id';
        
        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'pagination' => ['pageSize' => 25],
            'sort'=>[
                'defaultOrder'=>'week_number DESC',
            ],            
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
