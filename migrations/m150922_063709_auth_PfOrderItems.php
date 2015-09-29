<?php
 
class m150922_063709_auth_PfOrderItems extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItems.*','0','Ldm.PfOrderItems',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItems.Create','0','Ldm.PfOrderItems module create',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItems.View','0','Ldm.PfOrderItems module view',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItems.Update','0','Ldm.PfOrderItems module update',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItems.Delete','0','Ldm.PfOrderItems module delete',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItems.Menu','0','Ldm.PfOrderItems show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItems.*';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItems.Create';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItems.View';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItems.Update';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItems.Delete';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItems.Menu';

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


