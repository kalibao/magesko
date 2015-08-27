ALTER TABLE `discount`
CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id of the discount',
CHANGE `percent` `percent` FLOAT NOT NULL DEFAULT '0' COMMENT 'discount rate in percent',
CHANGE `start_date` `start_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'begining date of the discount',
CHANGE `end_date` `end_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'end date of the discount',
CHANGE `percent_vip` `percent_vip` FLOAT NOT NULL DEFAULT '0' COMMENT 'discount rate for premium clients in percent',
CHANGE `start_date_vip` `start_date_vip` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'begining date of the discount for premium clients',
CHANGE `end_date_vip` `end_date_vip` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'end date of the discount for mremium clients';


