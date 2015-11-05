<?php

class m151104_193449_pf_delivery_type_alter extends EDbMigration
{
	public function up()
	{
        $this->execute("
        ALTER TABLE `pf_delivery_type`   
          CHANGE `load_meters` `load_meters` DECIMAL(10,2) UNSIGNED NULL  COMMENT 'Load meters',
          ADD COLUMN `cubic_meters` DECIMAL(10,2) UNSIGNED NULL  COMMENT 'Cubic Meters' AFTER `load_meters`;
        ");        
	}

	public function down()
	{
		echo "m151104_193449_pf_delivery_type_alter does not support migration down.\n";
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