<?php
 
class m150922_062409_auth_PfOrder extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrder.*','0','Ldm.PfOrder',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrder.Create','0','Ldm.PfOrder module create',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrder.View','0','Ldm.PfOrder module view',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrder.Update','0','Ldm.PfOrder module update',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrder.Delete','0','Ldm.PfOrder module delete',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrder.Menu','0','Ldm.PfOrder show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrder.*';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrder.Create';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrder.View';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrder.Update';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrder.Delete';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrder.Menu';

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


