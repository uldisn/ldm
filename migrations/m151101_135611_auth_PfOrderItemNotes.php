<?php
 
class m151101_135611_auth_PfOrderItemNotes extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItemNotes.*','0','Ldm.PfOrderItemNotes',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItemNotes.Create','0','Ldm.PfOrderItemNotes module create',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItemNotes.View','0','Ldm.PfOrderItemNotes module view',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItemNotes.Update','0','Ldm.PfOrderItemNotes module update',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItemNotes.Delete','0','Ldm.PfOrderItemNotes module delete',NULL,'N;');
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Ldm.PfOrderItemNotes.Menu','0','Ldm.PfOrderItemNotes show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItemNotes.*';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItemNotes.Create';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItemNotes.View';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItemNotes.Update';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItemNotes.Delete';
            DELETE FROM `AuthItem` WHERE `name`= 'Ldm.PfOrderItemNotes.Menu';

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


