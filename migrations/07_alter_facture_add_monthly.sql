ALTER TABLE `facture` ADD `Monthly` TINYINT NOT NULL DEFAULT '0' AFTER `Interest`;
ALTER TABLE `facture` ADD `Weekly` TINYINT NOT NULL DEFAULT '0' AFTER `Monthly`;