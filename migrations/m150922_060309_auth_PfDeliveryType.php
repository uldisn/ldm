<?php
 
class m150922_060309_auth_PfDeliveryType extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfDeliveryType.*','0','Ldm.PfDeliveryType',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfDeliveryType.Create','0','Ldm.PfDeliveryType module create',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfDeliveryType.View','0','Ldm.PfDeliveryType module view',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfDeliveryType.Update','0','Ldm.PfDeliveryType module update',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfDeliveryType.Delete','0','Ldm.PfDeliveryType module delete',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfDeliveryType.Menu','0','Ldm.PfDeliveryType show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfDeliveryType.*';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfDeliveryType.Create';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfDeliveryType.View';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfDeliveryType.Update';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfDeliveryType.Delete';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfDeliveryType.Menu';

        ");
    }

    public function safeUp()
    {
        $this->up();
    }

    public function safeDown()
    {
        $this->down();
    }
}


