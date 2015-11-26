<?php
$pageTitle = Yii::t('LdmModule.model', 'Get Item from other orders and attach to cuurrent order');
$this->setPageTitle($pageTitle);

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => array("pfOrder/view", 'id' => $order_id),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("LdmModule.crud", "Cancel"),
    )
        ), true);
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton; ?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo $pageTitle; ?>            </h1>
        </div>
    </div>
</div>
<?php 
        $form=$this->beginWidget('TbActiveForm', [
            'id' => 'pf-order-item-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => [
                'enctype' => ''
            ]
        ]);
?>
<div class="row">
    <div class="span12">
        <div class="form-horizontal">
            <div class="control-group">
                <div class='control-label'>
                    Select Item
                </div>
                <div class='controls'>
                    <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right">
                        <?php
                        $items = PfOrderItems::model()->findPlaningOtherOrderItems($order_id);
                        $listData = CHtml::listData($items, 'id', 'label');
                        echo CHtml::dropDownList('order_item_id', null, $listData);
                        ?>                            
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$this->endWidget()
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton; ?></div>
        <div class="btn-group">

            <?php
            $this->widget("bootstrap.widgets.TbButton", array(
                "label" => Yii::t("LdmModule.crud", "Save"),
                "icon" => "icon-thumbs-up icon-white",
                "size" => "large",
                "type" => "primary",
                "htmlOptions" => array(
                    "onclick" => "$('#pf-order-item-form').submit();",
                ),
            ));
            ?>

        </div>
    </div>
</div>