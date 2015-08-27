SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ALLOW_INVALID_DATES';

ALTER TABLE `mail_sending_role` DROP FOREIGN KEY `mail_sending_role_ibfk_7`;

DELETE FROM `person` WHERE `person`.`id` = 1;
DELETE FROM `person` WHERE `person`.`id` = 2;

ALTER TABLE `person` 
DROP COLUMN `id`,
ADD COLUMN `third_id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'the person is a third' FIRST,
ADD COLUMN `gender_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL COMMENT 'the gender of the person,' /* comment truncated */ /*male or female. (or other :)*/ AFTER `user_id`,
ADD COLUMN `phone_1` VARCHAR(45) NULL DEFAULT NULL AFTER `gender_id`,
ADD COLUMN `phone_2` VARCHAR(45) NULL DEFAULT NULL AFTER `phone_1`,
ADD COLUMN `fax` VARCHAR(45) NULL DEFAULT NULL AFTER `phone_2`,
ADD COLUMN `website` VARCHAR(45) NULL DEFAULT NULL AFTER `fax`,
ADD COLUMN `birthday` TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00' AFTER `website`,
ADD COLUMN `skype` VARCHAR(45) NULL DEFAULT NULL AFTER `birthday`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`third_id`),
ADD INDEX `gender_id` (`gender_id` ASC);

ALTER TABLE `mail_sending_role` ADD FOREIGN KEY (`person_id`) REFERENCES `magesko`.`person`(`third_id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `third_role` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `third` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'the role is what kind of third it is.' /* comment truncated */ /*He can be refferencing person, society or many other.*/,
  `note` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Some notes about the third.' /* comment truncated */ /*Like he is a frod, or he is a good person.*/,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`, `role_id`),
  INDEX `index2` (`role_id` ASC),
  CONSTRAINT `fk_third_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `third_role` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'the third is everything ! He mirror a client.';

CREATE TABLE IF NOT EXISTS `society` (
  `third_id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'the society is a third',
  `society_type` BIGINT(20) UNSIGNED NOT NULL COMMENT 'The socity type is what the society do :' /* comment truncated */ /*School, Spoon selling, etc...*/,
  `tva_number` VARCHAR(45) NULL DEFAULT NULL,
  `naf` VARCHAR(45) NULL DEFAULT NULL,
  `siren` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`third_id`),
  INDEX `index2` (`society_type` ASC),
  CONSTRAINT `fk_society_1`
    FOREIGN KEY (`society_type`)
    REFERENCES `society_type` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_society_2`
    FOREIGN KEY (`third_id`)
    REFERENCES `third` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'A society is a third, inherit.';

CREATE TABLE IF NOT EXISTS `society_contact` (
  `society_id` BIGINT(20) UNSIGNED NOT NULL,
  `person_id` BIGINT(20) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`society_id`, `person_id`),
  INDEX `fk_contact_2_idx` (`person_id` ASC),
  CONSTRAINT `fk_contact_1`
    FOREIGN KEY (`society_id`)
    REFERENCES `society` (`third_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contact_2`
    FOREIGN KEY (`person_id`)
    REFERENCES `person` (`third_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `address_type` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `address_type_i18n` (
  `address_type_id` BIGINT(20) UNSIGNED NOT NULL,
  `i18n_id` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`address_type_id`, `i18n_id`),
  INDEX `fk_address_type_i18n_2_idx` (`i18n_id` ASC),
  CONSTRAINT `fk_address_type_i18n_1`
    FOREIGN KEY (`address_type_id`)
    REFERENCES `address_type` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_address_type_i18n_2`
    FOREIGN KEY (`i18n_id`)
    REFERENCES `language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `address` (
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `third_id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'A third address,' /* comment truncated */ /*a third may have many addresses.*/,
  `address_type_id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'The type is the king of address,' /* comment truncated */ /*like livraison, facturation, etc...*/,
  `label` VARCHAR(45) NULL DEFAULT NULL,
  `place_1` VARCHAR(45) NULL DEFAULT NULL,
  `place_2` VARCHAR(45) NULL DEFAULT NULL,
  `street_number` VARCHAR(45) NULL DEFAULT NULL,
  `door_code` VARCHAR(45) NULL DEFAULT NULL,
  `zip_code` VARCHAR(45) NULL DEFAULT NULL,
  `city` VARCHAR(45) NULL DEFAULT NULL,
  `country` VARCHAR(45) NULL DEFAULT NULL,
  `is_primary` TINYINT(1) NULL DEFAULT 0,
  `note` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  INDEX `index2` (`third_id` ASC),
  INDEX `index3` (`address_type_id` ASC),
  CONSTRAINT `fk_address_1`
    FOREIGN KEY (`address_type_id`)
    REFERENCES `address_type` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_address_2`
    FOREIGN KEY (`third_id`)
    REFERENCES `third` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `person_gender` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `person_gender_i18n` (
  `gender_id` BIGINT(20) UNSIGNED NOT NULL,
  `i18n_id` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`gender_id`, `i18n_id`),
  INDEX `fk_gender_i18n_2_idx` (`i18n_id` ASC),
  CONSTRAINT `fk_gender_i18n_1`
    FOREIGN KEY (`gender_id`)
    REFERENCES `person_gender` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gender_i18n_2`
    FOREIGN KEY (`i18n_id`)
    REFERENCES `language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `society_type` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `society_type_i18n` (
  `society_type_id` BIGINT(20) UNSIGNED NOT NULL,
  `i18n_id` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`society_type_id`, `i18n_id`),
  INDEX `fk_society_type_i18n_1_idx` (`i18n_id` ASC),
  CONSTRAINT `fk_society_type_i18n_1`
    FOREIGN KEY (`i18n_id`)
    REFERENCES `language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_society_type_i18n_2`
    FOREIGN KEY (`society_type_id`)
    REFERENCES `society_type` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `third_role_i18n` (
  `third_role_id` BIGINT(20) UNSIGNED NOT NULL,
  `i18n_id` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`third_role_id`, `i18n_id`),
  INDEX `fk_third_role_i18n_1_idx` (`i18n_id` ASC),
  CONSTRAINT `fk_third_role_i18n_1`
    FOREIGN KEY (`i18n_id`)
    REFERENCES `language` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_third_role_i18n_2`
    FOREIGN KEY (`third_role_id`)
    REFERENCES `third_role` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `person` 
ADD CONSTRAINT `fk_person_1`
  FOREIGN KEY (`gender_id`)
  REFERENCES `person_gender` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_person_2`
  FOREIGN KEY (`third_id`)
  REFERENCES `third` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
