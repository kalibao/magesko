-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 03 Août 2015 à 11:09
-- Version du serveur :  5.5.41-0ubuntu0.14.04.1
-- Version de PHP :  5.5.9-1ubuntu4.7

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `kalibao`
--

-- --------------------------------------------------------

--
-- Structure de la table `affiliation_category`
--

CREATE TABLE IF NOT EXISTS `affiliation_category` (
  `id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `attribute_type_visibility`
--

CREATE TABLE IF NOT EXISTS `attribute_type_visibility` (
  `attribute_type_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores attribute types to display in front for faceted navigation for each branch. ';

-- --------------------------------------------------------

--
-- Structure de la table `attribute_type_visibility_i18n`
--

CREATE TABLE IF NOT EXISTS `attribute_type_visibility_i18n` (
  `attribute_type_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `label` varchar(200) DEFAULT NULL COMMENT 'label of the attribute type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='contains specific label of an attribute type for a given branch';

-- --------------------------------------------------------

--
-- Structure de la table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` bigint(20) unsigned NOT NULL,
  `branch_type_id` bigint(20) unsigned NOT NULL,
  `tree_id` bigint(20) unsigned NOT NULL,
  `parent` bigint(20) unsigned NULL COMMENT 'sets the parent of this branch',
  `order` int(11) DEFAULT NULL COMMENT 'sets the order for branches of the same level',
  `media_id` bigint(20) unsigned NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sets the visibility of the branch',
  `background` varchar(45) DEFAULT NULL COMMENT 'background color of the branch (used in back office only)',
  `presentation_type` tinyint(1) DEFAULT NULL COMMENT 'sets the display mode for the sheets of this branch (table, list...)',
  `offset` int(11) DEFAULT NULL COMMENT 'sets the permission level required to access this branch',
  `display_brands_types` tinyint(1) NOT NULL DEFAULT '0',
  `big_menu_only_first_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sets if all children branches must be shown in big menu',
  `unfold` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `google_shopping_category_id` bigint(20) unsigned NULL,
  `google_shopping` tinyint(1) DEFAULT NULL COMMENT 'sets if google shopping is used for this branch',
  `affiliation_category_id` bigint(20) unsigned NULL,
  `affiliation` tinyint(1) DEFAULT NULL COMMENT 'sets if affiliation categories are used for this branch',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='a branch is a container for sheets or product if the branch is part of the catalog';

-- --------------------------------------------------------

--
-- Structure de la table `branch_i18n`
--

CREATE TABLE IF NOT EXISTS `branch_i18n` (
  `branch_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `label` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'name of the branch',
  `description` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT 'description of the branch',
  `url` varchar(250) COLLATE utf8_bin DEFAULT NULL COMMENT 'url for the branch',
  `meta_title` varchar(1000) COLLATE utf8_bin DEFAULT NULL COMMENT 'content of the meta title tag',
  `meta_description` varchar(2000) COLLATE utf8_bin DEFAULT NULL COMMENT 'content of the meta description tag',
  `meta_keywords` varchar(2000) COLLATE utf8_bin DEFAULT NULL COMMENT 'content of the meta keywords tag',
  `h1_tag` varchar(2000) COLLATE utf8_bin DEFAULT NULL COMMENT 'content of the H1 tag'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='translations for branches';

-- --------------------------------------------------------

--
-- Structure de la table `branch_type`
--

CREATE TABLE IF NOT EXISTS `branch_type` (
  `id` bigint(20) unsigned NOT NULL,
  `url` varchar(200) DEFAULT NULL COMMENT 'contains the url for the branch type',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='stores branch types';

-- --------------------------------------------------------

--
-- Structure de la table `branch_type_i18n`
--

CREATE TABLE IF NOT EXISTS `branch_type_i18n` (
  `branch_type_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `label` varchar(50) DEFAULT NULL COMMENT 'name of the branch'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translation for branch type';

-- --------------------------------------------------------

--
-- Structure de la table `google_shopping_category`
--

CREATE TABLE IF NOT EXISTS `google_shopping_category` (
  `id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sheet`
--

CREATE TABLE IF NOT EXISTS `sheet` (
  `id` bigint(20) unsigned NOT NULL,
  `sheet_type_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `primary_key` bigint(20) unsigned DEFAULT NULL COMMENT 'value of the primary key for the attached entity',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='a sheet is used to attach an entity to a branch';

-- --------------------------------------------------------

--
-- Structure de la table `sheet_type`
--

CREATE TABLE IF NOT EXISTS `sheet_type` (
  `id` bigint(20) unsigned NOT NULL,
  `url_pick` varchar(250) DEFAULT NULL COMMENT 'url of the edit page for the entity',
  `table` varchar(64) DEFAULT NULL COMMENT 'name of the table of the entity',
  `url_zoom_front` varchar(250) DEFAULT NULL COMMENT 'url of the entity in front office',
  `url_zoom_back` varchar(250) DEFAULT NULL COMMENT 'url of the entity in back office',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='stores the sheet type and the table name for the related entity';

-- --------------------------------------------------------

--
-- Structure de la table `sheet_type_i18n`
--

CREATE TABLE IF NOT EXISTS `sheet_type_i18n` (
  `sheet_type_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `label` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='translations for sheet types';

-- --------------------------------------------------------

--
-- Structure de la table `tree`
--

CREATE TABLE IF NOT EXISTS `tree` (
  `id` bigint(20) unsigned NOT NULL,
  `tree_type_id` bigint(20) unsigned NOT NULL,
  `media_id` bigint(20) unsigned NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table stores the trees. A tree is the root element where branches are attached.';

-- --------------------------------------------------------

--
-- Structure de la table `tree_i18n`
--

CREATE TABLE IF NOT EXISTS `tree_i18n` (
  `tree_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `label` varchar(200) COLLATE utf8_bin DEFAULT NULL COMMENT 'name of the tree',
  `description` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT 'description for the tree'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='translation table for trees';

-- --------------------------------------------------------

--
-- Structure de la table `tree_type`
--

CREATE TABLE IF NOT EXISTS `tree_type` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='stores the tree type';

-- --------------------------------------------------------

--
-- Structure de la table `tree_type_i18n`
--

CREATE TABLE IF NOT EXISTS `tree_type_i18n` (
  `tree_type_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `label` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='translations for tree type';

--
-- Index pour les tables exportées
--


--
-- Index pour la table `attribute_type_visibility`
--
ALTER TABLE `attribute_type_visibility`
  ADD PRIMARY KEY (`attribute_type_id`,`branch_id`),
  ADD KEY `fk_attribute_type_has_branch_branch1_idx` (`branch_id`),
  ADD KEY `fk_attribute_type_has_branch_attribute_type1_idx` (`attribute_type_id`);

--
-- Index pour la table `attribute_type_visibility_i18n`
--
ALTER TABLE `attribute_type_visibility_i18n`
  ADD PRIMARY KEY (`attribute_type_id`,`branch_id`,`i18n_id`),
  ADD KEY `fk_table1_language1_idx` (`i18n_id`);

--
-- Index pour la table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_branch_branch_type1_idx` (`branch_type_id`),
  ADD KEY `fk_branch_tree1_idx` (`tree_id`),
  ADD KEY `fk_branch_branch1_idx` (`parent`),
  ADD KEY `fk_branch_media1_idx` (`media_id`),
  ADD KEY `fk_branch_google_shopping_category1_idx` (`google_shopping_category_id`),
  ADD KEY `fk_branch_affiliation_category1_idx` (`affiliation_category_id`);

--
-- Index pour la table `branch_i18n`
--
ALTER TABLE `branch_i18n`
  ADD PRIMARY KEY (`branch_id`,`i18n_id`),
  ADD KEY `fk_language_has_branch_branch1_idx` (`branch_id`),
  ADD KEY `fk_language_has_branch_language1_idx` (`i18n_id`);

--
-- Index pour la table `branch_type`
--
ALTER TABLE `branch_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `branch_type_i18n`
--
ALTER TABLE `branch_type_i18n`
  ADD PRIMARY KEY (`branch_type_id`,`i18n_id`),
  ADD KEY `fk_branch_type_has_language_language1_idx` (`i18n_id`),
  ADD KEY `fk_branch_type_has_language_branch_type1_idx` (`branch_type_id`);

--
-- Index pour la table `google_shopping_category`
--
ALTER TABLE `google_shopping_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `affiliation_category`
--
ALTER TABLE `affiliation_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sheet`
--
ALTER TABLE `sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sheet_sheet_type1_idx` (`sheet_type_id`),
  ADD KEY `fk_sheet_branch1_idx` (`branch_id`);

--
-- Index pour la table `sheet_type`
--
ALTER TABLE `sheet_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sheet_type_i18n`
--
ALTER TABLE `sheet_type_i18n`
  ADD PRIMARY KEY (`sheet_type_id`,`i18n_id`),
  ADD KEY `fk_language_has_sheet_type_sheet_type1_idx` (`sheet_type_id`),
  ADD KEY `fk_language_has_sheet_type_language1_idx` (`i18n_id`);

--
-- Index pour la table `tree`
--
ALTER TABLE `tree`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tree_tree_type1_idx` (`tree_type_id`),
  ADD KEY `fk_tree_media1_idx` (`media_id`);

--
-- Index pour la table `tree_i18n`
--
ALTER TABLE `tree_i18n`
  ADD PRIMARY KEY (`tree_id`,`i18n_id`),
  ADD KEY `fk_language_has_tree_tree1_idx` (`tree_id`),
  ADD KEY `fk_language_has_tree_language1_idx` (`i18n_id`);

--
-- Index pour la table `tree_type`
--
ALTER TABLE `tree_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tree_type_i18n`
--
ALTER TABLE `tree_type_i18n`
  ADD PRIMARY KEY (`tree_type_id`,`i18n_id`),
  ADD KEY `fk_language_has_tree_type_tree_type1_idx` (`tree_type_id`),
  ADD KEY `fk_language_has_tree_type_language1_idx` (`i18n_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `affiliation_category`
--
ALTER TABLE `affiliation_category`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `branch_type`
--
ALTER TABLE `branch_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `google_shopping_category`
--
ALTER TABLE `google_shopping_category`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sheet`
--
ALTER TABLE `sheet`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `sheet_type`
--
ALTER TABLE `sheet_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tree`
--
ALTER TABLE `tree`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tree_type`
--
ALTER TABLE `tree_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `attribute_type_visibility`
--
ALTER TABLE `attribute_type_visibility`
  ADD CONSTRAINT `fk_attribute_type_has_branch_branch1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attribute_type_has_branch_attribute_type1` FOREIGN KEY (`attribute_type_id`) REFERENCES `attribute_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `attribute_type_visibility_i18n`
--
ALTER TABLE `attribute_type_visibility_i18n`
  ADD CONSTRAINT `fk_table1_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_table1_attribute_type_visibility1` FOREIGN KEY (`attribute_type_id`, `branch_id`) REFERENCES `attribute_type_visibility` (`attribute_type_id`, `branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `fk_branch_tree1` FOREIGN KEY (`tree_id`) REFERENCES `tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_affiliation_category1` FOREIGN KEY (`affiliation_category_id`) REFERENCES `affiliation_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_branch1` FOREIGN KEY (`parent`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_branch_type1` FOREIGN KEY (`branch_type_id`) REFERENCES `branch_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_google_shopping_category1` FOREIGN KEY (`google_shopping_category_id`) REFERENCES `google_shopping_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `branch_i18n`
--
ALTER TABLE `branch_i18n`
  ADD CONSTRAINT `fk_language_has_branch_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_language_has_branch_branch1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `branch_type_i18n`
--
ALTER TABLE `branch_type_i18n`
  ADD CONSTRAINT `fk_branch_type_has_language_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_type_has_language_branch_type1` FOREIGN KEY (`branch_type_id`) REFERENCES `branch_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sheet`
--
ALTER TABLE `sheet`
  ADD CONSTRAINT `fk_sheet_sheet_type1` FOREIGN KEY (`sheet_type_id`) REFERENCES `sheet_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sheet_branch1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sheet_type_i18n`
--
ALTER TABLE `sheet_type_i18n`
  ADD CONSTRAINT `fk_language_has_sheet_type_sheet_type1` FOREIGN KEY (`sheet_type_id`) REFERENCES `sheet_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_language_has_sheet_type_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tree`
--
ALTER TABLE `tree`
  ADD CONSTRAINT `fk_tree_tree_type1` FOREIGN KEY (`tree_type_id`) REFERENCES `tree_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tree_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tree_i18n`
--
ALTER TABLE `tree_i18n`
  ADD CONSTRAINT `fk_language_has_tree_tree1` FOREIGN KEY (`tree_id`) REFERENCES `tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_language_has_tree_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tree_type_i18n`
--
ALTER TABLE `tree_type_i18n`
  ADD CONSTRAINT `fk_language_has_tree_type_tree_type1` FOREIGN KEY (`tree_type_id`) REFERENCES `tree_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_language_has_tree_type_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
