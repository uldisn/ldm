<?php
$this->setPageTitle(Yii::t('LdmModule.model', 'Create Order'));

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", [
    #"label"=>Yii::t("LdmModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:["{$this->id}/admin"],
    "visible"=>(Yii::app()->user->checkAccess("Ldm.PfOrder.*") || Yii::app()->user->checkAccess("Ldm.PfOrder.View")),
    "htmlOptions"=>[
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("LdmModule.crud","Cancel"),
                ]
 ],true);
    
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-file-text-alt"></i>
                <?php echo Yii::t('LdmModule.model','Create Order');?> 
            </h1>
        </div>
    </div>
</div>

<?php $this->renderPartial('_form', ['model' => $model, 'buttons' => 'create']); ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", [
                       "label"=>Yii::t("LdmModule.crud","Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> [
                            "onclick"=>"$('.crud-form form').submit();",
                       ],
                       "visible"=> (Yii::app()->user->checkAccess("Ldm.PfOrder.*") || Yii::app()->user->checkAccess("Ldm.PfOrder.View"))
                    ]); 
                    ?>
                  
        </div>
    </div>
</div>