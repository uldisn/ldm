<?php

class m151101_140432_grant_to_order_item_notes extends EDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO authitemchild (parent, child) VALUES  ('Orders', 'Ldm.PfOrderItemNotes.Create') ;
            INSERT INTO authitemchild (parent, child) VALUES  ('OrdersAdmin', 'Ldm.PfOrderItemNotes.Create') ;
        ");        
	}

	public function down()
	{
		echo "m151101_130432_grant_to_order_item_notes does not support migration down.\n";
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