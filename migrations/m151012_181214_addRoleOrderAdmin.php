<?php

class m151012_181214_addRoleOrderAdmin extends EDbMigration {

    public function up() {

        $sql = " 
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('OrdersAdmin','2','Orders Administrator',NULL,'N;');            
            INSERT INTO authitemchild (parent, child) 
                VALUES
                ('OrdersAdmin', 'Ldm.PfOrder.*'),
                ('OrdersAdmin', 'Ldm.PfOrder.Create'),
                ('OrdersAdmin', 'Ldm.PfOrder.View'),
                ('OrdersAdmin', 'Ldm.PfOrder.Update'),
                ('OrdersAdmin', 'Ldm.PfOrder.Delete'),
                ('OrdersAdmin', 'Ldm.PfOrder.Menu'),
            ('OrdersAdmin', 'Ldm.PfOrderItems.*'),
            ('OrdersAdmin', 'Ldm.PfOrderItems.Create'),
            ('OrdersAdmin', 'Ldm.PfOrderItems.View'),
            ('OrdersAdmin', 'Ldm.PfOrderItems.Update'),
            ('OrdersAdmin', 'Ldm.PfOrderItems.Delete'),
            ('OrdersAdmin', 'Ldm.PfOrderItems.Menu');                
;             
                 ";
        $this->execute($sql);
    }

    public function down() {
        echo "m151012_181214_addRoleOrderAdmin does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
