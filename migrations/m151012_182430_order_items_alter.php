<?php

class m151012_182430_order_items_alter extends EDbMigration
{
	public function up()
	{
        $sql = " 
            ALTER TABLE `pf_order_items`   
                ADD COLUMN `notes_admin_manufacturer` TEXT CHARSET utf8 NULL  COMMENT 'Internal notes' AFTER `notes`;
            
;             
                 ";
        $this->execute($sql);        
	}

	public function down()
	{
		echo "m151012_182430_order_items_alter does not support migration down.\n";
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