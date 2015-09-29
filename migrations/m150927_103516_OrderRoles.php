<?php

class m150927_103516_OrderRoles extends EDbMigration {

    public function up() {

        $sql = " 
            INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Orders','2','Orders',NULL,'N;');            
            INSERT INTO authitemchild (parent, child) 
                VALUES
                ('Orders', 'Ldm.PfOrder.*'),
                ('Orders', 'Ldm.PfOrder.Create'),
                ('Orders', 'Ldm.PfOrder.View'),
                ('Orders', 'Ldm.PfOrder.Update'),
                ('Orders', 'Ldm.PfOrder.Delete'),
                ('Orders', 'Ldm.PfOrder.Menu'),
            ('Orders', 'Ldm.PfOrderItems.*'),
            ('Orders', 'Ldm.PfOrderItems.Create'),
            ('Orders', 'Ldm.PfOrderItems.View'),
            ('Orders', 'Ldm.PfOrderItems.Update'),
            ('Orders', 'Ldm.PfOrderItems.Delete'),
            ('Orders', 'Ldm.PfOrderItems.Menu');                
;             
                 ";
        $this->execute($sql);
    }

    public function down() {
        $this->execute("
            DELETE FROM `authitemchild` WHERE `parent`= 'Orders';
            DELETE FROM `AuthItem` WHERE `name`= 'Orders';

        ");
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
