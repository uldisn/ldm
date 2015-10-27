<?php

class m151027_182314_pf_order_alter_comments extends EDbMigration {

    public function up() {
        $sql = " 
                ALTER TABLE `pf_order`   
                  CHANGE `planed_delivery_type` `planed_delivery_type` TINYINT(3) UNSIGNED NULL  COMMENT 'Planned delivery type',
                  CHANGE `planed_dispatch_date` `planed_dispatch_date` DATE NULL  COMMENT 'Planned dispath date',
                  CHANGE `planed_delivery_date` `planed_delivery_date` DATE NULL  COMMENT 'Planned delivery date';

                
                 ";
        $this->execute($sql);
    }

    public function down() {
        echo "m151027_182314_pf_order_alter_comments does not support migration down.\n";
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
