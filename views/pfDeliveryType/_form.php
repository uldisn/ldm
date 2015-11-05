<div class="crud-form">
    <?php ?>    
    <?php
    Yii::app()->bootstrap->registerPackage('select2');
    Yii::app()->clientScript->registerScript('crud/variant/update', '$("#pf-delivery-type-form select").select2();');


    $form = $this->beginWidget('TbActiveForm', [
        'id' => 'pf-delivery-type-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'htmlOptions' => [
            'enctype' => ''
        ]
    ]);

    echo $form->errorSummary($model);
    ?>

    <div class="row">
        <div class="span12">
            <div class="form-horizontal">


                <?php ?>
                <div class="control-group">
                    <div class='control-label'>
                        <?php ?>
                    </div>
                    <div class='controls'>
                        <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                              title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.id')) != 'tooltip.id') ? $t : '' ?>'>
                                  <?php
                                  ;
                                  echo $form->error($model, 'id')
                                  ?>                            </span>
                    </div>
                </div>
                <?php ?>

                <?php ?>
                <div class="control-group">
                    <div class='control-label'>
                        <?php echo $form->labelEx($model, 'name') ?>
                    </div>
                    <div class='controls'>
                        <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                              title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.name')) != 'tooltip.name') ? $t : '' ?>'>
                                  <?php
                                  echo $form->textField($model, 'name', ['size' => 20, 'maxlength' => 20]);
                                  echo $form->error($model, 'name')
                                  ?>                            </span>
                    </div>
                </div>
                <?php ?>

                <?php ?>
                <div class="control-group">
                    <div class='control-label'>
                        <?php echo $form->labelEx($model, 'load_meters') ?>
                    </div>
                    <div class='controls'>
                        <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                              title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.load_meters')) != 'tooltip.load_meters') ? $t : '' ?>'>
                                  <?php
                                  echo $form->textField($model, 'load_meters', ['size' => 10, 'maxlength' => 10]);
                                  echo $form->error($model, 'load_meters')
                                  ?>                            </span>
                    </div>
                </div>
                <?php ?>
                <?php ?>
                <div class="control-group">
                    <div class='control-label'>
                        <?php echo $form->labelEx($model, 'cubic_meters') ?>
                    </div>
                    <div class='controls'>
                        <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                              title='<?php echo (($t = Yii::t('LdmModule.model', 'tooltip.cubic_meters')) != 'tooltip.cubic_meters') ? $t : '' ?>'>
                                  <?php
                                  echo $form->textField($model, 'cubic_meters', ['size' => 10, 'maxlength' => 10]);
                                  echo $form->error($model, 'cubic_meters')
                                  ?>                            </span>
                    </div>
                </div>
                <?php ?>                
            </div>
        </div>
        <!-- main inputs -->

    </div>
    <div class="row">

    </div>

    <p class="alert">

        <?php
        echo Yii::t('LdmModule.crud', 'Fields with <span class="required">*</span> are required.');

        /**
         * @todo: We need the buttons inside the form, when a user hits <enter>
         */
        echo ' ' . CHtml::submitButton(Yii::t('LdmModule.crud', 'Save'), [
            'class' => 'btn btn-primary',
            'style' => 'visibility: hidden;'
        ]);
        ?>
    </p>


    <?php $this->endWidget() ?>    <?php ?></div> <!-- form -->
