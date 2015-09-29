<?php

class m150929_183509_pf_start extends EDbMigration {

    public function up() {
        $sql = " 
            CREATE TABLE `pf_delivery_type` (
            `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(20) NOT NULL COMMENT 'Delivery type',
            `load_meters` decimal(10,2) DEFAULT NULL COMMENT 'Load meters',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

            CREATE TABLE `pf_order` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `number` varchar(20) NOT NULL COMMENT 'Number',
              `client_ccmp_id` int(10) unsigned DEFAULT NULL,
              `order_date` date DEFAULT NULL COMMENT 'Date',
              `desired_date` date DEFAULT NULL COMMENT 'Desired date',
              `planed_delivery_type` tinyint(3) unsigned DEFAULT NULL COMMENT 'Planed delivery type',
              `groupage` tinyint(4) DEFAULT NULL COMMENT 'Groupage',
              `planed_dispatch_date` date DEFAULT NULL COMMENT 'Planed dispath date',
              `planed_delivery_date` date DEFAULT NULL COMMENT 'Planed delivery date',
              `status` enum('Planing','Ready','Delivery','Delivered') DEFAULT NULL COMMENT 'Status',
              `loading_meters` decimal(5,2) DEFAULT NULL COMMENT 'Loading meters',
              `m3` decimal(5,2) DEFAULT NULL COMMENT 'Cubic meters',
              `notes` text COMMENT 'Notes',
              PRIMARY KEY (`id`),
              KEY `client_ccmp_id` (`client_ccmp_id`),
              KEY `planed_delivery_type` (`planed_delivery_type`),
              CONSTRAINT `pf_order_ibfk_1` FOREIGN KEY (`client_ccmp_id`) REFERENCES `ccmp_company` (`ccmp_id`),
              CONSTRAINT `pf_order_ibfk_2` FOREIGN KEY (`planed_delivery_type`) REFERENCES `pf_delivery_type` (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

            CREATE TABLE `pf_order_items` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `order_id` int(10) unsigned NOT NULL COMMENT 'Order',
              `manufakturer_ccmp_id` int(10) unsigned DEFAULT NULL COMMENT 'Manufacturer',
              `planed_ready_date` date DEFAULT NULL COMMENT 'Planed ready date',
              `load_meters` decimal(5,2) DEFAULT NULL COMMENT 'Load meters',
              `m3` decimal(10,2) DEFAULT NULL COMMENT 'Cubic meters',
              `notes` text COMMENT 'Notes',
              PRIMARY KEY (`id`),
              KEY `order_id` (`order_id`),
              KEY `manufakturer_ccmp_id` (`manufakturer_ccmp_id`),
              CONSTRAINT `pf_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `pf_order` (`id`),
              CONSTRAINT `pf_order_items_ibfk_2` FOREIGN KEY (`manufakturer_ccmp_id`) REFERENCES `ccmp_company` (`ccmp_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


                 ";

        $this->execute($sql);
    }

    public function down() {
        echo "m150929_183509_pf_start does not support migration down.\n";
        return false;
    }

}
