<?php

class m151031_154144_pf_order_item_notes_creeate extends EDbMigration
{
	public function up()
	{
     $sql = " 
        CREATE TABLE `pf_order_item_notes`(  
         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
         `order_item_id` INT UNSIGNED NOT NULL, 
         `created` DATETIME NOT NULL COMMENT 'Created',
         `from_pprs_id` SMALLINT UNSIGNED NOT NULL COMMENT 'From',
         `to_pprs_id` SMALLINT UNSIGNED COMMENT 'To',
          `message` TEXT COMMENT 'Message',
         `readed` DATETIME COMMENT 'Readed',
         PRIMARY KEY (`id`),
         FOREIGN KEY (`from_pprs_id`) REFERENCES `pprs_person`(`pprs_id`),
         FOREIGN KEY (`to_pprs_id`) REFERENCES `pprs_person`(`pprs_id`),
         FOREIGN KEY (`order_item_id`) REFERENCES `pf_order_items`(`id`)
       ) ENGINE=INNODB CHARSET=utf8;

                 ";
        $this->execute($sql);        
	}

	public function down()
	{
		echo "m151031_154144_pf_order_item_notes_creeate does not support migration down.\n";
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