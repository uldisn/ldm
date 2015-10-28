<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#pf-order-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', [
            'id' => 'pf-order-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => [
                'enctype' => ''
            ]
        ]);

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span5">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.id')) != 'tooltip.id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'number') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.number')) != 'tooltip.number')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'number', ['size' => 20, 'maxlength' => 20]);
                            echo $form->error($model,'number')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'client_ccmp_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.client_ccmp_id')) != 'tooltip.client_ccmp_id')?$t:'' ?>'>
                                <?php
//                                $ccuc = CcucUserCompany::model()->getPersonCompnies(
//                                        Yii::app()->getModule('user')->user()->profile->person_id, 
//                                        CcucUserCompany::CCUC_STATUS_PERSON);
//                                $cl = [];
//                                foreach ($ccuc as $c){
//                                    if($c->ccuc_ccmp_id == Yii::app()->sysCompany->getActiveCompany()){
//                                        continue;
//                                    }
//                                    $cl[] = $c->ccuc_ccmp_id;
//                                }
//
//                                $criteria = new CDBCriteria();
//                                if(!empty($cl)){
//                                    $criteria->condition = "ccmp_id in (".implode(',',$cl) . ")";
//                                }
                                
                                $this->widget(
                                '\GtcRelation',
                                [
                                    'model' => $model,
                                    'relation' => 'clientCcmp',
                                    //'criteria' => $criteria,                    
                                    'fields' => 'itemLabel',
                                    'allowEmpty' => true,
                                    'style' => 'dropdownlist',
                                    'htmlOptions' => [
                                        'checkAll' => 'all',
                                        'style' => 'width: 212px;',
                                    ],
                                ]
                                );
                                echo $form->error($model,'client_ccmp_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'order_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.order_date')) != 'tooltip.order_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         [
                                 'model' => $model,
                                 'attribute' => 'order_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => ['size' => 10],
                                 'options' => [
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ],
                                 ]
                             );
                    ;
                            echo $form->error($model,'order_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'desired_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.desired_date')) != 'tooltip.desired_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         [
                                 'model' => $model,
                                 'attribute' => 'desired_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => ['size' => 10],
                                 'options' => [
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ],
                                 ]
                             );
                    ;
                            echo $form->error($model,'desired_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'planed_delivery_type') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.planed_delivery_type')) != 'tooltip.planed_delivery_type')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                [
                    'model' => $model,
                    'relation' => 'planedDeliveryType',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => [
                        'checkAll' => 'all',
                        'style' => 'width: 212px;',                        
                    ],
                ]
                );
                            echo $form->error($model,'planed_delivery_type')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'groupage') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.groupage')) != 'tooltip.groupage')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'groupage');
                            echo $form->error($model,'groupage')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?> 
                
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'planed_dispatch_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.planed_dispatch_date')) != 'tooltip.planed_dispatch_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         [
                                 'model' => $model,
                                 'attribute' => 'planed_dispatch_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => ['size' => 10],
                                 'options' => [
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ],
                                 ]
                             );
                    ;
                            echo $form->error($model,'planed_dispatch_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'planed_delivery_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.planed_delivery_date')) != 'tooltip.planed_delivery_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         [
                                 'model' => $model,
                                 'attribute' => 'planed_delivery_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => ['size' => 10],
                                 'options' => [
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ],
                                 ]
                             );
                    ;
                            echo $form->error($model,'planed_delivery_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'status') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.status')) != 'tooltip.status')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'status', $model->getEnumFieldLabels('status'));
                            echo $form->error($model,'status')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.notes')) != 'tooltip.notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'notes', ['rows' => 6, 'cols' => 50]);
                            echo $form->error($model,'notes')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

        
    </div>

    <p class="alert">
        
        <?php 
            echo Yii::t('LdmModule.crud','Fields with <span class="required">*</span> are required.');
                
            /**
             * @todo: We need the buttons inside the form, when a user hits <enter>
             */                
            echo ' '.CHtml::submitButton(Yii::t('LdmModule.crud', 'Save'), [
                'class' => 'btn btn-primary',
                'style'=>'visibility: hidden;'                
            ]);
                
        ?>
    </p>


    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
