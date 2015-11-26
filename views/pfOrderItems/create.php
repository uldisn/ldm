<?php
$pageTitle = Yii::t('LdmModule.model', 'Create New Order Items');    
$this->setPageTitle($pageTitle);

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("LdmModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>array("pfOrder/view",'id' => $model->order_id),
    "visible"=>(Yii::app()->user->checkAccess("Ldm.PfOrderItems.*") || Yii::app()->user->checkAccess("Ldm.PfOrderItems.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("LdmModule.crud","Cancel"),
                )
 ),true);
    
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo $pageTitle;?>            </h1>
        </div>
    </div>
</div>

<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>Yii::t("LdmModule.crud","Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('.crud-form form').submit();",
                       ),
                       "visible"=> (Yii::app()->user->checkAccess("Ldm.PfOrderItems.*") || Yii::app()->user->checkAccess("Ldm.PfOrderItems.View"))
                    )); 
                    ?>
                  
        </div>
    </div>
</div>