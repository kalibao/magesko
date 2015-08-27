-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 21 Juillet 2015 à 10:00
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
-- Base de données :  `mageskodev`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` bigint(20) unsigned NOT NULL,
  `third_id` bigint(20) unsigned NOT NULL COMMENT 'A third address,',
  `address_type_id` bigint(20) unsigned NOT NULL COMMENT 'The type is the king of address,',
  `label` varchar(45) DEFAULT NULL,
  `place_1` varchar(45) DEFAULT NULL,
  `place_2` varchar(45) DEFAULT NULL,
  `street_number` varchar(45) DEFAULT NULL,
  `door_code` varchar(45) DEFAULT NULL,
  `zip_code` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `address`
--

INSERT INTO `address` (`id`, `third_id`, `address_type_id`, `label`, `place_1`, `place_2`, `street_number`, `door_code`, `zip_code`, `city`, `country`, `is_primary`, `note`, `created_at`, `updated_at`) VALUES
(6, 41, 1, 'Dans ma cabane au fond du jardin', 'Cabane', 'Au bout du jardin', '', '', '', 'GardenCity', 'GardenCountry', 1, 'Attention au chiwawa.', '2015-06-10 07:46:30', '2015-06-10 07:46:30'),
(7, 43, 3, 'rt', '', '', '', '', '', '', '', 1, '', '2015-06-30 23:51:10', '2015-06-30 23:59:10');

-- --------------------------------------------------------

--
-- Structure de la table `address_type`
--

CREATE TABLE IF NOT EXISTS `address_type` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `address_type`
--

INSERT INTO `address_type` (`id`, `created_at`, `updated_at`) VALUES
(1, '2015-06-05 07:02:25', '2015-06-05 07:02:25'),
(2, '2015-06-05 07:02:33', '2015-06-05 07:02:33'),
(3, '2015-06-30 23:49:56', '2015-06-30 23:49:56');

-- --------------------------------------------------------

--
-- Structure de la table `address_type_i18n`
--

CREATE TABLE IF NOT EXISTS `address_type_i18n` (
  `address_type_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `address_type_i18n`
--

INSERT INTO `address_type_i18n` (`address_type_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Livraison'),
(1, 'fr', 'Livraison'),
(2, 'en', 'Facturation'),
(2, 'fr', 'Facturation'),
(3, 'fr', 'autre');

-- --------------------------------------------------------

--
-- Structure de la table `attribute`
--

CREATE TABLE IF NOT EXISTS `attribute` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the attribute',
  `attribute_type_id` bigint(20) unsigned NOT NULL COMMENT 'id of the attribute type corresponding to the current attribute',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='an attribute is for example "red", "10 cm", "XXL"...';

--
-- Contenu de la table `attribute`
--

INSERT INTO `attribute` (`id`, `attribute_type_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-06-10 08:30:21', '2015-06-10 08:30:21'),
(2, 1, '2015-06-10 08:30:28', '2015-06-10 08:30:28'),
(3, 1, '2015-06-10 08:30:39', '2015-06-10 08:30:39'),
(4, 2, '2015-06-10 08:31:09', '2015-06-10 08:31:09'),
(5, 2, '2015-06-10 08:31:16', '2015-06-10 08:31:16'),
(6, 1, '2015-06-18 08:43:51', '2015-06-18 08:43:51');

-- --------------------------------------------------------

--
-- Structure de la table `attribute_i18n`
--

CREATE TABLE IF NOT EXISTS `attribute_i18n` (
  `attribute_id` bigint(20) unsigned NOT NULL COMMENT 'id of the attribute',
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `value` varchar(45) DEFAULT NULL COMMENT 'translation for the value of the related attribute'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for attributes values';

--
-- Contenu de la table `attribute_i18n`
--

INSERT INTO `attribute_i18n` (`attribute_id`, `i18n_id`, `value`) VALUES
(1, 'fr', 'rouge'),
(2, 'fr', 'vert'),
(3, 'fr', 'bleu'),
(4, 'fr', '20cm'),
(5, 'fr', '30cm'),
(6, 'fr', 'orange');

-- --------------------------------------------------------

--
-- Structure de la table `attribute_type`
--

CREATE TABLE IF NOT EXISTS `attribute_type` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the attribute type',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='an attribute type is for example "color", "size", "weight"...';

--
-- Contenu de la table `attribute_type`
--

INSERT INTO `attribute_type` (`id`, `created_at`, `updated_at`) VALUES
(1, '2015-06-10 08:30:10', '2015-06-10 08:30:10'),
(2, '2015-06-10 08:30:59', '2015-06-10 08:30:59');

-- --------------------------------------------------------

--
-- Structure de la table `attribute_type_i18n`
--

CREATE TABLE IF NOT EXISTS `attribute_type_i18n` (
  `attribute_type_id` bigint(20) unsigned NOT NULL COMMENT 'id of the attribute type',
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `value` varchar(45) DEFAULT NULL COMMENT 'translation for the value of the related attribute type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for attributes types';

--
-- Contenu de la table `attribute_type_i18n`
--

INSERT INTO `attribute_type_i18n` (`attribute_type_id`, `i18n_id`, `value`) VALUES
(1, 'fr', 'couleur'),
(2, 'fr', 'taille');

-- --------------------------------------------------------

--
-- Structure de la table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the brand',
  `name` varchar(255) DEFAULT NULL COMMENT 'name of the brand'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='brands table';

--
-- Contenu de la table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Marque 1');

-- --------------------------------------------------------

--
-- Structure de la table `bundle`
--

CREATE TABLE IF NOT EXISTS `bundle` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the bundle',
  `bundle_variant` bigint(20) unsigned NOT NULL COMMENT 'id of the variant of the bundle',
  `product_id` bigint(20) unsigned NOT NULL COMMENT 'id of a product included in the bundle',
  `variant_id` bigint(20) unsigned DEFAULT NULL COMMENT 'variant for the product in the bundle : NULL if choice is given to the client -- variant_id if forced',
  `quantity` int(11) unsigned NOT NULL DEFAULT '1' COMMENT 'quantity of one product in the bundle',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='additional information for the variant if the product is a bundle';

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the category, ',
  `parent` bigint(20) unsigned DEFAULT NULL COMMENT 'parent category of the current one, set to null if the category is a root category',
  `media_id` bigint(20) unsigned NOT NULL COMMENT 'media associated to the category',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='category tree used to sort products';

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `parent`, `media_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, '2015-06-10 08:27:56', '2015-06-10 08:27:56'),
(2, 1, 1, '2015-07-15 10:51:47', '2015-07-15 10:51:47'),
(3, 1, 1, '2015-07-15 10:52:58', '2015-07-15 10:52:58'),
(4, 2, 1, '2015-07-15 10:54:10', '2015-07-15 10:54:10'),
(5, 2, 1, '2015-07-15 10:56:17', '2015-07-15 10:56:17');

-- --------------------------------------------------------

--
-- Structure de la table `category_i18n`
--

CREATE TABLE IF NOT EXISTS `category_i18n` (
  `category_id` bigint(20) unsigned NOT NULL COMMENT 'id of the translated category',
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `title` varchar(200) DEFAULT NULL COMMENT 'translation for the title of the category',
  `description` varchar(500) DEFAULT NULL COMMENT 'translation for the description of the category'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for the categories';

--
-- Contenu de la table `category_i18n`
--

INSERT INTO `category_i18n` (`category_id`, `i18n_id`, `title`, `description`) VALUES
(1, 'fr', 'base', 'categorie de base'),
(2, 'fr', 'Kitesurf', 'Tout pour le KiteSurf'),
(3, 'fr', 'Wakeboard', 'Tout pour le wake'),
(4, 'fr', 'Aile de kite', 'Kitesurf Les ailes'),
(5, 'fr', 'Planches de kite', 'Kitesurf les planches');

-- --------------------------------------------------------

--
-- Structure de la table `cms_image`
--

CREATE TABLE IF NOT EXISTS `cms_image` (
  `id` bigint(20) unsigned NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `cms_image_group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_image`
--

INSERT INTO `cms_image` (`id`, `file_path`, `cms_image_group_id`, `created_at`, `updated_at`) VALUES
(3, '6931062efa8a96e96844d9af8c350ff6/home-bg.jpg', 12, '2015-04-10 10:39:13', '2015-04-10 10:39:13'),
(4, 'bbdfe462d92b594a60cdb9a9216a3766/about-bg.jpg', 12, '2015-04-10 01:42:51', '2015-04-10 01:42:51'),
(5, 'd4c1d8e284936f4de025e95ab8414a4a/contact-bg.jpg', 12, '2015-04-10 07:25:23', '2015-04-10 07:25:23'),
(6, 'cd83bfd6d1c9e8da56f1d8da4642fc9f/post-bg.jpg', 12, '2015-04-10 09:34:58', '2015-04-10 09:34:58'),
(7, '8123044f1867d92401cfb14cab81fd43/DeathtoStock_SlowDown10.jpg', 12, '2015-04-10 23:50:11', '2015-04-10 23:50:11');

-- --------------------------------------------------------

--
-- Structure de la table `cms_image_group`
--

CREATE TABLE IF NOT EXISTS `cms_image_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_image_group`
--

INSERT INTO `cms_image_group` (`id`, `created_at`, `updated_at`) VALUES
(12, '2015-04-04 02:32:55', '2015-04-11 04:09:24');

-- --------------------------------------------------------

--
-- Structure de la table `cms_image_group_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_image_group_i18n` (
  `cms_image_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_image_group_i18n`
--

INSERT INTO `cms_image_group_i18n` (`cms_image_group_id`, `i18n_id`, `title`) VALUES
(12, 'en', 'Backend'),
(12, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `cms_image_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_image_i18n` (
  `cms_image_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_image_i18n`
--

INSERT INTO `cms_image_i18n` (`cms_image_id`, `i18n_id`, `title`) VALUES
(3, 'en', 'Home'),
(3, 'fr', 'Home'),
(4, 'fr', 'Presentation'),
(5, 'en', 'Contact'),
(5, 'fr', 'Contact'),
(6, 'en', 'Error'),
(6, 'fr', 'Error'),
(7, 'en', 'News'),
(7, 'fr', 'News');

-- --------------------------------------------------------

--
-- Structure de la table `cms_layout`
--

CREATE TABLE IF NOT EXISTS `cms_layout` (
  `id` bigint(20) unsigned NOT NULL,
  `max_container` smallint(5) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_layout`
--

INSERT INTO `cms_layout` (`id`, `max_container`, `path`, `view`, `created_at`, `updated_at`) VALUES
(7, 2, '//main', 'default', '2015-04-10 10:39:44', '2015-04-10 02:16:48');

-- --------------------------------------------------------

--
-- Structure de la table `cms_layout_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_layout_i18n` (
  `cms_layout_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_layout_i18n`
--

INSERT INTO `cms_layout_i18n` (`cms_layout_id`, `i18n_id`, `name`) VALUES
(7, 'en', 'Main'),
(7, 'fr', 'Principal');

-- --------------------------------------------------------

--
-- Structure de la table `cms_news`
--

CREATE TABLE IF NOT EXISTS `cms_news` (
  `id` bigint(20) unsigned NOT NULL,
  `cms_news_group_id` bigint(20) unsigned NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL,
  `published_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_news`
--

INSERT INTO `cms_news` (`id`, `cms_news_group_id`, `activated`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2015-04-10 00:00:00', '2015-04-10 09:17:35', '2015-04-11 00:34:19'),
(2, 2, 1, '2015-04-11 00:00:00', '2015-04-10 09:17:51', '2015-04-10 09:17:51'),
(3, 2, 1, '2015-04-12 00:00:00', '2015-04-11 00:33:44', '2015-04-11 00:33:44');

-- --------------------------------------------------------

--
-- Structure de la table `cms_news_group`
--

CREATE TABLE IF NOT EXISTS `cms_news_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_news_group`
--

INSERT INTO `cms_news_group` (`id`, `created_at`, `updated_at`) VALUES
(2, '2015-04-07 10:18:14', '2015-04-11 00:41:46');

-- --------------------------------------------------------

--
-- Structure de la table `cms_news_group_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_news_group_i18n` (
  `cms_news_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_news_group_i18n`
--

INSERT INTO `cms_news_group_i18n` (`cms_news_group_id`, `i18n_id`, `title`) VALUES
(2, 'fr', 'Principale');

-- --------------------------------------------------------

--
-- Structure de la table `cms_news_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_news_i18n` (
  `cms_news_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_news_i18n`
--

INSERT INTO `cms_news_i18n` (`cms_news_id`, `i18n_id`, `title`, `content`) VALUES
(1, 'en', 'News title 1', '<p>Content 1</p>\r\n'),
(1, 'fr', 'Titre de la news 1', '<p>Contenu de la news 1</p>\r\n'),
(2, 'en', 'News title 2', '<p>Content 2</p>\r\n'),
(2, 'fr', 'Titre de la news 2', '<p>Contenu de la news2</p>\r\n'),
(3, 'en', 'News title 3', '<p>Content 3</p>\r\n'),
(3, 'fr', 'Titre de la news 3', '<p>Contenu 3</p>\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `cms_page`
--

CREATE TABLE IF NOT EXISTS `cms_page` (
  `id` bigint(20) unsigned NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `cache_duration` int(10) unsigned NOT NULL,
  `cms_layout_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_page`
--

INSERT INTO `cms_page` (`id`, `activated`, `cache_duration`, `cms_layout_id`, `created_at`, `updated_at`) VALUES
(43, 1, 0, 7, '2015-04-10 10:43:36', '2015-04-11 07:56:24'),
(44, 1, 0, 7, '2015-04-10 01:42:18', '2015-04-10 09:29:21'),
(45, 1, 0, 7, '2015-04-10 02:49:57', '2015-04-10 09:29:18'),
(46, 1, 0, 7, '2015-04-10 23:54:13', '2015-04-10 23:54:28');

-- --------------------------------------------------------

--
-- Structure de la table `cms_page_content`
--

CREATE TABLE IF NOT EXISTS `cms_page_content` (
  `id` bigint(20) unsigned NOT NULL,
  `cms_page_id` bigint(20) unsigned NOT NULL,
  `index` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_page_content`
--

INSERT INTO `cms_page_content` (`id`, `cms_page_id`, `index`) VALUES
(86, 43, 1),
(87, 43, 2),
(88, 44, 1),
(89, 44, 2),
(90, 45, 1),
(91, 45, 2),
(92, 46, 1),
(93, 46, 2);

-- --------------------------------------------------------

--
-- Structure de la table `cms_page_content_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_page_content_i18n` (
  `cms_page_content_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_page_content_i18n`
--

INSERT INTO `cms_page_content_i18n` (`cms_page_content_id`, `i18n_id`, `content`) VALUES
(86, 'en', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/6931062efa8a96e96844d9af8c350ff6/home-bg.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="site-heading">\r\n<h1>Home</h1>\r\n\r\n<hr class="small" />\r\n<p><span class="subheading">My home page</span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(86, 'fr', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/6931062efa8a96e96844d9af8c350ff6/home-bg.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="site-heading">\r\n<h1>Accueil</h1>\r\n\r\n<hr class="small" />\r\n<p><span class="subheading">Ma page d''accueil</span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(87, 'en', '<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium recusandae illo eaque architecto error, repellendus iusto reprehenderit, doloribus, minus sunt. Numquam at quae voluptatum in officia voluptas voluptatibus, minus!</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum molestiae debitis nobis, quod sapiente qui voluptatum, placeat magni repudiandae accusantium fugit quas labore non rerum possimus, corrupti enim modi! Et.</p>\r\n</div>\r\n</div>\r\n'),
(87, 'fr', '<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium recusandae illo eaque architecto error, repellendus iusto reprehenderit, doloribus, minus sunt. Numquam at quae voluptatum in officia voluptas voluptatibus, minus!</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum molestiae debitis nobis, quod sapiente qui voluptatum, placeat magni repudiandae accusantium fugit quas labore non rerum possimus, corrupti enim modi! Et.</p>\r\n</div>\r\n</div>\r\n'),
(88, 'en', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/bbdfe462d92b594a60cdb9a9216a3766/about-bg.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="page-heading">\r\n<h1>Introduction</h1>\r\n\r\n<hr class="small" /><span class="subheading">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(88, 'fr', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/bbdfe462d92b594a60cdb9a9216a3766/about-bg.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="page-heading">\r\n<h1>Présentation</h1>\r\n\r\n<hr class="small" /><span class="subheading">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(89, 'en', '<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium recusandae illo eaque architecto error, repellendus iusto reprehenderit, doloribus, minus sunt. Numquam at quae voluptatum in officia voluptas voluptatibus, minus!</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum molestiae debitis nobis, quod sapiente qui voluptatum, placeat magni repudiandae accusantium fugit quas labore non rerum possimus, corrupti enim modi! Et.</p>\r\n</div>\r\n</div>\r\n'),
(89, 'fr', '<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium recusandae illo eaque architecto error, repellendus iusto reprehenderit, doloribus, minus sunt. Numquam at quae voluptatum in officia voluptas voluptatibus, minus!</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum molestiae debitis nobis, quod sapiente qui voluptatum, placeat magni repudiandae accusantium fugit quas labore non rerum possimus, corrupti enim modi! Et.</p>\r\n</div>\r\n</div>\r\n'),
(90, 'en', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/d4c1d8e284936f4de025e95ab8414a4a/contact-bg.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="page-heading">\r\n<h1>Contact-me</h1>\r\n\r\n<hr class="small" /><span class="subheading">Do you have some questions ?</span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(90, 'fr', '<!-- Page Header --><!-- Set your background image for this header on the line below. -->\r\n<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/d4c1d8e284936f4de025e95ab8414a4a/contact-bg.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="page-heading">\r\n<h1>Contactez-moi</h1>\r\n\r\n<hr class="small" /><span class="subheading">Vous avez des questions ? Vous souhaitez me rencontrer ?</span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(91, 'en', '<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?</p>\r\n\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n'),
(91, 'fr', '<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe nostrum ullam eveniet pariatur voluptates odit, fuga atque ea nobis sit soluta odio, adipisci quas excepturi maxime quae totam ducimus consectetur?</p>\r\n</div>\r\n</div>\r\n'),
(92, 'en', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/8123044f1867d92401cfb14cab81fd43/DeathtoStock_SlowDown10.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="page-heading">\r\n<h1>News</h1>\r\n\r\n<hr class="small" /><span class="subheading">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(92, 'fr', '<header class="intro-header" style="background-image: url(''http://static.kalibaoframework.lan/common/data/cms-image/max/8123044f1867d92401cfb14cab81fd43/DeathtoStock_SlowDown10.jpg'')">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">\r\n<div class="page-heading">\r\n<h1>Actualités</h1>\r\n\r\n<hr class="small" /><span class="subheading">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</header>\r\n'),
(93, 'en', ''),
(93, 'fr', '');

-- --------------------------------------------------------

--
-- Structure de la table `cms_page_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_page_i18n` (
  `cms_page_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `html_title` varchar(255) NOT NULL,
  `html_description` text NOT NULL,
  `html_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_page_i18n`
--

INSERT INTO `cms_page_i18n` (`cms_page_id`, `i18n_id`, `title`, `slug`, `html_title`, `html_description`, `html_keywords`) VALUES
(43, 'en', 'Home', 'home', 'Home', '', ''),
(43, 'fr', 'Accueil', 'home', 'Accueil', 'Home', ''),
(44, 'en', 'Introduction', 'introduction', 'Introduction', '', ''),
(44, 'fr', 'Présentation', 'presentation', 'Présentation', '', ''),
(45, 'en', 'Contact', 'contact', 'Contact', '', ''),
(45, 'fr', 'Contact', 'contact', 'Contact', '', ''),
(46, 'en', 'News', 'news', 'News', '', ''),
(46, 'fr', 'Actualités', 'actualites', 'Actualités', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `cms_simple_menu`
--

CREATE TABLE IF NOT EXISTS `cms_simple_menu` (
  `id` bigint(20) unsigned NOT NULL,
  `position` smallint(5) unsigned NOT NULL,
  `cms_simple_menu_group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_simple_menu`
--

INSERT INTO `cms_simple_menu` (`id`, `position`, `cms_simple_menu_group_id`, `created_at`, `updated_at`) VALUES
(5, 10, 4, '2015-04-09 00:16:43', '2015-04-11 08:23:48'),
(6, 20, 4, '2015-04-09 00:17:24', '2015-04-09 00:17:32'),
(7, 30, 4, '2015-04-09 00:17:56', '2015-04-09 02:32:32'),
(15, 15, 4, '2015-04-10 01:39:31', '2015-04-10 01:39:41'),
(18, 40, 4, '2015-04-11 07:40:05', '2015-04-11 07:40:05');

-- --------------------------------------------------------

--
-- Structure de la table `cms_simple_menu_group`
--

CREATE TABLE IF NOT EXISTS `cms_simple_menu_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_simple_menu_group`
--

INSERT INTO `cms_simple_menu_group` (`id`, `created_at`, `updated_at`) VALUES
(4, '2015-04-09 09:56:34', '2015-04-11 04:11:12');

-- --------------------------------------------------------

--
-- Structure de la table `cms_simple_menu_group_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_simple_menu_group_i18n` (
  `cms_simple_menu_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_simple_menu_group_i18n`
--

INSERT INTO `cms_simple_menu_group_i18n` (`cms_simple_menu_group_id`, `i18n_id`, `title`) VALUES
(4, 'en', 'Main menu'),
(4, 'fr', 'Menu principal');

-- --------------------------------------------------------

--
-- Structure de la table `cms_simple_menu_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_simple_menu_i18n` (
  `cms_simple_menu_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_simple_menu_i18n`
--

INSERT INTO `cms_simple_menu_i18n` (`cms_simple_menu_id`, `i18n_id`, `title`, `url`) VALUES
(5, 'en', 'Home', '/en'),
(5, 'fr', 'Accueil', '/fr'),
(6, 'en', 'News', '/en/news'),
(6, 'fr', 'Actualités', '/fr/actualites'),
(7, 'en', 'Contact', '/en/contact'),
(7, 'fr', 'Contact', '/fr/contact'),
(15, 'en', 'Introduction', '/en/introduction'),
(15, 'fr', 'Présentation', '/fr/presentation'),
(18, 'en', 'FR', '/fr'),
(18, 'fr', 'EN', '/en');

-- --------------------------------------------------------

--
-- Structure de la table `cms_social`
--

CREATE TABLE IF NOT EXISTS `cms_social` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_social`
--

INSERT INTO `cms_social` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', '2014-07-18 22:00:00', '2014-07-19 17:43:52'),
(2, 'Twitter', '2014-07-18 22:00:00', '2014-08-01 09:12:09');

-- --------------------------------------------------------

--
-- Structure de la table `cms_social_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_social_i18n` (
  `cms_social_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_social_i18n`
--

INSERT INTO `cms_social_i18n` (`cms_social_id`, `i18n_id`, `url`) VALUES
(1, 'en', ''),
(2, 'en', '');

-- --------------------------------------------------------

--
-- Structure de la table `cms_widget`
--

CREATE TABLE IF NOT EXISTS `cms_widget` (
  `id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `arg` text NOT NULL,
  `cms_widget_group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_widget`
--

INSERT INTO `cms_widget` (`id`, `path`, `arg`, `cms_widget_group_id`, `created_at`, `updated_at`) VALUES
(2, '\\yii\\bootstrap\\Alert', '{"body": "Say hello...","options":{"class":"danger"}}', 2, '2015-04-10 02:19:02', '2015-04-11 07:00:57');

-- --------------------------------------------------------

--
-- Structure de la table `cms_widget_group`
--

CREATE TABLE IF NOT EXISTS `cms_widget_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_widget_group`
--

INSERT INTO `cms_widget_group` (`id`, `created_at`, `updated_at`) VALUES
(2, '2015-04-10 02:17:27', '2015-04-11 00:41:07');

-- --------------------------------------------------------

--
-- Structure de la table `cms_widget_group_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_widget_group_i18n` (
  `cms_widget_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_widget_group_i18n`
--

INSERT INTO `cms_widget_group_i18n` (`cms_widget_group_id`, `i18n_id`, `title`) VALUES
(2, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `cms_widget_i18n`
--

CREATE TABLE IF NOT EXISTS `cms_widget_i18n` (
  `cms_widget_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `cms_widget_i18n`
--

INSERT INTO `cms_widget_i18n` (`cms_widget_id`, `i18n_id`, `title`) VALUES
(2, 'en', 'Widget Alert'),
(2, 'fr', 'Widget Alert');

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `third_id` bigint(20) unsigned NOT NULL COMMENT 'the society is a third',
  `company_type` bigint(20) unsigned DEFAULT NULL COMMENT 'The socity type is what the society do :',
  `name` varchar(45) DEFAULT NULL,
  `tva_number` varchar(45) DEFAULT NULL,
  `naf` varchar(45) DEFAULT NULL,
  `siren` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A company is a third, inherit.';

--
-- Contenu de la table `company`
--

INSERT INTO `company` (`third_id`, `company_type`, `name`, `tva_number`, `naf`, `siren`, `created_at`, `updated_at`) VALUES
(41, 4, 'Spoon&Co', 'this company sell only spoon.', '', '', '2015-06-10 06:43:17', '2015-06-10 10:40:22');

-- --------------------------------------------------------

--
-- Structure de la table `company_contact`
--

CREATE TABLE IF NOT EXISTS `company_contact` (
  `company_id` bigint(20) unsigned NOT NULL,
  `person_id` bigint(20) unsigned NOT NULL,
  `is_primary` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `company_contact`
--

INSERT INTO `company_contact` (`company_id`, `person_id`, `is_primary`, `created_at`, `updated_at`) VALUES
(41, 43, 0, '2015-06-30 23:59:49', '2015-06-30 23:59:49');

-- --------------------------------------------------------

--
-- Structure de la table `company_type`
--

CREATE TABLE IF NOT EXISTS `company_type` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `company_type`
--

INSERT INTO `company_type` (`id`, `created_at`, `updated_at`) VALUES
(4, '2015-06-02 06:02:12', '2015-06-02 06:02:12');

-- --------------------------------------------------------

--
-- Structure de la table `company_type_i18n`
--

CREATE TABLE IF NOT EXISTS `company_type_i18n` (
  `company_type_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `company_type_i18n`
--

INSERT INTO `company_type_i18n` (`company_type_id`, `i18n_id`, `title`) VALUES
(4, 'en', 'Spoon'),
(4, 'fr', 'Cuillère');

-- --------------------------------------------------------

--
-- Structure de la table `cross_selling`
--

CREATE TABLE IF NOT EXISTS `cross_selling` (
  `variant_id_1` bigint(20) unsigned NOT NULL COMMENT 'id of the first variant',
  `variant_id_2` bigint(20) unsigned NOT NULL COMMENT 'id of the second variant',
  `discount_id` bigint(20) unsigned NOT NULL COMMENT 'id discount for the current cross sale',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='cross sales information , relation table between variant and variant';

--
-- Contenu de la table `cross_selling`
--

INSERT INTO `cross_selling` (`variant_id_1`, `variant_id_2`, `discount_id`, `created_at`, `updated_at`) VALUES
(8, 11, 16, '2015-06-18 01:06:48', '2015-06-18 01:06:48');

-- --------------------------------------------------------

--
-- Structure de la table `discount`
--

CREATE TABLE IF NOT EXISTS `discount` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the discount',
  `percent` float NOT NULL DEFAULT '0' COMMENT 'discount rate in percent',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'begining date of the discount',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'end date of the discount',
  `percent_vip` float NOT NULL DEFAULT '0' COMMENT 'discount rate for premium clients in percent',
  `start_date_vip` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'begining date of the discount for premium clients',
  `end_date_vip` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'end date of the discount for mremium clients',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='discounts made on a variant or a cross sale';

--
-- Contenu de la table `discount`
--

INSERT INTO `discount` (`id`, `percent`, `start_date`, `end_date`, `percent_vip`, `start_date_vip`, `end_date_vip`, `created_at`, `updated_at`) VALUES
(1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:22', '2015-06-10 08:33:22'),
(2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:51', '2015-06-10 08:33:51'),
(3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:51', '2015-06-10 08:33:51'),
(4, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:51', '2015-06-10 08:33:51'),
(5, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:51', '2015-06-10 08:33:51'),
(6, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:51', '2015-06-10 08:33:51'),
(7, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-10 08:33:51', '2015-06-10 08:33:51'),
(8, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(9, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(10, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(11, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(12, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(13, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(14, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(15, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 08:43:58', '2015-06-18 08:43:58'),
(16, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-18 01:06:48', '2015-06-18 01:06:48');

-- --------------------------------------------------------

--
-- Structure de la table `interface_setting`
--

CREATE TABLE IF NOT EXISTS `interface_setting` (
  `interface_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `page_size` int(10) unsigned NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `interface_setting`
--

INSERT INTO `interface_setting` (`interface_id`, `user_id`, `page_size`) VALUES
('kalibao.backend:cms/cms-simple-menu', 1, 1),
('kalibao.backend:cms/cms-simple-menu-group', 1, 10),
('kalibao.backend:language/language-group-language', 1, 10),
('kalibao.backend:message/message', 1, 10),
('kalibao.backend:person/person', 1, 10),
('kalibao.backend:person/person-user', 1, 10),
('kalibao.backend:rbac/rbac-permission', 1, 50),
('kalibao.backend:variable/variable', 1, 10),
('kalibao.backend:variable/variable-group', 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` varchar(16) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `language`
--

INSERT INTO `language` (`id`) VALUES
('en'),
('fr');

-- --------------------------------------------------------

--
-- Structure de la table `language_group`
--

CREATE TABLE IF NOT EXISTS `language_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `language_group`
--

INSERT INTO `language_group` (`id`, `created_at`, `updated_at`) VALUES
(1, '2015-01-29 23:00:00', '2015-03-15 03:57:55'),
(2, '2015-03-15 04:15:47', '2015-04-09 05:07:32');

-- --------------------------------------------------------

--
-- Structure de la table `language_group_i18n`
--

CREATE TABLE IF NOT EXISTS `language_group_i18n` (
  `language_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `language_group_i18n`
--

INSERT INTO `language_group_i18n` (`language_group_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Backend'),
(1, 'fr', 'Backend'),
(2, 'en', 'Frontend'),
(2, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `language_group_language`
--

CREATE TABLE IF NOT EXISTS `language_group_language` (
  `id` int(10) unsigned NOT NULL,
  `language_group_id` bigint(20) unsigned NOT NULL,
  `language_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `language_group_language`
--

INSERT INTO `language_group_language` (`id`, `language_group_id`, `language_id`, `activated`) VALUES
(1, 1, 'fr', 1),
(2, 1, 'en', 1),
(3, 2, 'fr', 1),
(4, 2, 'en', 1);

-- --------------------------------------------------------

--
-- Structure de la table `language_i18n`
--

CREATE TABLE IF NOT EXISTS `language_i18n` (
  `language_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `language_i18n`
--

INSERT INTO `language_i18n` (`language_id`, `i18n_id`, `title`) VALUES
('en', 'en', 'English'),
('en', 'fr', 'Anglais'),
('fr', 'en', 'French'),
('fr', 'fr', 'Français');

-- --------------------------------------------------------

--
-- Structure de la table `logistic_strategy`
--

CREATE TABLE IF NOT EXISTS `logistic_strategy` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the logistic strategy',
  `stockout` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : set the strategy to stockout',
  `preorder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : set the strategy to preorder',
  `delivery_date` timestamp NULL DEFAULT NULL COMMENT 'if strategy is preorder, planned delivery date ',
  `real_stock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : set the strategy to real stock',
  `alert_stock` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'if strategy is real stock, stock quantity under which an alert is sent and the alternative strategy is used ',
  `direct_delivery` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : set strategy to direct delivery, can be an alternative strategy',
  `supplier_id` bigint(20) unsigned DEFAULT NULL COMMENT 'used if direct delivery is set to 1',
  `additional_delay` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'additional delay for delivery if strategy is set to direct delivery or just in time',
  `just_in_time` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : set strategy to just in time, can be an alternative strategy',
  `temporary_stockout` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : set strategy to temporary stockout, can be an alternative strategy'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='logistic related information. the table contains mainly switches to set which strategy is in use';

--
-- Contenu de la table `logistic_strategy`
--

INSERT INTO `logistic_strategy` (`id`, `stockout`, `preorder`, `delivery_date`, `real_stock`, `alert_stock`, `direct_delivery`, `supplier_id`, `additional_delay`, `just_in_time`, `temporary_stockout`) VALUES
(1, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(2, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(3, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(4, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(5, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(6, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(7, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(8, 1, 0, NULL, 1, 3, 0, NULL, 0, 0, 0),
(9, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(10, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(11, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(12, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(13, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(14, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0),
(15, 0, 0, NULL, 0, 0, 0, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `logistic_strategy_i18n`
--

CREATE TABLE IF NOT EXISTS `logistic_strategy_i18n` (
  `logistic_strategy_id` bigint(20) unsigned NOT NULL COMMENT 'id of the related logistic strategy',
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'language id',
  `message` varchar(5000) DEFAULT NULL COMMENT 'message used to give information to the client about logistic strategies'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for logistic strategy messages';

--
-- Contenu de la table `logistic_strategy_i18n`
--

INSERT INTO `logistic_strategy_i18n` (`logistic_strategy_id`, `i18n_id`, `message`) VALUES
(8, 'fr', '<p>msg</p>\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `mail_sending_role`
--

CREATE TABLE IF NOT EXISTS `mail_sending_role` (
  `person_id` bigint(20) unsigned NOT NULL,
  `mail_template_id` bigint(20) unsigned NOT NULL,
  `mail_send_role_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mail_sending_role`
--

INSERT INTO `mail_sending_role` (`person_id`, `mail_template_id`, `mail_send_role_id`) VALUES
(1, 3, 2),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mail_send_role`
--

CREATE TABLE IF NOT EXISTS `mail_send_role` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mail_send_role`
--

INSERT INTO `mail_send_role` (`id`, `created_at`, `updated_at`) VALUES
(1, '2013-01-25 16:30:04', '2013-01-25 16:30:16'),
(2, '2013-01-25 16:30:08', '2013-01-25 16:30:20'),
(3, '2013-01-25 16:30:27', '2013-01-25 16:30:27'),
(4, '2013-01-25 16:30:30', '2013-01-25 16:30:30');

-- --------------------------------------------------------

--
-- Structure de la table `mail_send_role_i18n`
--

CREATE TABLE IF NOT EXISTS `mail_send_role_i18n` (
  `mail_send_role_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mail_send_role_i18n`
--

INSERT INTO `mail_send_role_i18n` (`mail_send_role_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'From'),
(1, 'fr', 'From'),
(2, 'en', 'To'),
(2, 'fr', 'To'),
(3, 'en', 'Cc'),
(3, 'fr', 'Cc'),
(4, 'en', 'Bcc'),
(4, 'fr', 'Bcc');

-- --------------------------------------------------------

--
-- Structure de la table `mail_template`
--

CREATE TABLE IF NOT EXISTS `mail_template` (
  `id` bigint(20) unsigned NOT NULL,
  `mail_template_group_id` bigint(20) unsigned NOT NULL,
  `html_mode` tinyint(1) unsigned NOT NULL,
  `sql_request` text NOT NULL,
  `sql_param` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mail_template`
--

INSERT INTO `mail_template` (`id`, `mail_template_group_id`, `html_mode`, `sql_request`, `sql_param`, `created_at`, `updated_at`) VALUES
(3, 3, 1, '', '', '2014-11-24 19:39:02', '2015-04-02 09:34:04');

-- --------------------------------------------------------

--
-- Structure de la table `mail_template_group`
--

CREATE TABLE IF NOT EXISTS `mail_template_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `mail_template_group`
--

INSERT INTO `mail_template_group` (`id`, `created_at`, `updated_at`) VALUES
(2, '2013-01-25 13:47:50', '2015-04-11 00:39:21'),
(3, '2014-11-24 19:37:54', '2015-03-28 03:24:17');

-- --------------------------------------------------------

--
-- Structure de la table `mail_template_group_i18n`
--

CREATE TABLE IF NOT EXISTS `mail_template_group_i18n` (
  `mail_template_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `mail_template_group_i18n`
--

INSERT INTO `mail_template_group_i18n` (`mail_template_group_id`, `i18n_id`, `title`) VALUES
(2, 'en', 'Backend'),
(2, 'fr', 'Backend'),
(3, 'en', 'Frontend'),
(3, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `mail_template_i18n`
--

CREATE TABLE IF NOT EXISTS `mail_template_i18n` (
  `mail_template_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `object` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mail_template_i18n`
--

INSERT INTO `mail_template_i18n` (`mail_template_id`, `i18n_id`, `object`, `message`) VALUES
(3, 'en', 'Contact', '<p>Hello,</p>\r\n\r\n<p>You have received a message from {name}.</p>\r\n\r\n<p>Contact informations :</p>\r\n\r\n<ul>\r\n	<li>Name : {firstName}</li>\r\n	<li>Email : {email}</li>\r\n	<li>Phone : {phone}</li>\r\n</ul>\r\n\r\n<p>Message :</p>\r\n\r\n<p>{message}</p>\r\n\r\n<hr />\r\n<p>This message is automatically sent from contact page</p>\r\n'),
(3, 'fr', 'Demande de contact', '<p>Bonjour,</p>\r\n\r\n<p>Vous avez reçu un message de {name}.</p>\r\n\r\n<p>Informations du contact</p>\r\n\r\n<ul>\r\n	<li>Nom : {name}</li>\r\n	<li>Email : {email}</li>\r\n	<li>Téléphone : {phone}</li>\r\n</ul>\r\n\r\n<p>Message :</p>\r\n\r\n<p>{message}</p>\r\n\r\n<hr />\r\n<p>Ce message est automatiquement envoyé depuis la page de contact</p>\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the media',
  `file` varchar(255) NOT NULL COMMENT 'path to the media file',
  `media_type_id` bigint(20) unsigned NOT NULL COMMENT 'id of the media type',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='medias table';

--
-- Contenu de la table `media`
--

INSERT INTO `media` (`id`, `file`, `media_type_id`, `created_at`, `updated_at`) VALUES
(1, '8241a2170f0dfbdff2a73181b87780c0.jpg', 1, '2015-06-10 08:27:17', '2015-06-10 08:27:17');

-- --------------------------------------------------------

--
-- Structure de la table `media_i18n`
--

CREATE TABLE IF NOT EXISTS `media_i18n` (
  `media_id` bigint(20) unsigned NOT NULL COMMENT 'id of the media',
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `title` varchar(255) DEFAULT NULL COMMENT 'translation of the media title'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for medias titles';

--
-- Contenu de la table `media_i18n`
--

INSERT INTO `media_i18n` (`media_id`, `i18n_id`, `title`) VALUES
(1, 'fr', 'image');

-- --------------------------------------------------------

--
-- Structure de la table `media_type`
--

CREATE TABLE IF NOT EXISTS `media_type` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the media type',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='type of the media (example : picture, movie...)';

--
-- Contenu de la table `media_type`
--

INSERT INTO `media_type` (`id`, `created_at`, `updated_at`) VALUES
(1, '2015-06-10 06:26:56', '2015-06-10 06:26:56');

-- --------------------------------------------------------

--
-- Structure de la table `media_type_i18n`
--

CREATE TABLE IF NOT EXISTS `media_type_i18n` (
  `media_type_id` bigint(20) unsigned NOT NULL COMMENT 'id of the media type',
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `title` varchar(255) DEFAULT NULL COMMENT 'translation for the media type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for the media types';

--
-- Contenu de la table `media_type_i18n`
--

INSERT INTO `media_type_i18n` (`media_type_id`, `i18n_id`, `title`) VALUES
(1, 'fr', 'image');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) unsigned NOT NULL,
  `message_group_id` bigint(20) unsigned NOT NULL,
  `source` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=761 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `message_group_id`, `source`, `created_at`, `updated_at`) VALUES
(11, 1, 'i18n_fr', '2013-01-23 06:30:52', '2014-11-26 14:16:26'),
(12, 1, 'i18n_en', '2013-01-23 06:31:31', '2014-11-26 14:16:26'),
(13, 1, 'i18n_de', '2013-01-23 06:47:12', '2014-11-26 14:16:26'),
(14, 2, 'navbar_parameter', '2013-01-23 07:07:53', '2014-04-12 08:20:22'),
(15, 2, 'navbar_variable', '2013-01-23 07:10:33', '2014-04-12 08:20:22'),
(17, 1, 'btn_save', '2013-01-23 07:11:33', '2014-04-12 08:20:22'),
(18, 1, 'btn_add', '2013-01-23 07:12:34', '2014-06-28 09:29:10'),
(19, 1, 'btn_add_again', '2013-01-23 07:12:55', '2014-06-28 09:29:10'),
(20, 1, 'btn_close', '2013-01-23 07:13:08', '2014-06-28 09:29:10'),
(22, 1, 'btn_advanced_search', '2013-01-23 07:15:43', '2014-06-28 09:29:10'),
(23, 1, 'is_saved', '2013-01-23 07:16:32', '2014-06-28 09:29:10'),
(24, 1, 'advanced_search_title', '2013-01-23 07:41:06', '2014-06-28 09:29:10'),
(25, 1, 'btn_search', '2013-01-23 07:41:36', '2014-06-28 09:29:10'),
(29, 1, 'input_search', '2013-01-23 09:28:40', '2014-11-01 09:07:39'),
(30, 2, 'navbar_current_language', '2013-01-24 09:23:34', '2015-04-06 07:50:05'),
(34, 1, 'login_btn_connect', '2013-01-24 14:43:12', '2014-04-12 08:20:22'),
(36, 1, 'btn_check_all', '2013-01-24 15:25:07', '2014-04-12 08:20:22'),
(38, 1, 'btn_uncheck_all', '2013-01-24 15:26:39', '2014-04-12 08:20:22'),
(42, 1, 'btn_delete_selected', '2013-01-24 15:29:10', '2014-04-12 08:20:22'),
(43, 1, 'list_title', '2013-01-24 15:40:48', '2014-07-07 07:49:11'),
(44, 1, 'btn_settings', '2013-01-24 15:41:10', '2014-04-12 08:20:22'),
(45, 2, 'translate_title', '2013-01-25 15:31:29', '2014-07-06 06:23:30'),
(46, 1, 'input_select', '2013-01-26 14:45:43', '2014-07-19 08:06:05'),
(47, 1, 'input_drop_down_list_all', '2013-01-28 12:51:30', '2014-06-28 09:13:22'),
(48, 1, 'input_drop_down_list_checked', '2013-01-28 12:53:49', '2014-06-28 09:13:22'),
(49, 1, 'input_drop_down_list_unchecked', '2013-01-28 12:54:25', '2014-06-28 09:13:22'),
(51, 2, 'mail_template_btn_list_role', '2013-01-29 14:41:47', '2014-04-12 08:20:22'),
(61, 2, 'profile_password_is_required', '2013-01-30 18:29:35', '2014-06-27 08:14:18'),
(65, 1, 'person_email_exist', '2013-01-30 18:33:01', '2014-06-28 09:13:22'),
(71, 1, 'go_to_login', '2013-01-31 19:43:00', '2014-06-28 09:13:22'),
(74, 2, 'login_form:remember_me', '2013-01-31 20:07:11', '2014-11-22 09:51:15'),
(76, 2, 'account_not_validated', '2013-01-31 20:28:41', '2014-11-22 09:51:15'),
(81, 1, 'captcha_help', '2013-01-31 21:28:48', '2014-11-22 09:51:15'),
(96, 1, 'update', '2013-02-05 07:13:03', '2014-11-22 09:51:15'),
(99, 2, 'list_right_title', '2013-02-05 11:02:03', '2014-11-22 09:51:15'),
(102, 2, 'select_interface_title', '2013-02-05 14:01:48', '2014-11-22 09:51:15'),
(145, 1, 'edit_create_title', '2013-02-20 07:06:04', '2014-11-22 09:51:15'),
(146, 1, 'edit_update_title', '2013-02-20 07:06:21', '2014-11-22 09:51:15'),
(160, 2, 'navbar_media', '2013-02-20 13:00:45', '2014-11-22 09:51:15'),
(162, 2, 'navbar_message', '2013-02-20 13:01:18', '2014-07-05 07:38:04'),
(163, 2, 'navbar_right', '2013-02-20 13:01:38', '2014-06-27 07:22:10'),
(164, 2, 'navbar_language', '2013-02-20 13:01:52', '2014-06-27 07:22:10'),
(165, 2, 'navbar_mail', '2013-02-20 13:02:09', '2014-06-27 07:22:10'),
(178, 1, 'warning', '2013-02-21 08:19:43', '2014-04-12 08:36:07'),
(186, 1, 'btn_send', '2013-02-21 10:27:49', '2014-04-12 08:36:07'),
(189, 1, 'btn_cancel', '2013-02-21 10:28:58', '2014-04-12 08:36:07'),
(190, 1, 'btn_export_csv', '2013-04-17 09:44:53', '2014-04-12 08:36:07'),
(191, 1, 'no_results', '2013-04-25 07:56:57', '2014-04-12 08:36:07'),
(192, 1, 'list_advanced_search_title', '2013-04-25 07:57:36', '2014-04-12 08:36:07'),
(194, 2, 'navbar_rbac_person_user', '2013-04-25 08:01:24', '2015-04-05 09:28:40'),
(195, 1, 'settings_title', '2013-04-25 08:02:21', '2014-06-28 09:12:06'),
(196, 1, 'interface_setting:page_size', '2013-04-25 08:02:54', '2014-06-28 09:12:06'),
(197, 2, 'navbar_mail_template', '2013-04-25 08:03:52', '2014-07-08 13:31:01'),
(198, 2, 'navbar_mail_template_group', '2013-04-25 08:05:49', '2014-07-08 13:34:39'),
(199, 2, 'navbar_mail_send_role', '2013-04-25 08:06:34', '2014-07-08 13:25:51'),
(209, 2, 'navbar_variable_group', '2013-04-25 08:25:45', '2014-07-07 07:53:19'),
(211, 2, 'navbar_message_group', '2013-04-25 08:29:05', '2014-07-08 13:18:01'),
(213, 2, 'navbar_rbac_role', '2013-04-25 08:30:06', '2015-04-05 09:28:40'),
(214, 2, 'navbar_rbac_permission_role', '2013-04-25 08:30:40', '2015-04-05 09:37:28'),
(215, 2, 'navbar_auto_login', '2013-04-25 08:31:10', '2014-04-12 08:36:07'),
(217, 2, 'navbar_role', '2013-04-25 08:31:37', '2014-04-12 08:36:07'),
(219, 2, 'navbar_site_i18n', '2013-04-25 08:32:04', '2014-04-12 08:36:07'),
(220, 2, 'navbar_i18n', '2013-04-25 08:32:31', '2014-04-12 08:36:07'),
(227, 1, 'person:default_language', '2013-04-25 08:43:24', '2014-07-08 13:03:55'),
(230, 2, 'navbar_logout', '2013-04-25 08:45:22', '2015-04-05 08:12:22'),
(236, 2, 'login_title', '2013-04-25 08:51:08', '2014-07-14 07:41:13'),
(237, 1, 'btn_update', '2013-04-25 08:52:25', '2014-04-13 13:48:13'),
(238, 1, 'btn_edit_inline', '2013-04-25 08:53:24', '2014-04-12 08:36:07'),
(239, 1, 'btn_delete', '2013-04-25 08:54:03', '2014-04-12 08:36:07'),
(240, 1, 'btn_translate', '2013-04-25 09:00:37', '2014-07-06 06:23:30'),
(243, 1, 'btn_confirm', '2013-04-25 09:59:17', '2014-04-12 08:36:07'),
(244, 1, 'modal_remove_selected', '2013-04-25 10:00:05', '2015-06-02 07:02:05'),
(245, 1, 'modal_remove_one', '2013-04-25 10:12:21', '2015-06-02 07:02:05'),
(246, 2, 'person_email_exist', '2013-05-29 12:52:02', '2014-06-27 07:38:37'),
(247, 2, 'navbar_adv_setting', '2013-06-14 08:35:42', '2014-06-19 07:59:18'),
(248, 2, 'navbar_db_schema_flush', '2013-06-14 08:37:05', '2014-06-19 07:59:18'),
(249, 2, 'db_schema_refresh_title', '2013-06-14 08:38:59', '2015-04-09 05:33:43'),
(250, 2, 'db_schema_is_refreshed', '2013-06-14 08:39:57', '2014-04-12 08:36:07'),
(251, 2, 'navbar_profile', '2013-06-14 08:41:16', '2015-04-05 08:14:28'),
(252, 2, 'profile_edit_title', '2013-06-14 08:41:58', '2015-04-05 08:14:28'),
(253, 1, 'model:created_at', '2013-06-14 09:15:09', '2014-04-13 13:48:07'),
(254, 1, 'model:updated_at', '2013-06-14 09:15:36', '2014-04-13 13:48:13'),
(261, 2, 'right_right_interface_list_title', '2013-06-20 03:24:28', '2014-04-12 08:36:07'),
(263, 1, 'model:id', '2013-06-20 04:02:44', '2014-06-19 14:35:49'),
(277, 2, 'right_permission_role_edit_title', '2013-06-20 05:12:55', '2015-04-05 09:37:28'),
(278, 2, 'right_auto_login_list_title', '2013-06-20 05:13:40', '2014-04-12 08:36:07'),
(283, 2, 'right_interface_list_title', '2013-06-20 05:17:15', '2014-05-04 07:33:12'),
(285, 2, 'right_role_list_title', '2013-06-20 05:18:41', '2014-07-08 12:49:23'),
(287, 2, 'right_action_list_title', '2013-06-20 05:20:22', '2014-05-04 07:33:11'),
(291, 1, 'model:name', '2013-06-20 05:22:15', '2015-04-11 07:12:54'),
(295, 2, 'welcome_backend', '2013-10-01 04:54:46', '2014-04-29 07:12:17'),
(298, 1, 'date_range_between', '2014-01-22 12:58:34', '2014-04-29 07:12:17'),
(299, 1, 'date_range_separator', '2014-01-22 12:59:00', '2014-04-29 07:12:17'),
(300, 1, 'select_input_add', '2014-01-22 13:19:09', '2014-04-29 07:12:17'),
(302, 2, 'navbar_cache', '2014-01-22 13:22:13', '2014-05-04 13:46:07'),
(304, 2, 'btn_translate_all_message', '2014-01-22 13:39:04', '2014-07-06 06:23:30'),
(307, 1, 'create_title', '2014-04-29 07:24:41', '2014-07-19 17:24:35'),
(311, 1, 'update_title', '2014-05-04 13:36:58', '2014-07-19 17:24:17'),
(316, 2, 'person_group', '2014-05-04 14:25:07', '2014-06-27 09:02:07'),
(318, 2, 'bad_login_password', '2014-06-19 14:30:27', '2014-06-28 09:32:23'),
(321, 2, 'account_not_activated', '2014-06-27 07:17:57', '2014-11-26 12:56:48'),
(322, 2, 'person_email_not_exist', '2014-06-27 07:56:42', '2014-07-03 10:32:55'),
(323, 2, 'password_reset_email_sent', '2014-06-27 08:01:11', '2014-07-04 16:36:53'),
(324, 2, 'profile_old_password_not_valid', '2014-06-27 08:15:14', '2014-07-04 16:36:53'),
(326, 2, 'reset_password_invalid_token', '2014-06-27 12:25:41', '2014-07-04 16:36:53'),
(327, 2, 'password_reset_title', '2014-06-27 12:48:30', '2014-07-04 16:36:53'),
(328, 2, 'password_reset_renew', '2014-06-27 14:53:52', '2014-07-04 16:36:53'),
(329, 2, 'password_reset_cant_be_reset', '2014-06-28 05:38:28', '2014-07-04 16:36:53'),
(334, 2, 'cms_page_container_index', '2014-07-03 13:59:36', '2015-04-03 05:07:48'),
(335, 2, 'cache_refresh_success', '2014-07-04 16:35:38', '2014-07-05 07:43:59'),
(336, 2, 'cache_refresh_error', '2014-07-04 16:35:54', '2014-07-21 05:39:57'),
(337, 2, 'navbar_cms', '2014-07-05 07:37:13', '2014-07-05 07:43:59'),
(338, 2, 'navbar_cms_page', '2014-07-05 07:37:48', '2015-04-05 09:06:13'),
(339, 2, 'navbar_cms_edito', '2014-07-05 07:39:00', '2014-07-08 13:59:15'),
(340, 2, 'navbar_cms_layout', '2014-07-05 07:41:49', '2015-04-05 09:06:13'),
(341, 2, 'navbar_cms_edito_group', '2014-07-05 07:43:00', '2015-04-05 09:04:26'),
(342, 2, 'navbar_cms_widget', '2014-07-05 07:43:20', '2015-04-05 09:04:26'),
(343, 2, 'navbar_cms_image', '2014-07-05 07:44:20', '2015-04-05 09:04:26'),
(345, 1, 'model:activated', '2014-07-05 07:49:38', '2015-04-11 07:12:54'),
(346, 1, 'model:validated', '2014-07-05 07:52:36', '2015-04-11 07:12:54'),
(356, 2, 'btn_refresh_all_cms_page', '2014-07-05 08:13:23', '2015-04-01 22:16:58'),
(357, 2, 'btn_refresh_cms_page', '2014-07-05 08:16:54', '2015-04-01 22:16:58'),
(361, 1, 'model:title', '2014-07-05 08:32:07', '2015-04-11 07:12:54'),
(367, 1, 'model:description', '2014-07-05 08:44:55', '2015-04-11 07:12:54'),
(392, 1, 'message_source_exist', '2014-07-05 14:52:10', '2015-03-28 09:29:00'),
(398, 2, 'person_create_title', '2014-07-06 11:54:45', '2014-07-19 17:24:35'),
(399, 2, 'person_update_title', '2014-07-06 11:55:10', '2014-07-06 11:55:10'),
(401, 1, 'translate_title', '2014-07-07 07:50:45', '2015-03-28 09:29:00'),
(403, 1, 'cms_page_i18n_slug_exist', '2014-07-08 12:02:22', '2015-04-01 22:16:58'),
(405, 2, 'variable_variable_create_title', '2014-07-08 12:37:12', '2014-07-19 17:24:35'),
(406, 2, 'variable_variable_update_title', '2014-07-08 12:37:29', '2014-07-08 12:37:29'),
(407, 2, 'variable_variable_group_list_title', '2014-07-08 12:38:10', '2014-07-08 12:38:10'),
(408, 2, 'variable_variable_group_create_title', '2014-07-08 12:39:58', '2014-07-19 17:24:35'),
(409, 2, 'variable_variable_group_update_title', '2014-07-08 12:40:35', '2014-07-08 12:40:35'),
(410, 2, 'right_person_list_title', '2014-07-08 12:41:01', '2014-07-08 12:41:01'),
(411, 2, 'right_person_create_title', '2014-07-08 12:42:02', '2014-07-19 17:24:35'),
(412, 2, 'right_person_update_title', '2014-07-08 12:42:59', '2014-07-08 12:42:59'),
(413, 2, 'right_person_group_list_title', '2014-07-08 12:44:10', '2014-07-08 12:44:10'),
(414, 2, 'right_person_group_create_title', '2014-07-08 12:44:59', '2014-07-08 12:44:59'),
(415, 2, 'right_person_group_update_title', '2014-07-08 12:46:28', '2014-07-08 12:46:28'),
(416, 2, 'right_role_create_title', '2014-07-08 12:50:18', '2014-07-08 12:50:18'),
(417, 2, 'right_role_update_title', '2014-07-08 12:50:39', '2014-07-08 12:50:39'),
(418, 2, 'auto_login_auto_login_list_title', '2014-07-08 12:52:21', '2014-07-08 12:52:21'),
(419, 2, 'variable_variable_list_title', '2014-07-08 12:57:19', '2014-07-08 13:03:03'),
(420, 2, 'i18n_site_i18n_list_title', '2014-07-08 12:59:09', '2014-07-08 13:06:06'),
(422, 2, 'i18n_site_i18n_create_title', '2014-07-08 13:01:56', '2014-07-08 13:06:06'),
(423, 2, 'i18n_site_i18n_update_title', '2014-07-08 13:02:25', '2014-07-08 13:06:06'),
(425, 2, 'i18n_i18n_list_title', '2014-07-08 13:05:10', '2014-07-08 13:06:06'),
(426, 2, 'i18n_i18n_create_title', '2014-07-08 13:06:38', '2014-07-08 13:06:38'),
(427, 2, 'i18n_i18n_update_title', '2014-07-08 13:07:04', '2014-07-08 13:07:04'),
(428, 2, 'message_message_list_title', '2014-07-08 13:08:22', '2014-07-08 13:08:22'),
(429, 2, 'message_message_create_title', '2014-07-08 13:10:41', '2014-07-08 13:19:44'),
(430, 2, 'message_message_update_title', '2014-07-08 13:11:00', '2014-07-08 13:19:44'),
(431, 2, 'message_message_group_list_title', '2014-07-08 13:17:32', '2014-07-08 13:19:44'),
(432, 2, 'message_message_group_create_title', '2014-07-08 13:18:57', '2014-07-08 13:19:44'),
(433, 2, 'message_message_group_update_title', '2014-07-08 13:19:38', '2014-07-08 13:19:44'),
(434, 2, 'mail_mail_template_list_title', '2014-07-08 13:20:35', '2014-07-08 13:30:35'),
(435, 2, 'mail_mail_template_create_title', '2014-07-08 13:22:32', '2014-07-08 13:30:35'),
(436, 2, 'mail_mail_template_update_title', '2014-07-08 13:23:04', '2014-07-08 13:30:35'),
(437, 2, 'mail_mail_sending_role_list_title', '2014-07-08 13:24:17', '2014-07-08 15:00:24'),
(438, 2, 'mail_mail_sending_role_create_title', '2014-07-08 13:24:59', '2014-07-08 15:00:24'),
(439, 2, 'mail_mail_template_group_list_title', '2014-07-08 13:27:34', '2014-07-08 13:33:29'),
(440, 2, 'mail_mail_template_group_create_title', '2014-07-08 13:29:30', '2014-07-08 13:33:29'),
(441, 2, 'mail_mail_template_group_update_title', '2014-07-08 13:33:19', '2014-07-08 13:33:29'),
(442, 2, 'cms_page_list_title', '2014-07-08 13:52:01', '2015-04-01 22:16:58'),
(443, 2, 'cms_page_create_title', '2014-07-08 13:55:42', '2015-04-01 22:16:58'),
(444, 2, 'cms_page_update_title', '2014-07-08 13:56:05', '2015-04-01 22:16:58'),
(445, 2, 'cms_layout_list_title', '2014-07-08 13:56:46', '2014-07-08 13:57:19'),
(446, 2, 'cms_layout_create_title', '2014-07-08 13:58:09', '2014-07-08 13:58:09'),
(447, 2, 'cms_layout_update_title', '2014-07-08 13:58:38', '2014-07-08 13:58:38'),
(448, 2, 'cms_edito_list_title', '2014-07-08 14:00:00', '2014-07-12 03:48:52'),
(449, 2, 'cms_edito_create_title', '2014-07-08 14:00:28', '2014-07-08 14:00:28'),
(450, 2, 'cms_edito_update_title', '2014-07-08 14:00:54', '2014-07-11 10:44:52'),
(452, 2, 'cms_edito_group_create_title', '2014-07-08 14:02:41', '2014-07-11 10:44:52'),
(453, 2, 'cms_edito_group_update_title', '2014-07-08 14:03:24', '2014-08-05 07:00:11'),
(454, 2, 'cms_widget_list_title', '2014-07-08 14:05:15', '2015-04-05 07:25:46'),
(455, 2, 'cms_widget_create_title', '2014-07-08 14:05:41', '2015-04-05 07:25:46'),
(456, 2, 'cms_widget_update_title', '2014-07-08 14:06:05', '2015-04-05 07:25:46'),
(457, 2, 'cms_image_list_title', '2014-07-08 14:06:34', '2015-04-05 07:21:20'),
(458, 2, 'cms_image_create_title', '2014-07-08 14:07:29', '2015-04-05 07:21:20'),
(459, 2, 'cms_image_update_title', '2014-07-08 14:08:28', '2015-04-05 07:21:20'),
(460, 1, 'btn_upload', '2014-07-08 14:09:19', '2014-08-05 07:00:11'),
(461, 2, 'mail_mail_sending_role_update_title', '2014-07-08 15:00:05', '2014-08-05 07:00:11'),
(462, 1, 'uploader_max_size', '2014-07-09 05:03:13', '2014-08-05 07:00:11'),
(463, 1, 'select_input_update', '2014-07-10 07:55:35', '2014-07-18 07:20:57'),
(464, 2, 'btn_cms_image_select', '2014-07-10 12:25:09', '2015-04-05 07:21:20'),
(466, 2, 'cms_social_list_title', '2014-07-19 07:51:47', '2014-07-19 08:03:25'),
(467, 2, 'cms_social_update_title', '2014-07-19 07:52:23', '2014-07-19 08:03:25'),
(476, 2, 'navbar_cms_album', '2014-07-21 07:08:05', '2015-04-05 09:04:26'),
(477, 2, 'cms_album_list_title', '2014-07-21 07:13:16', '2014-07-21 07:13:16'),
(478, 2, 'cms_album_create_title', '2014-07-21 07:14:45', '2014-07-21 07:35:35'),
(479, 2, 'cms_album_update_title', '2014-07-21 07:15:03', '2014-07-21 07:35:35'),
(480, 2, 'cms_album_photo_list_title', '2014-07-21 07:32:44', '2014-07-21 07:35:35'),
(481, 2, 'cms_album_photo_create_title', '2014-07-21 07:34:36', '2014-07-21 07:35:35'),
(482, 2, 'cms_album_photo_update_title', '2014-07-21 07:35:23', '2014-07-21 07:35:35'),
(483, 2, 'btn_add_cms_album_photo', '2014-07-21 09:27:04', '2014-07-25 09:42:23'),
(485, 2, 'btn_view_photos', '2014-07-21 12:46:01', '2015-06-12 06:43:06'),
(486, 2, 'btn_cms_image_select_sm', '2014-07-23 12:44:43', '2015-04-05 07:21:20'),
(487, 2, 'btn_cms_image_select_lg', '2014-07-23 12:45:02', '2015-04-05 07:21:20'),
(493, 2, 'cms_news_list_title', '2014-07-28 14:20:38', '2014-11-22 09:57:36'),
(494, 2, 'cms_news_create_title', '2014-07-28 14:21:46', '2014-07-28 14:21:46'),
(495, 2, 'cms_news_update_title', '2014-07-28 14:22:07', '2014-07-28 14:22:07'),
(496, 2, 'cms_news_group_create_title', '2014-07-28 14:22:36', '2014-11-22 09:57:36'),
(497, 2, 'cms_news_group_update_title', '2014-07-28 14:22:58', '2015-03-26 06:00:09'),
(498, 2, 'cms_news_group_list_title', '2014-07-28 14:23:22', '2014-11-22 09:57:36'),
(499, 2, 'cms_edito_group_list_title', '2014-07-28 14:27:47', '2014-07-28 14:30:13'),
(500, 2, 'navbar_cms_news', '2014-07-28 14:29:51', '2015-04-05 09:04:26'),
(503, 2, 'navbar_cms_news_group', '2014-07-28 14:40:33', '2015-04-05 09:04:26'),
(504, 2, 'navbar_cms_menu', '2014-07-28 14:40:59', '2015-04-05 09:04:26'),
(505, 2, 'navbar_cms_menu_group', '2014-07-28 14:41:18', '2015-04-05 09:04:26'),
(506, 2, 'cms_menu_list_title', '2014-07-28 14:41:39', '2015-03-28 00:27:51'),
(507, 2, 'cms_menu_create_title', '2014-07-28 14:42:05', '2015-03-28 00:27:51'),
(508, 2, 'cms_menu_update_title', '2014-07-28 14:42:37', '2014-11-24 17:30:39'),
(509, 2, 'cms_menu_group_list_title', '2014-07-28 14:43:23', '2014-11-24 17:32:02'),
(511, 2, 'cms_menu_group_create_title', '2014-07-28 14:44:34', '2014-11-24 17:32:02'),
(512, 2, 'cms_menu_group_update_title', '2014-07-28 14:45:14', '2014-11-24 17:32:02'),
(516, 2, 'url_manager_refresh_title', '2014-11-24 17:29:12', '2014-11-24 17:32:02'),
(517, 2, 'url_manager_schema_flush', '2014-11-24 17:30:01', '2015-03-28 09:40:56'),
(518, 2, 'url_is_refreshed', '2014-11-24 17:31:50', '2014-12-04 09:57:07'),
(524, 3, 'email_is_sent', '2014-11-25 15:03:35', '2015-03-28 04:10:22'),
(526, 1, 'i18n_es', '2014-11-26 14:16:01', '2015-03-28 04:10:22'),
(530, 1, 'mail_template_not_translated', '2014-12-05 07:41:20', '2015-04-04 06:30:32'),
(543, 1, 'select_group_language', '2015-03-28 10:02:38', '2015-04-11 01:45:52'),
(544, 1, 'first_page', '2015-03-28 10:36:16', '2015-04-04 06:30:32'),
(545, 1, 'last_page', '2015-03-28 10:36:35', '2015-04-04 06:30:32'),
(546, 1, 'user.status:enabled', '2015-03-29 04:36:29', '2015-04-11 07:12:54'),
(547, 1, 'user.status:disabled', '2015-03-29 04:36:45', '2015-04-11 07:12:54'),
(548, 2, 'btn_sending_role', '2015-03-29 04:36:31', '2015-04-04 06:30:32'),
(549, 1, 'mail_template_request_error', '2015-03-29 02:50:21', '2015-04-04 06:30:32'),
(550, 1, 'module_generated', '2015-04-02 01:42:09', '2015-04-04 06:30:32'),
(551, 2, 'warning_user_rigth_refresh_auto', '2015-04-04 06:25:21', '2015-04-04 06:30:32'),
(552, 2, 'cms_image_group_create_title', '2015-04-05 08:06:22', '2015-04-05 07:21:20'),
(553, 2, 'cms_image_group_update_title', '2015-04-05 08:07:13', '2015-04-05 07:21:20'),
(554, 2, 'cms_image_group_list_title', '2015-04-05 08:09:29', '2015-04-05 07:21:20'),
(555, 2, 'language_language_create_title', '2015-04-05 08:12:25', '2015-04-11 07:44:50'),
(556, 2, 'language_language_update_title', '2015-04-05 08:14:53', '2015-04-11 07:44:50'),
(557, 2, 'language_language_list_title', '2015-04-05 08:15:16', '2015-04-11 07:44:50'),
(558, 2, 'language_language_group_create_title', '2015-04-05 08:17:30', '2015-04-11 07:44:50'),
(559, 2, 'language_language_group_update_title', '2015-04-05 08:20:10', '2015-04-11 07:44:50'),
(560, 2, 'language_language_group_list_title', '2015-04-05 08:20:37', '2015-04-11 07:44:50'),
(561, 2, 'language_language_group_language_create_title', '2015-04-05 08:23:42', '2015-04-11 07:44:50'),
(562, 2, 'language_language_group_language_update_title', '2015-04-05 08:25:12', '2015-04-11 08:10:27'),
(563, 2, 'language_language_group_language_list_title', '2015-04-05 08:28:08', '2015-04-11 08:10:27'),
(564, 2, 'rbac_user_create_title', '2015-04-05 08:32:25', '2015-04-11 08:10:27'),
(565, 2, 'rbac_user_update_title', '2015-04-05 08:32:45', '2015-04-11 08:10:27'),
(566, 2, 'rbac_user_list_title', '2015-04-05 08:32:57', '2015-04-11 08:10:27'),
(567, 2, 'rbac_permission_create_title', '2015-04-05 08:35:33', '2015-04-11 08:10:27'),
(568, 2, 'rbac_permission_update_title', '2015-04-05 08:35:50', '2015-04-11 08:10:27'),
(569, 2, 'rbac_permission_list_title', '2015-04-05 08:36:05', '2015-04-11 08:10:27'),
(570, 2, 'rbac_role_create_title', '2015-04-05 08:38:00', '2015-04-11 08:10:27'),
(571, 2, 'rbac_role_update_title', '2015-04-05 08:38:22', '2015-04-11 08:10:27'),
(572, 2, 'rbac_role_list_title', '2015-04-05 08:38:37', '2015-04-11 08:10:27'),
(573, 2, 'cms_widget_group_create_title', '2015-04-05 08:52:18', '2015-04-11 08:10:27'),
(574, 2, 'cms_widget_group_update_title', '2015-04-05 08:52:43', '2015-04-11 08:10:27'),
(575, 2, 'cms_widget_group_list_title', '2015-04-05 08:53:10', '2015-04-11 08:10:27'),
(577, 2, 'navbar_cms_image_group', '2015-04-05 09:04:12', '2015-04-11 08:10:27'),
(578, 2, 'navbar_cms_widget_group', '2015-04-05 09:08:39', '2015-04-11 08:10:27'),
(579, 2, 'navbar_language_group', '2015-04-05 09:20:59', '2015-04-11 08:10:27'),
(580, 2, 'navbar_language_group_language', '2015-04-05 09:21:33', '2015-04-11 08:10:27'),
(581, 2, 'navbar_rbac_permission', '2015-04-05 09:32:10', '2015-04-11 08:10:27'),
(582, 1, 'browser_compatibility_error_ie10', '2015-04-06 04:27:42', '2015-04-11 08:10:27'),
(583, 2, 'dashboard_title', '2015-04-06 04:53:23', '2015-04-11 08:10:27'),
(584, 2, 'navbar_dashboard', '2015-04-06 04:54:03', '2015-04-11 08:10:27'),
(585, 2, 'select_other_language', '2015-04-06 09:59:19', '2015-04-11 08:10:27'),
(586, 2, 'login_form:password', '2015-04-08 05:08:04', '2015-04-11 08:10:27'),
(587, 1, 'module_generator_title', '2015-04-09 09:31:59', '2015-04-11 08:10:27'),
(588, 2, 'cms_simple_menu_group_list_title', '2015-04-09 00:19:12', '2015-04-11 08:10:27'),
(589, 2, 'cms_simple_menu_group_create_title', '2015-04-09 00:19:52', '2015-04-11 08:10:27'),
(590, 2, 'cms_simple_menu_group_update_title', '2015-04-09 00:20:19', '2015-04-11 08:10:27'),
(591, 2, 'cms_simple_menu_list_title', '2015-04-09 00:22:34', '2015-04-11 08:10:27'),
(592, 2, 'cms_simple_menu_create_title', '2015-04-09 00:23:33', '2015-04-11 08:10:27'),
(593, 2, 'cms_simple_menu_update_title', '2015-04-09 00:23:49', '2015-04-11 08:10:27'),
(594, 2, 'btn_cms_simple_menu', '2015-04-09 03:12:36', '2015-04-11 08:10:27'),
(595, 2, 'navbar_cms_simple_menu_group', '2015-04-09 04:06:09', '2015-04-11 08:10:27'),
(597, 3, 'contact_form:name', '2015-04-11 09:41:36', '2015-04-11 08:10:27'),
(598, 3, 'contact_form:email', '2015-04-11 09:48:27', '2015-04-11 08:10:27'),
(599, 3, 'contact_form:message', '2015-04-11 09:48:50', '2015-04-11 08:10:27'),
(600, 3, 'contact_form:phone', '2015-04-11 09:49:09', '2015-04-11 08:10:27'),
(601, 3, 'contact_form:verify_code', '2015-04-11 09:49:44', '2015-04-11 08:10:27'),
(602, 3, 'email_not_sent', '2015-04-11 10:24:35', '2015-04-11 08:10:27'),
(603, 2, 'person_user_roles', '2015-04-11 01:59:56', '2015-04-11 08:10:27'),
(604, 1, 'cms_image:file_path', '2015-04-11 07:31:39', '2015-04-11 08:10:27'),
(605, 1, 'cms_image:cms_image_group_id', '2015-04-11 07:32:42', '2015-04-11 08:10:27'),
(606, 1, 'cms_layout:max_container', '2015-04-11 07:44:14', '2015-04-11 08:10:27'),
(607, 1, 'cms_layout:path', '2015-04-11 07:45:32', '2015-04-11 08:10:27'),
(608, 1, 'cms_layout:view', '2015-04-11 07:45:57', '2015-04-11 08:10:27'),
(609, 1, 'cms_news:cms_news_group_id', '2015-04-11 07:54:05', '2015-04-11 08:10:27'),
(610, 1, 'cms_news:published_at', '2015-04-11 07:54:24', '2015-04-11 08:10:27'),
(611, 1, 'cms_news_i18n:content', '2015-04-11 08:02:01', '2015-04-11 08:10:27'),
(612, 1, 'cms_widget:path', '2015-04-11 08:09:04', '2015-04-11 08:10:27'),
(613, 1, 'cms_widget:arg', '2015-04-11 08:09:52', '2015-04-11 08:31:18'),
(614, 1, 'cms_widget:cms_widget_group_id', '2015-04-11 08:11:42', '2015-04-11 08:31:59'),
(615, 1, 'cms_simple_menu:position', '2015-04-11 08:16:56', '2015-04-11 08:31:59'),
(616, 1, 'cms_simple_menu:cms_simple_menu_group_id', '2015-04-11 08:20:16', '2015-04-11 08:31:59'),
(617, 1, 'cms_simple_menu:url', '2015-04-11 08:21:17', '2015-04-11 08:31:59'),
(618, 1, 'cms_page:cache_duration', '2015-04-11 08:26:11', '2015-04-11 08:31:59'),
(619, 1, 'cms_page:cms_layout_id', '2015-04-11 08:28:52', '2015-04-11 08:31:59'),
(620, 1, 'cms_page_i18n:slug', '2015-04-11 08:29:09', '2015-04-11 08:31:59'),
(621, 1, 'cms_page_i18n:html_title', '2015-04-11 08:30:12', '2015-04-11 08:31:59'),
(622, 1, 'cms_page_i18n:html_description', '2015-04-11 08:30:40', '2015-04-11 08:31:59'),
(623, 1, 'cms_page_i18n:html_keywords', '2015-04-11 08:31:43', '2015-04-11 08:31:59'),
(624, 1, 'message:message_group_id', '2015-04-11 08:39:13', '2015-04-11 08:39:13'),
(625, 1, 'message:source', '2015-04-11 08:39:26', '2015-04-11 08:39:26'),
(626, 1, 'message_i18n:translation', '2015-04-11 08:41:56', '2015-04-11 08:41:56'),
(627, 1, 'mail_template:mail_template_group_id', '2015-04-11 08:54:47', '2015-04-11 08:54:47'),
(628, 1, 'mail_template:html_mode', '2015-04-11 08:55:42', '2015-04-11 08:55:42'),
(629, 1, 'mail_template:sql_request', '2015-04-11 08:55:55', '2015-04-11 08:55:55'),
(630, 1, 'mail_template:sql_param', '2015-04-11 08:56:19', '2015-04-11 08:56:19'),
(631, 1, 'mail_template_i18n:object', '2015-04-11 08:57:46', '2015-04-11 08:57:46'),
(632, 1, 'mail_template_i18n:message', '2015-04-11 08:58:03', '2015-04-11 08:58:03'),
(633, 1, 'person:full_name', '2015-04-11 09:12:41', '2015-04-11 09:12:41'),
(634, 1, 'mail_send_role:id', '2015-04-11 09:14:11', '2015-04-11 09:14:11'),
(635, 2, 'login_form:username', '2015-04-11 09:25:14', '2015-04-11 09:25:14'),
(636, 1, 'person:first_name', '2015-04-12 05:28:34', '2015-04-12 05:28:34'),
(637, 1, 'person:last_name', '2015-04-12 05:28:46', '2015-04-12 05:28:46'),
(638, 1, 'person:email', '2015-04-12 05:29:05', '2015-04-12 05:29:05'),
(639, 1, 'user:password', '2015-04-12 05:31:51', '2015-04-12 05:31:51'),
(640, 1, 'user:password_repeat', '2015-04-12 05:33:45', '2015-04-12 05:33:45'),
(641, 1, 'user:status', '2015-04-12 05:34:08', '2015-04-12 05:34:08'),
(642, 1, 'user:active_password_reset', '2015-04-12 05:35:14', '2015-04-12 05:35:14'),
(643, 1, 'rbac_role:name', '2015-04-12 05:43:19', '2015-04-12 05:43:19'),
(644, 1, 'rbac_role:rule_path', '2015-04-12 05:43:33', '2015-04-12 05:44:27'),
(645, 1, 'rbac_permission:name', '2015-04-12 05:49:56', '2015-04-12 05:49:56'),
(646, 1, 'rbac_permission:rule_path', '2015-04-12 05:50:11', '2015-04-12 05:50:11'),
(647, 1, 'language_group_language:language_group_id', '2015-04-12 05:56:11', '2015-04-12 05:56:11'),
(648, 1, 'language_group_language:language_id', '2015-04-12 05:56:24', '2015-04-12 05:56:24'),
(649, 1, 'variable:variable_group_id', '2015-04-12 05:59:48', '2015-04-12 05:59:48'),
(650, 1, 'variable:name', '2015-04-12 06:00:04', '2015-06-03 05:51:12'),
(651, 1, 'variable:val', '2015-04-12 06:00:20', '2015-06-03 05:51:12'),
(652, 1, 'variable_group:code', '2015-04-12 06:03:59', '2015-06-03 05:51:12'),
(654, 1, 'generator_position', '2015-04-16 00:18:52', '2015-06-03 05:51:12'),
(655, 1, 'generator_column', '2015-04-16 00:22:20', '2015-06-03 05:51:12'),
(656, 1, 'generator_table', '2015-04-16 00:22:33', '2015-06-03 05:51:12'),
(657, 1, 'generator_type', '2015-04-16 00:23:34', '2015-06-03 05:51:12'),
(658, 1, 'generator_option', '2015-04-16 00:42:10', '2015-06-03 05:51:12'),
(659, 1, 'generator_related_column_displayed', '2015-04-16 00:42:35', '2015-06-03 05:51:12'),
(660, 2, 'navbar_product', '2015-05-04 10:16:47', '2015-05-04 10:16:47'),
(661, 2, 'navbar_product_list', '2015-05-04 10:42:51', '2015-05-04 10:42:51'),
(662, 2, 'navbar_product_add', '2015-05-04 10:44:47', '2015-05-04 10:44:47'),
(663, 2, 'product_variant_count', '2015-05-05 01:20:37', '2015-05-05 01:20:37'),
(664, 2, 'product_tab_product', '2015-05-05 01:44:56', '2015-05-05 01:44:56'),
(665, 2, 'product_tab_attribute', '2015-05-05 01:45:21', '2015-05-11 05:43:58'),
(666, 2, 'product_tab_description', '2015-05-05 01:45:43', '2015-05-11 05:43:58'),
(667, 2, 'product_tab_prices', '2015-05-05 01:46:28', '2015-05-11 05:43:58'),
(668, 2, 'product_tab_logistic', '2015-05-05 01:49:28', '2015-05-11 05:43:58'),
(669, 2, 'product_tab_cross_selling', '2015-05-05 01:50:02', '2015-05-11 05:43:58'),
(670, 2, 'product_tab_discount', '2015-05-05 01:50:20', '2015-05-11 05:43:58'),
(671, 2, 'product_tab_media', '2015-05-05 01:50:39', '2015-05-11 05:43:58'),
(672, 2, 'product_tab_variant_list', '2015-05-07 10:33:14', '2015-05-11 05:43:58'),
(673, 2, 'product_tab_variant_price', '2015-05-07 10:33:44', '2015-05-11 05:43:58'),
(674, 2, 'btn_reset', '2015-05-06 23:12:13', '2015-05-11 05:43:58'),
(675, 2, 'product_label_id', '2015-05-25 05:21:04', '2015-05-25 05:21:04'),
(676, 2, 'product_label_exclude_discount_code', '2015-05-25 05:21:29', '2015-05-25 05:21:29'),
(677, 2, 'product_label_force_secure', '2015-05-25 05:21:55', '2015-05-25 05:21:55'),
(678, 2, 'product_label_archived', '2015-05-25 05:22:16', '2015-05-25 05:22:16'),
(679, 2, 'product_label_top_product', '2015-05-25 05:22:34', '2015-05-25 05:22:34'),
(680, 2, 'product_label_exclude_from_google', '2015-05-25 05:23:02', '2015-05-25 05:23:02'),
(681, 2, 'product_label_link_brand_product', '2015-05-25 05:23:39', '2015-05-25 05:23:39'),
(682, 2, 'product_label_link_product_test', '2015-05-25 05:24:05', '2015-05-25 05:24:05'),
(683, 2, 'product_label_available', '2015-05-25 05:24:32', '2015-05-25 05:24:32'),
(684, 2, 'product_label_available_date', '2015-05-25 05:24:59', '2015-05-25 05:24:59'),
(685, 2, 'product_label_alternative_product', '2015-05-25 05:25:16', '2015-05-25 05:25:16'),
(686, 2, 'product_label_lidoli_category_id', '2015-05-25 05:25:42', '2015-05-25 05:25:42'),
(687, 2, 'product_label_brand_id', '2015-05-25 05:25:55', '2015-05-25 05:25:55'),
(688, 2, 'product_label_supplier_id', '2015-05-25 05:26:10', '2015-05-25 05:26:10'),
(689, 2, 'product_label_catalog_category_id', '2015-05-25 05:26:35', '2015-05-25 05:26:35'),
(690, 2, 'product_label_google_category_id', '2015-05-25 05:26:56', '2015-05-25 05:26:56'),
(691, 2, 'product_label_stats_category_id', '2015-05-25 05:27:18', '2015-05-25 05:27:18'),
(692, 2, 'product_label_accountant_category_id', '2015-05-25 05:27:39', '2015-05-25 05:27:39'),
(693, 2, 'product_label_base_price', '2015-05-25 05:28:01', '2015-05-25 05:28:01'),
(694, 2, 'product_label_is_pack', '2015-05-25 05:28:26', '2015-05-25 05:28:26'),
(695, 2, 'product_label_short_description', '2015-05-25 05:32:38', '2015-05-25 05:32:38'),
(696, 2, 'product_label_long_description', '2015-05-25 05:33:01', '2015-06-09 10:10:01'),
(697, 2, 'product_label_comment', '2015-05-25 05:51:43', '2015-06-09 10:10:01'),
(698, 2, 'product_label_page_title', '2015-05-25 05:52:01', '2015-06-09 10:10:01'),
(699, 2, 'product_label_name', '2015-05-25 05:52:18', '2015-06-09 10:10:01'),
(700, 2, 'product_label_infos_shipping', '2015-05-25 05:52:57', '2015-06-09 10:10:01'),
(701, 2, 'product_label_meta_description', '2015-05-25 05:53:18', '2015-06-09 10:10:01'),
(702, 2, 'product_label_meta_keywords', '2015-05-25 06:29:12', '2015-06-09 10:10:01'),
(703, 2, 'navbar_brand_list', '2015-06-03 04:53:44', '2015-06-09 10:10:01'),
(704, 2, 'navbar_supplier_list', '2015-06-03 04:54:14', '2015-06-09 10:10:01'),
(705, 2, 'navbar_category_list', '2015-06-03 04:54:48', '2015-06-09 10:10:01'),
(706, 2, 'navbar_customer', '2015-06-10 23:19:32', '2015-06-10 23:19:32'),
(707, 2, 'navbar_third', '2015-06-10 23:20:14', '2015-06-10 23:20:14'),
(708, 2, 'navbar_third_role', '2015-06-10 23:20:53', '2015-06-10 23:20:53'),
(709, 2, 'navbar_person_gender', '2015-06-10 23:21:35', '2015-06-10 23:21:35'),
(710, 2, 'navbar_company_type', '2015-06-10 23:22:08', '2015-06-10 23:22:08'),
(711, 2, 'navbar_company_contact', '2015-06-10 23:23:18', '2015-06-10 23:23:18'),
(712, 2, 'navbar_address_type', '2015-06-10 23:23:57', '2015-06-10 23:23:57'),
(713, 2, 'third_role_i18n_title', '2015-06-10 23:24:51', '2015-06-10 23:24:51'),
(714, 2, 'company:company_type', '2015-06-10 23:26:14', '2015-06-10 23:26:14'),
(715, 2, 'company:name', '2015-06-10 23:26:41', '2015-06-10 23:26:41'),
(716, 2, 'company:intra_number', '2015-06-10 23:27:06', '2015-06-10 23:27:06'),
(717, 2, 'company:naf', '2015-06-10 23:27:21', '2015-06-10 23:27:21'),
(718, 2, 'company:siren', '2015-06-10 23:27:39', '2015-06-10 23:27:39'),
(719, 2, 'model:note', '2015-06-10 23:27:59', '2015-06-10 23:27:59'),
(720, 1, 'btn_view', '2015-06-10 23:28:32', '2015-06-12 06:43:06'),
(721, 2, 'information_box', '2015-06-10 23:35:15', '2015-06-10 23:41:48'),
(722, 2, 'btn_add_society', '2015-06-10 23:36:54', '2015-06-10 23:41:48'),
(723, 2, 'btn_generate_premium', '2015-06-10 23:37:37', '2015-06-10 23:41:48'),
(724, 2, 'address_tab', '2015-06-10 23:38:25', '2015-06-10 23:41:48'),
(725, 2, 'finance_tab', '2015-06-10 23:39:01', '2015-06-10 23:41:48'),
(726, 2, 'premium_tab', '2015-06-10 23:39:17', '2015-06-10 23:41:48'),
(727, 2, 'society_tab', '2015-06-10 23:39:37', '2015-06-10 23:41:48'),
(728, 2, 'contact_tab', '2015-06-10 23:40:01', '2015-06-10 23:41:48'),
(729, 2, 'Society_list', '2015-06-10 23:40:32', '2015-06-10 23:41:48'),
(730, 2, 'address_type_i18n_title', '2015-06-10 23:41:12', '2015-06-10 23:41:48'),
(731, 2, 'third:modal_create_third', '2015-06-10 23:48:08', '2015-06-10 23:48:08'),
(732, 2, 'third:modal_select_person', '2015-06-10 23:49:25', '2015-06-10 23:49:25'),
(733, 2, 'third:modal_select_company', '2015-06-10 23:50:11', '2015-06-10 23:50:11'),
(734, 2, 'person:first_name', '2015-06-10 23:50:50', '2015-06-10 23:50:50'),
(735, 2, 'person:last_name', '2015-06-10 23:51:07', '2015-06-10 23:51:07'),
(736, 2, 'person:email', '2015-06-10 23:51:32', '2015-06-10 23:51:32'),
(737, 2, 'person:default_language', '2015-06-10 23:52:01', '2015-06-10 23:52:01'),
(738, 2, 'person:user_id', '2015-06-10 23:52:31', '2015-06-10 23:52:31'),
(739, 2, 'person:gender_id', '2015-06-10 23:52:45', '2015-06-10 23:52:45'),
(740, 2, 'person:phone_1', '2015-06-10 23:53:20', '2015-06-10 23:53:20'),
(741, 2, 'person:phone_2', '2015-06-10 23:53:51', '2015-06-10 23:53:51'),
(742, 2, 'person:fax_number', '2015-06-10 23:54:07', '2015-06-10 23:54:07'),
(743, 2, 'person:website', '2015-06-10 23:54:25', '2015-06-10 23:54:25'),
(744, 2, 'person:birthday', '2015-06-10 23:54:49', '2015-06-10 23:54:49'),
(745, 2, 'person:skype', '2015-06-10 23:56:31', '2015-06-10 23:56:31'),
(746, 2, 'model:id', '2015-06-12 07:04:46', '2015-06-12 07:04:46'),
(747, 2, 'address:third_id', '2015-06-12 07:05:32', '2015-06-12 07:05:32'),
(748, 2, 'address:address_type_id', '2015-06-12 07:05:53', '2015-06-12 07:05:53'),
(749, 2, 'address:label', '2015-06-12 07:06:56', '2015-06-12 07:06:56'),
(750, 2, 'address:place_1', '2015-06-12 07:07:27', '2015-06-12 07:07:27'),
(751, 2, 'address:place_2', '2015-06-12 07:07:54', '2015-06-12 07:07:54'),
(752, 2, 'address:street_number', '2015-06-12 07:08:25', '2015-06-12 07:08:25'),
(753, 2, 'address:door_code', '2015-06-12 07:08:47', '2015-06-12 07:08:47'),
(754, 2, 'address:zip_code', '2015-06-12 07:09:02', '2015-06-12 07:09:02'),
(755, 2, 'address:city', '2015-06-12 07:09:28', '2015-06-12 07:09:28'),
(756, 2, 'address:country', '2015-06-12 07:09:44', '2015-06-12 07:09:44'),
(757, 2, 'address:primary', '2015-06-12 07:10:30', '2015-06-12 07:10:30'),
(758, 2, 'category_i18n_title', '2015-07-15 09:00:21', '2015-07-15 09:00:21'),
(759, 2, 'media_i18n_title', '2015-07-15 09:03:25', '2015-07-15 09:03:25'),
(760, 2, 'category_i18n_description', '2015-07-15 09:03:44', '2015-07-15 09:03:44');

-- --------------------------------------------------------

--
-- Structure de la table `message_group`
--

CREATE TABLE IF NOT EXISTS `message_group` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `message_group`
--

INSERT INTO `message_group` (`id`, `created_at`, `updated_at`) VALUES
(1, '2014-06-28 10:37:52', '2015-03-28 11:31:26'),
(2, '2013-01-11 11:03:27', '2015-04-10 05:34:19'),
(3, '2014-08-02 09:29:12', '2015-04-11 03:55:23');

-- --------------------------------------------------------

--
-- Structure de la table `message_group_i18n`
--

CREATE TABLE IF NOT EXISTS `message_group_i18n` (
  `message_group_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `message_group_i18n`
--

INSERT INTO `message_group_i18n` (`message_group_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Kalibao'),
(1, 'fr', 'Kalibao'),
(2, 'en', 'Kalibao : Backend'),
(2, 'fr', 'Kalibao : Backend'),
(3, 'en', 'Kalibao : Frontend'),
(3, 'fr', 'Kalibao : Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `message_i18n`
--

CREATE TABLE IF NOT EXISTS `message_i18n` (
  `message_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '',
  `translation` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `message_i18n`
--

INSERT INTO `message_i18n` (`message_id`, `i18n_id`, `translation`) VALUES
(11, 'en', 'French'),
(11, 'fr', 'Français'),
(12, 'en', 'English'),
(12, 'fr', 'Anglais'),
(13, 'en', 'German'),
(13, 'fr', 'Allemand'),
(14, 'en', 'Settings'),
(14, 'fr', 'Paramètres'),
(15, 'en', 'Variables'),
(15, 'fr', 'Variables'),
(17, 'en', 'Save'),
(17, 'fr', 'Enregistrer'),
(18, 'en', 'Add'),
(18, 'fr', 'Ajouter'),
(19, 'en', 'Add again'),
(19, 'fr', 'Ajouter à nouveau'),
(20, 'en', 'Close'),
(20, 'fr', 'Fermer'),
(22, 'en', 'Advanced search'),
(22, 'fr', 'Recherche avançée'),
(23, 'en', 'Informations has been saved'),
(23, 'fr', 'Les informations ont bien été enregistrées'),
(24, 'en', 'Advanced search'),
(24, 'fr', 'Recherche avançée'),
(25, 'en', 'Find'),
(25, 'fr', 'Rechercher'),
(29, 'en', 'Search'),
(29, 'fr', 'Rechercher'),
(30, 'en', 'Language'),
(30, 'fr', 'Langue'),
(34, 'en', 'Log In'),
(34, 'fr', 'Connexion'),
(36, 'en', 'Check all'),
(36, 'fr', 'Tout cocher'),
(38, 'en', 'Uncheck all'),
(38, 'fr', 'Tout décocher'),
(42, 'en', 'Remove'),
(42, 'fr', 'Supprimer'),
(43, 'en', 'List'),
(43, 'fr', 'Liste'),
(44, 'en', 'Settings'),
(44, 'fr', 'Préférences'),
(45, 'en', 'Translate'),
(45, 'fr', 'Traduction'),
(46, 'en', 'Select'),
(46, 'fr', 'Sélectionner'),
(47, 'en', 'Unfiltered'),
(47, 'fr', 'Non filtré'),
(48, 'en', 'Checked'),
(48, 'fr', 'Coché'),
(49, 'en', 'Unchecked'),
(49, 'fr', 'Décoché'),
(51, 'en', 'Roles'),
(51, 'fr', 'Rôles'),
(61, 'en', 'You must enter a new password'),
(61, 'fr', 'Vous devez saisir un nouveau mot de passe'),
(65, 'en', 'Email already exist'),
(65, 'fr', 'L''adresse email est déjà utilisé'),
(71, 'en', 'I''m log in'),
(71, 'fr', 'Je me connecte'),
(74, 'en', 'Keep me logged in'),
(74, 'fr', 'Garder ma session active'),
(76, 'en', 'You has not confirmed your registration'),
(76, 'fr', 'Votre inscription n''a pas été confirmé'),
(81, 'en', 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.'),
(81, 'fr', 'Merci de saisir les lettres affichées dans l''image ci-dessus. Les lettres sont insensible à la casse'),
(96, 'en', 'Update'),
(96, 'fr', 'Modifier'),
(99, 'en', 'Rights'),
(99, 'fr', 'Liste des droits'),
(102, 'en', 'Select an interface'),
(102, 'fr', 'Sélectionner une interface'),
(145, 'en', 'Create'),
(145, 'fr', 'Création'),
(146, 'en', 'Update'),
(146, 'fr', 'Mise à jour'),
(160, 'en', 'Media'),
(160, 'fr', 'Médias'),
(162, 'en', 'Messages'),
(162, 'fr', 'Messages'),
(163, 'en', 'Rights'),
(163, 'fr', 'Droits'),
(164, 'en', 'Languages'),
(164, 'fr', 'Langues'),
(165, 'en', 'Emails'),
(165, 'fr', 'Mails'),
(178, 'en', 'Warning !'),
(178, 'fr', 'Attention !'),
(186, 'en', 'Send'),
(186, 'fr', 'Envoyer'),
(189, 'en', 'Cancel'),
(189, 'fr', 'Annuler'),
(190, 'en', 'Export'),
(190, 'fr', 'Exporter'),
(191, 'en', 'No results'),
(191, 'fr', 'Aucun résultat'),
(192, 'en', 'Advanced search'),
(192, 'fr', 'Recherche avançée'),
(194, 'en', 'Users'),
(194, 'fr', 'Utilisateurs'),
(195, 'en', 'Settings'),
(195, 'fr', 'Paramètres'),
(196, 'en', 'Paging'),
(196, 'fr', 'Pagination'),
(197, 'en', 'Mail templates'),
(197, 'fr', 'Modèles de mail'),
(198, 'en', 'Groups of mail templates'),
(198, 'fr', 'Groupes de modèles de mail'),
(199, 'en', 'Sending roles'),
(199, 'fr', 'Rôles d''envoie des mails'),
(209, 'en', 'Groups of variables'),
(209, 'fr', 'Groupes de variables'),
(211, 'en', 'Groups of messages'),
(211, 'fr', 'Groupes de messages'),
(213, 'en', 'Role'),
(213, 'fr', 'Rôles'),
(214, 'en', 'Assigning permissions'),
(214, 'fr', 'Affectation des  permissions'),
(215, 'en', 'Auto login'),
(215, 'fr', 'Connexions automatiques'),
(217, 'en', 'Roles'),
(217, 'fr', 'Rôles'),
(219, 'en', 'Website language'),
(219, 'fr', 'Langues du site'),
(220, 'en', 'Languages'),
(220, 'fr', 'Langues'),
(227, 'en', 'Default language'),
(227, 'fr', 'Langue par défaut'),
(230, 'en', 'Log out'),
(230, 'fr', 'Déconnexion'),
(236, 'en', 'Sign in'),
(236, 'fr', 'Identification'),
(237, 'en', 'Update'),
(237, 'fr', 'Modifier'),
(238, 'en', 'Edit'),
(238, 'fr', 'Editer'),
(239, 'en', 'Remove'),
(239, 'fr', 'Supprimer'),
(240, 'en', 'Translate'),
(240, 'fr', 'Traduire'),
(243, 'en', 'Confirm'),
(243, 'fr', 'Confirmer'),
(244, 'en', 'Do you want to remove the selected rows ?'),
(244, 'fr', 'Voulez-vous supprimer les lignes sélectionnées ?'),
(245, 'en', 'Do you want to remove this item ?'),
(245, 'fr', 'Voulez-vous supprimer cet élément ?'),
(246, 'en', 'Email already exists'),
(246, 'fr', 'Cet email n''est pas disponible'),
(247, 'en', 'Advanced settings'),
(247, 'fr', 'Paramètres avançés'),
(248, 'en', 'Refresh database schema'),
(248, 'fr', 'Actualiser le schéma de la base de données'),
(249, 'en', 'Refresh database schema'),
(249, 'fr', 'Actualisation du schéma de la base de données'),
(250, 'en', 'The database schema has been refreshed'),
(250, 'fr', 'Le schéma de la base de données a bien été actualisé.'),
(251, 'en', 'My profile'),
(251, 'fr', 'Mon Profil'),
(252, 'en', 'My profile'),
(252, 'fr', 'Mon Profil'),
(253, 'en', 'Create at'),
(253, 'fr', 'Date de création'),
(254, 'en', 'Update at'),
(254, 'fr', 'Date de mise à jour'),
(261, 'en', 'Rights interfaces'),
(261, 'fr', 'Droits par interfaces'),
(263, 'en', 'Id'),
(263, 'fr', 'Identifiant'),
(277, 'en', 'Assigning permissions to roles'),
(277, 'fr', 'Affectation des  permissions aux rôles'),
(278, 'en', 'Auto login'),
(278, 'fr', 'Connexions automatiques'),
(283, 'en', 'Interfaces'),
(283, 'fr', 'Interfaces'),
(285, 'en', 'Roles'),
(285, 'fr', 'Rôles'),
(287, 'en', 'Actions'),
(287, 'fr', 'Actions'),
(291, 'en', 'Name'),
(291, 'fr', 'Nom'),
(295, 'en', 'Welcome to your administration area'),
(295, 'fr', 'Bienvenue sur votre espace d''administration'),
(298, 'en', 'Between'),
(298, 'fr', 'Entre'),
(299, 'en', 'and'),
(299, 'fr', 'et'),
(300, 'en', 'Add'),
(300, 'fr', 'Ajouter'),
(302, 'en', 'Cache management'),
(302, 'fr', 'Gestion du cache'),
(304, 'en', 'Translate messages'),
(304, 'fr', 'Traduire tous les messages'),
(307, 'en', 'Create'),
(307, 'fr', 'Ajouter'),
(311, 'en', 'Update'),
(311, 'fr', 'Modifier'),
(316, 'en', 'group of persons'),
(316, 'fr', 'groupe de personnes'),
(318, 'en', 'Bad login or password'),
(318, 'fr', 'Mauvais identifiant ou mot de passe'),
(321, 'en', 'Your account is not activated'),
(321, 'fr', 'Votre compte utilisateur a été désactivé'),
(322, 'en', 'Email doesn''t exist'),
(322, 'fr', 'L''adresse email n''existe pas'),
(323, 'en', 'An email has been sent to you in order to reset your password'),
(323, 'fr', 'Un email vous a été envoyé afin de réinitialiser votre mot de passe'),
(324, 'en', 'The old password is not valid'),
(324, 'fr', 'L''ancien mot de passe n''est pas valide'),
(326, 'en', 'The password can''t be reset. To renew your request please to follow the link bellow <br /> <br /> {link}'),
(326, 'fr', 'Le mot de passe ne peut pas être réinitialisé. Pour effectuer une nouvelle demande, merci de cliquer sur le lien ci-dessous <br /> {link}'),
(327, 'en', 'Reset password'),
(327, 'fr', 'Réinitialisation du mot de passe'),
(328, 'en', 'Reset your password'),
(328, 'fr', 'Réinitialiser votre mot de passe'),
(329, 'en', 'The password of this account can''t be reset'),
(329, 'fr', 'Le mot de passe de ce compte utilisateur ne peut être réinitialisé'),
(334, 'en', 'Container number'),
(334, 'fr', 'Bloc numéro'),
(335, 'en', 'Cache is updated'),
(335, 'fr', 'Le cache a été mis à jour'),
(336, 'en', 'An error occured. Cache isn''t updated'),
(336, 'fr', 'Le cache n''a pas pu être mis à jour.'),
(337, 'en', 'CMS'),
(337, 'fr', 'CMS'),
(338, 'en', 'Pages'),
(338, 'fr', 'Pages'),
(339, 'en', 'Editorials'),
(339, 'fr', 'Editoriaux'),
(340, 'en', 'Layouts'),
(340, 'fr', 'Modèles de pages'),
(341, 'en', 'Groups of editorials'),
(341, 'fr', 'Groupes d''éditoriaux'),
(342, 'en', 'Widgets'),
(342, 'fr', 'Widgets'),
(343, 'en', 'Images'),
(343, 'fr', 'Images'),
(345, 'en', 'Activated'),
(345, 'fr', 'Activé'),
(346, 'en', 'Validated'),
(346, 'fr', 'Validé'),
(356, 'en', 'Refresh the cache of all pages'),
(356, 'fr', 'Rafrachir le cache des pages'),
(357, 'en', 'Refresh page cache'),
(357, 'fr', 'Rafraichir le cache de la page'),
(361, 'en', 'Title'),
(361, 'fr', 'Titre'),
(367, 'en', 'Description'),
(367, 'fr', 'Description'),
(392, 'en', 'Code already exist'),
(392, 'fr', 'Le code de traduction est déjà utilisé'),
(398, 'en', 'Create an user account'),
(398, 'fr', 'Créer un compte utilisateur'),
(399, 'en', 'Update the user account'),
(399, 'fr', 'Modifier le compte utilisateur'),
(401, 'en', 'Translate'),
(401, 'fr', 'Traduire'),
(403, 'en', 'This slug already exist'),
(403, 'fr', 'Ce slug est déjà utilisé'),
(405, 'en', 'Create a variable'),
(405, 'fr', 'Ajouter une variable'),
(406, 'en', 'Update the variable'),
(406, 'fr', 'Modifier la variable'),
(407, 'en', 'Groups of variables'),
(407, 'fr', 'Groupes de variables'),
(408, 'en', 'Create a group of variable'),
(408, 'fr', 'Ajouter un groupe de variables'),
(409, 'en', 'Update the group of variables'),
(409, 'fr', 'Modifier le groupe de variables'),
(410, 'en', 'Users'),
(410, 'fr', 'Utilisateurs'),
(411, 'en', 'Create an user'),
(411, 'fr', 'Ajouter un utilisateur'),
(412, 'en', 'Update the user informations'),
(412, 'fr', 'Modifier les informations de l''utilisateur'),
(413, 'en', 'Groups of users'),
(413, 'fr', 'Groupes d''utilisateurs'),
(414, 'en', 'Create a group of users'),
(414, 'fr', 'Ajouter un groupe d''utilisateurs'),
(415, 'en', 'Update the group of users'),
(415, 'fr', 'Modifier le groupe d''utilisateurs'),
(416, 'en', 'Create a role'),
(416, 'fr', 'Ajouter un rôle'),
(417, 'en', 'Update the role'),
(417, 'fr', 'Modifier le rôle'),
(418, 'en', 'Auto login'),
(418, 'fr', 'Connexions automatiques'),
(419, 'en', 'Variables'),
(419, 'fr', 'Variables'),
(420, 'en', 'Website languages'),
(420, 'fr', 'Langues du site'),
(422, 'en', 'Add a website language'),
(422, 'fr', 'Ajouter une langue de site web'),
(423, 'en', 'Update the website language'),
(423, 'fr', 'Modifier la langue du site'),
(425, 'en', 'Languages'),
(425, 'fr', 'Langues'),
(426, 'en', 'Add a language'),
(426, 'fr', 'Ajouter une langue'),
(427, 'en', 'Update the language'),
(427, 'fr', 'Modifier la langue'),
(428, 'en', 'Messages'),
(428, 'fr', 'Message'),
(429, 'en', 'Create a message'),
(429, 'fr', 'Ajouter un message'),
(430, 'en', 'Update the message'),
(430, 'fr', 'Modifier le message'),
(431, 'en', 'Groups of messages'),
(431, 'fr', 'Groupes de messages'),
(432, 'en', 'Create a group of messages'),
(432, 'fr', 'Ajouter un groupe de messages'),
(433, 'en', 'Update the group of messages'),
(433, 'fr', 'Modifier le groupe de messages'),
(434, 'en', 'Mail templates'),
(434, 'fr', 'Modèles de mail'),
(435, 'en', 'Create a mail template'),
(435, 'fr', 'Ajouter un modèle de mail'),
(436, 'en', 'Update the mail template'),
(436, 'fr', 'Modifier le modèle de mail'),
(437, 'en', 'Sending roles'),
(437, 'fr', 'Rôles d''envoi du mail'),
(438, 'en', 'Create a sending role'),
(438, 'fr', 'Ajouter un rôle d''envoi du mail'),
(439, 'en', 'Group of mail templates'),
(439, 'fr', 'Groupe de modèles de mail'),
(440, 'en', 'Create a group of email templates'),
(440, 'fr', 'Ajouter un groupe de modèles de mail'),
(441, 'en', 'Update the group of mail templates'),
(441, 'fr', 'Modifier le groupe de modèles de mail'),
(442, 'en', 'Pages'),
(442, 'fr', 'Pages'),
(443, 'en', 'Create a page'),
(443, 'fr', 'Ajouter une page'),
(444, 'en', 'Update the page'),
(444, 'fr', 'Modifier la page'),
(445, 'en', 'Layouts'),
(445, 'fr', 'Modèles de page'),
(446, 'en', 'Create a layout'),
(446, 'fr', 'Ajouter un modèle de page'),
(447, 'en', 'Update the layout'),
(447, 'fr', 'Modifier le modèle de page'),
(448, 'en', 'Editorials'),
(448, 'fr', 'Editoriaux'),
(449, 'en', 'Create an editorial'),
(449, 'fr', 'Ajouter un éditorial'),
(450, 'en', 'Update the editorial'),
(450, 'fr', 'Modifier l''éditorial'),
(452, 'en', 'Create a group of editorials'),
(452, 'fr', 'Ajouter un groupe d''éditoriaux'),
(453, 'en', 'Update the group of editorials'),
(453, 'fr', 'Modifier le groupe d''éditoriaux'),
(454, 'en', 'Widgets'),
(454, 'fr', 'Widgets'),
(455, 'en', 'Add a widget'),
(455, 'fr', 'Ajouter un widget'),
(456, 'en', 'Update the widget'),
(456, 'fr', 'Modifier le widget'),
(457, 'en', 'Images'),
(457, 'fr', 'Images'),
(458, 'en', 'Add an image'),
(458, 'fr', 'Ajouter une image'),
(459, 'en', 'Update the image'),
(459, 'fr', 'Modifier l''image'),
(460, 'en', 'Upload'),
(460, 'fr', 'Télécharger'),
(461, 'en', 'Update the sending role'),
(461, 'fr', 'Modifier le rôle d''envoi du mail'),
(462, 'en', 'Maximum size'),
(462, 'fr', 'Taille maximum'),
(463, 'en', 'Update'),
(463, 'fr', 'Modifier'),
(464, 'en', 'Insert image'),
(464, 'fr', 'Insérer l''image'),
(466, 'en', 'Social networks'),
(466, 'fr', 'Réseaux sociaux'),
(467, 'en', 'Update the social network'),
(467, 'fr', 'Modifier le réseau social'),
(476, 'en', 'Albums'),
(476, 'fr', 'Albums'),
(477, 'en', 'Albums'),
(477, 'fr', 'Albums'),
(478, 'en', 'Add an album'),
(478, 'fr', 'Ajouter un album'),
(479, 'en', 'Update the album'),
(479, 'fr', 'Modifier l''album'),
(480, 'en', 'Photos of album "{name}"'),
(480, 'fr', 'Photos de l''album "{name}"'),
(481, 'en', 'Add a photo in album  "{name}"'),
(481, 'fr', 'Ajouter une photo dans l''album "{name}"'),
(482, 'en', 'Update the photo of album  "{name}"'),
(482, 'fr', 'Modifier la photo de l''album "{name}"'),
(483, 'en', 'Add photos'),
(483, 'fr', 'Ajouter des photos'),
(485, 'en', 'View album photos'),
(485, 'fr', 'Afficher les photos de l''album'),
(486, 'en', 'Insert image (small)'),
(486, 'fr', 'Insérer l''image (petite)'),
(487, 'en', 'Insert image (large)'),
(487, 'fr', 'Insérer l''image (grande)'),
(493, 'en', 'News'),
(493, 'fr', 'Actualités'),
(494, 'en', 'Add news'),
(494, 'fr', 'Ajouter une nouvelle'),
(495, 'en', 'Update the news'),
(495, 'fr', 'Modifier la nouvelle'),
(496, 'en', 'Add newsgroup'),
(496, 'fr', 'Ajouter un groupe d''actualités'),
(497, 'en', 'Update the newsgroup'),
(497, 'fr', 'Modifier le groupe d''actualités'),
(498, 'en', 'Newsgroups'),
(498, 'fr', 'Groupes  d''actualités'),
(499, 'en', 'Groups of editorials'),
(499, 'fr', 'Groupes d''éditoriaux'),
(500, 'en', 'News'),
(500, 'fr', 'Actualités'),
(503, 'en', 'Newsgroups'),
(503, 'fr', 'Groupes d''actualités'),
(504, 'en', 'Menus'),
(504, 'fr', 'Menus'),
(505, 'en', 'Groups of menus'),
(505, 'fr', 'Groupes de menus'),
(506, 'en', 'Menus'),
(506, 'fr', 'Menus'),
(507, 'en', 'Add a menu'),
(507, 'fr', 'Ajouter un menu'),
(508, 'en', 'Update the menu'),
(508, 'fr', 'Modifier le menu'),
(509, 'en', 'Groups of menus'),
(509, 'fr', 'Groupes de menus'),
(511, 'en', 'Add a group of menus'),
(511, 'fr', 'Ajouter un groupe de menus'),
(512, 'en', 'Update the group of menus'),
(512, 'fr', 'Modifier le groupe de menus'),
(516, 'en', 'Refresh urls cache'),
(516, 'fr', 'Rafraichir le cache des urls'),
(517, 'en', 'Refresh urls cache'),
(517, 'fr', 'Rafraichir le cache des urls'),
(518, 'en', 'Urls cache is refreshed'),
(518, 'fr', 'Le cache des urls a été mise à jour'),
(524, 'en', 'Your email has been sent'),
(524, 'fr', 'Votre email a bien été envoyé'),
(526, 'en', 'Spanish'),
(526, 'fr', 'Espagnol'),
(530, 'en', 'The mail template translation doesn''t exists'),
(530, 'fr', 'La traduction du modèle de mail n''a pas été trouvé'),
(543, 'en', 'Select a group of languages'),
(543, 'fr', 'Sélectionner un groupe de langues'),
(544, 'en', 'Start'),
(544, 'fr', 'Début'),
(545, 'en', 'End'),
(545, 'fr', 'Fin'),
(546, 'en', 'Activated'),
(546, 'fr', 'Activé'),
(547, 'en', 'Disabled'),
(547, 'fr', 'Désactivé'),
(548, 'en', 'Update rôles'),
(548, 'fr', 'Modifier les rôles'),
(549, 'en', 'The SQL request of mail template has aground.'),
(549, 'fr', 'La requête SQL du modèle du mail a échoué.'),
(550, 'en', 'Module is now build'),
(550, 'fr', 'Le module a bien été généré'),
(551, 'en', 'Warning !During saving the users rights will be refreshed. The website performances could be affected.'),
(551, 'fr', 'Attention ! lors de l''enregistrement, les droits des utilisateurs seront actualisés. Les performances du sites peuvent être affectés.'),
(552, 'en', 'Create a group of images'),
(552, 'fr', 'Créer un groupe d''images'),
(553, 'en', 'Update a group of images'),
(553, 'fr', 'Modifier un groupe d''images'),
(554, 'en', 'Images group'),
(554, 'fr', 'Groupes d''images'),
(555, 'en', 'Create a language'),
(555, 'fr', 'Ajouter une langue'),
(556, 'en', 'Update language'),
(556, 'fr', 'Modifier la langue'),
(557, 'en', 'Languages'),
(557, 'fr', 'Langues'),
(558, 'en', 'Create a language group'),
(558, 'fr', 'Ajouter un groupe de langue'),
(559, 'en', 'Update language group'),
(559, 'fr', 'Modifier le groupe de langue'),
(560, 'en', 'Language groups'),
(560, 'fr', 'Groupes de langue'),
(561, 'en', 'Add language in group'),
(561, 'fr', 'Ajouter une langue dans un groupe'),
(562, 'en', 'Update language group'),
(562, 'fr', 'Modifier le groupe de la langue'),
(563, 'en', 'Languages and their groups'),
(563, 'fr', 'Langues et leurs groupes'),
(564, 'en', 'Create user'),
(564, 'fr', 'Ajouter un utilisateur'),
(565, 'en', 'Update user'),
(565, 'fr', 'Modifier l''utilisateur'),
(566, 'en', 'Users'),
(566, 'fr', 'Utilisateurs'),
(567, 'en', 'Create permission'),
(567, 'fr', 'Ajouter une permission'),
(568, 'en', 'Update permission'),
(568, 'fr', 'Modifier la permission'),
(569, 'en', 'Permissions'),
(569, 'fr', 'Permissions'),
(570, 'en', 'Create role'),
(570, 'fr', 'Ajouter un rôle'),
(571, 'en', 'Update role'),
(571, 'fr', 'Modifier le rôle'),
(572, 'en', 'Roles'),
(572, 'fr', 'Rôles'),
(573, 'en', 'Create a group of widgets'),
(573, 'fr', 'Ajouter un groupe de widgets'),
(574, 'en', 'Update the group of widgets'),
(574, 'fr', 'Modifier le groupe de widgets'),
(575, 'en', 'Widget groups'),
(575, 'fr', 'Groupes de widgets'),
(577, 'en', 'Groups of images'),
(577, 'fr', 'Groupes d''images'),
(578, 'en', 'Groups of widgets'),
(578, 'fr', 'Groupes de widgets'),
(579, 'en', 'Groups of languages'),
(579, 'fr', 'Groupes de langues'),
(580, 'en', 'Languages and their groups'),
(580, 'fr', 'Langues et leurs groupes'),
(581, 'en', 'Permissions'),
(581, 'fr', 'Permissions'),
(582, 'en', 'Your browser is not compatible with this application. Please upgrade your browser.'),
(582, 'fr', 'Votre navigateur n''est pas compatible avec cette application. Merci de le mettre à jour.'),
(583, 'en', 'Dashboard'),
(583, 'fr', 'Tableau de bord'),
(584, 'en', 'Dashboard'),
(584, 'fr', 'Tableau de bord'),
(585, 'en', 'Select an other language'),
(585, 'fr', 'Changer de langue'),
(586, 'en', 'Password'),
(586, 'fr', 'Mot de passe'),
(587, 'en', 'Module generator'),
(587, 'fr', 'Générateur de module'),
(588, 'en', 'Simple menu'),
(588, 'fr', 'Menu simple'),
(589, 'en', 'Add a new menu'),
(589, 'fr', 'Ajouter un menu'),
(590, 'en', 'Update the menu'),
(590, 'fr', 'Modifier le menu'),
(591, 'en', 'Menu links'),
(591, 'fr', 'Liens du menu'),
(592, 'en', 'Add a link'),
(592, 'fr', 'Ajouter un lien'),
(593, 'en', 'Update the link'),
(593, 'fr', 'Modifier le lien'),
(594, 'en', 'Add / Update the menu links'),
(594, 'fr', 'Ajouter / Modifier les liens du menu'),
(595, 'en', 'Simple menu'),
(595, 'fr', 'Menu simple'),
(597, 'en', 'Name'),
(597, 'fr', 'Nom'),
(598, 'en', 'Email'),
(598, 'fr', 'Email'),
(599, 'en', 'Message'),
(599, 'fr', 'Message'),
(600, 'en', 'Phone'),
(600, 'fr', 'Téléphone'),
(601, 'en', 'Verify code'),
(601, 'fr', 'Code de vérification'),
(602, 'en', 'Your mail has not been sent'),
(602, 'fr', 'Votre email n''a pas pu être envoyé'),
(603, 'en', 'Roles'),
(603, 'fr', 'Rôles'),
(604, 'en', 'File'),
(604, 'fr', 'Fichier'),
(605, 'en', 'Group'),
(605, 'fr', 'Groupe'),
(606, 'en', 'Number of blocks'),
(606, 'fr', 'Nombre de blocs'),
(607, 'en', 'Layout path'),
(607, 'fr', 'Chemin du layout'),
(608, 'en', 'View path'),
(608, 'fr', 'Chemin de la vue'),
(609, 'en', 'Group'),
(609, 'fr', 'Groupe'),
(610, 'en', 'Published at'),
(610, 'fr', 'Date de publication'),
(611, 'en', 'Content'),
(611, 'fr', 'Contenu'),
(612, 'en', 'Path'),
(612, 'fr', 'Chemin'),
(613, 'en', 'Parameters'),
(613, 'fr', 'Paramètres'),
(614, 'en', 'Group'),
(614, 'fr', 'Groupe'),
(615, 'en', 'Position'),
(615, 'fr', 'Position'),
(616, 'en', 'Group'),
(616, 'fr', 'Groupe'),
(617, 'en', 'Url'),
(617, 'fr', 'Url'),
(618, 'en', 'Cache duration'),
(618, 'fr', 'Durée du cache'),
(619, 'en', 'Layout'),
(619, 'fr', 'Layout'),
(620, 'en', 'Slug'),
(620, 'fr', 'Slug'),
(621, 'en', 'Title (head)'),
(621, 'fr', 'Titre (head)'),
(622, 'en', 'Description (meta)'),
(622, 'fr', 'Description (meta)'),
(623, 'en', 'Keywords (meta)'),
(623, 'fr', 'Mots clefs (meta)'),
(624, 'en', 'Group'),
(624, 'fr', 'Groupe'),
(625, 'en', 'Source'),
(625, 'fr', 'Source'),
(626, 'en', 'Traduction'),
(626, 'fr', 'Translation'),
(627, 'en', 'Group'),
(627, 'fr', 'Groupe'),
(628, 'en', 'Html mode'),
(628, 'fr', 'Mode html'),
(629, 'en', 'SQL request'),
(629, 'fr', 'Requête SQL'),
(630, 'en', 'Request parameters'),
(630, 'fr', 'Paramètres de la requête'),
(631, 'en', 'Object'),
(631, 'fr', 'Objet'),
(632, 'en', 'Message'),
(632, 'fr', 'Message'),
(633, 'en', 'Person'),
(633, 'fr', 'Personne'),
(634, 'en', 'Type'),
(634, 'fr', 'Type'),
(635, 'en', 'Username'),
(635, 'fr', 'Nom d''utilisateur'),
(636, 'en', 'First name'),
(636, 'fr', 'Prénom'),
(637, 'en', 'Name'),
(637, 'fr', 'Nom'),
(638, 'en', 'Email'),
(638, 'fr', 'Email'),
(639, 'en', 'Password'),
(639, 'fr', 'Mot de passe'),
(640, 'en', 'Repeat password'),
(640, 'fr', 'Confirmer le mot de passe'),
(641, 'en', 'Status'),
(641, 'fr', 'Statut'),
(642, 'en', 'Active the password reset'),
(642, 'fr', 'Activer la réinitialisation du mot de passe'),
(643, 'en', 'Name'),
(643, 'fr', 'Nom'),
(644, 'en', 'Rule path'),
(644, 'fr', 'Chemin de la règle'),
(645, 'en', 'Name'),
(645, 'fr', 'Nom'),
(646, 'en', 'Rule path'),
(646, 'fr', 'Chemin de la règle'),
(647, 'en', 'Language groupe'),
(647, 'fr', 'Groupe de langue'),
(648, 'en', 'Language'),
(648, 'fr', 'Langue'),
(649, 'en', 'Group'),
(649, 'fr', 'Groupe'),
(650, 'en', 'Name'),
(650, 'fr', 'Nom'),
(651, 'en', 'Value'),
(651, 'fr', 'Valeur'),
(652, 'en', 'Code'),
(652, 'fr', 'Code'),
(654, 'en', 'Position'),
(654, 'fr', 'Position'),
(655, 'en', 'Column'),
(655, 'fr', 'Colonne'),
(656, 'en', 'Table'),
(656, 'fr', 'Table'),
(657, 'en', 'Type'),
(657, 'fr', 'Type'),
(658, 'en', 'Option'),
(658, 'fr', 'Option'),
(659, 'en', 'Column to displayed'),
(659, 'fr', 'Colonne à afficher'),
(660, 'en', 'Products'),
(660, 'fr', 'Produits'),
(661, 'en', 'Products list'),
(661, 'fr', 'Liste des produits'),
(662, 'en', 'Add a product'),
(662, 'fr', 'Ajouter un produit'),
(663, 'en', '{n, plural, =0{No variation} =1{1 variation} other{# variations}}'),
(663, 'fr', '{n, plural, =0{Pas de variation} =1{1 variation} other{# variations}}'),
(664, 'en', 'Product'),
(664, 'fr', 'Produit'),
(665, 'en', 'Attribute'),
(665, 'fr', 'Attribut'),
(666, 'en', 'Descriptions'),
(666, 'fr', 'Descriptions'),
(667, 'en', 'Prices & buy prices'),
(667, 'fr', 'Tarifs & prix d''achat'),
(668, 'en', 'Stock & logistic'),
(668, 'fr', 'Stock & logistique'),
(669, 'en', 'Cross selling'),
(669, 'fr', 'Cross selling'),
(670, 'en', 'Discounts'),
(670, 'fr', 'Promotions'),
(671, 'en', 'Medias'),
(671, 'fr', 'Médias'),
(672, 'en', 'Variant list'),
(672, 'fr', 'Liste des variations'),
(673, 'en', 'Variant prices'),
(673, 'fr', 'Prix des variations'),
(674, 'en', 'Reset'),
(674, 'fr', 'Annuler'),
(675, 'en', 'Product id'),
(675, 'fr', 'Id du produit'),
(676, 'en', 'Exclude from discount codes'),
(676, 'fr', 'Exclure des codes promos'),
(677, 'en', 'Force secure payment'),
(677, 'fr', 'Forcer le paiement sécurisé'),
(678, 'en', 'Archive product'),
(678, 'fr', 'Archiver le produit'),
(679, 'en', 'Top product'),
(679, 'fr', 'Top produit'),
(680, 'en', 'Exclude from Google index'),
(680, 'fr', 'Exclure de l''index Google'),
(681, 'en', 'Link to the product on the brand''s website'),
(681, 'fr', 'Lien vers le produit sur le site de la marque'),
(682, 'en', 'Link to the product test'),
(682, 'fr', 'Lien vers le test du produit'),
(683, 'en', 'Product available'),
(683, 'fr', 'Produit disponible'),
(684, 'en', 'Available date'),
(684, 'fr', 'Date de disponibilité'),
(685, 'en', 'Alternative product'),
(685, 'fr', 'Produit alternatif'),
(686, 'en', 'Lidoli category'),
(686, 'fr', 'Catégorie Lidoli'),
(687, 'en', 'Brand'),
(687, 'fr', 'Marque'),
(688, 'en', 'Supplier'),
(688, 'fr', 'Fournisseur'),
(689, 'en', 'Catalog category'),
(689, 'fr', 'Catégorie dans le catalogue'),
(690, 'en', 'Google category'),
(690, 'fr', 'Catégorie pour Google'),
(691, 'en', 'Statistic category'),
(691, 'fr', 'Catégorie statistique'),
(692, 'en', 'Accountant category'),
(692, 'fr', 'Catégorie comptable'),
(693, 'en', 'Base price'),
(693, 'fr', 'Prix de base'),
(694, 'en', 'Product is a bundle'),
(694, 'fr', 'Le produit est un pack'),
(695, 'en', 'Short description'),
(695, 'fr', 'Description courte'),
(696, 'en', 'Long description'),
(696, 'fr', 'Description longue'),
(697, 'en', 'Comment'),
(697, 'fr', 'Commentaire'),
(698, 'en', 'Page title'),
(698, 'fr', 'Titre de la page'),
(699, 'en', 'Product name'),
(699, 'fr', 'Nom du produit'),
(700, 'en', 'Information for shipping'),
(700, 'fr', 'Informations de livraison'),
(701, 'en', 'Description meta tag'),
(701, 'fr', 'Balise meta description'),
(702, 'en', 'Keywords meta tag'),
(702, 'fr', 'Balise meta Keywords'),
(703, 'en', 'Brands'),
(703, 'fr', 'Marques'),
(704, 'en', 'Suppliers'),
(704, 'fr', 'Fournisseurs'),
(705, 'en', 'Categories'),
(705, 'fr', 'Catégories'),
(706, 'en', 'Thirds'),
(706, 'fr', 'Tiers'),
(707, 'en', 'Third'),
(707, 'fr', 'Tier'),
(708, 'en', 'Thirds role'),
(708, 'fr', 'Type de tiers'),
(709, 'en', 'Person gender'),
(709, 'fr', 'Personne genre'),
(710, 'en', 'Company type'),
(710, 'fr', 'Type de Société'),
(711, 'en', 'Company''s contacts'),
(711, 'fr', 'Gestion des contacts'),
(712, 'en', 'Address type'),
(712, 'fr', 'Type d''adresse'),
(713, 'en', 'Third type'),
(713, 'fr', 'Type de tier'),
(714, 'en', 'Company type'),
(714, 'fr', 'Type de société'),
(715, 'en', 'Company''s name'),
(715, 'fr', 'Nom de la société'),
(716, 'en', 'Intra number'),
(716, 'fr', 'Numéro intra'),
(717, 'en', 'NAF'),
(717, 'fr', 'NAF'),
(718, 'en', 'SIREN'),
(718, 'fr', 'SIREN'),
(719, 'en', 'Some notes'),
(719, 'fr', 'Quelques notes'),
(720, 'en', 'View'),
(720, 'fr', 'Voir'),
(721, 'en', 'Informations'),
(721, 'fr', 'Informations'),
(722, 'en', 'Add Contact'),
(722, 'fr', 'Ajouter Contact'),
(723, 'en', 'Generate Premium'),
(723, 'fr', 'Générer Premium'),
(724, 'en', 'Address'),
(724, 'fr', 'Adresse'),
(725, 'en', 'Finance'),
(725, 'fr', 'Finance'),
(726, 'en', 'Premium'),
(726, 'fr', 'Premium'),
(727, 'en', 'Company'),
(727, 'fr', 'Société'),
(728, 'en', 'Contact'),
(728, 'fr', 'Contact'),
(729, 'en', 'Company'),
(729, 'fr', 'Société'),
(730, 'en', 'Address type'),
(730, 'fr', 'Type d''address'),
(731, 'en', 'Warrning ! You are going to create a third, once the role chosen you can''t  go back.'),
(731, 'fr', 'Attention ! Vous aller créer un tiers, une fois le type choisi vous ne pourrez revenir en arrière.'),
(732, 'en', 'Third role : PERSON'),
(732, 'fr', 'Tiers de type : PERSONNE'),
(733, 'en', 'Third role : COMPANY'),
(733, 'fr', 'Tiers de type : SOCIETE'),
(734, 'en', 'First name'),
(734, 'fr', 'Prenom'),
(735, 'en', 'Last name'),
(735, 'fr', 'Nom'),
(736, 'en', 'Email'),
(736, 'fr', 'Email'),
(737, 'en', 'Default language'),
(737, 'fr', 'Langue par default'),
(738, 'en', 'User name'),
(738, 'fr', 'Nom d''utilisateur'),
(739, 'en', 'Gender'),
(739, 'fr', 'Sexe'),
(740, 'en', 'Main phone number'),
(740, 'fr', 'Numéro de téléphone principal'),
(741, 'en', 'Second phone number'),
(741, 'fr', 'Numéro de téléphone secondaire'),
(742, 'en', 'Fax'),
(742, 'fr', 'Fax'),
(743, 'en', 'WebSite'),
(743, 'fr', 'Site internet'),
(744, 'en', 'Birthday'),
(744, 'fr', 'Anniversaire'),
(745, 'en', 'Skype'),
(745, 'fr', 'Skype'),
(746, 'en', 'Id'),
(746, 'fr', 'Identifiant'),
(747, 'en', 'Thirds'),
(747, 'fr', 'Tiers'),
(748, 'en', 'Address type'),
(748, 'fr', 'Type d''adresse'),
(749, 'en', 'Tilte (eg: Home)'),
(749, 'fr', 'Intitulé (ex: Maison)'),
(750, 'en', 'Address line 1'),
(750, 'fr', 'Adresse ligne 1'),
(751, 'en', 'Address line 2'),
(751, 'fr', 'Adresse ligne 2'),
(752, 'en', 'Street number'),
(752, 'fr', 'Numéro de rue'),
(753, 'en', 'Door code'),
(753, 'fr', 'Code de la porte'),
(754, 'en', 'Zip code'),
(754, 'fr', 'Code postal'),
(755, 'en', 'City'),
(755, 'fr', 'Ville'),
(756, 'en', 'Country'),
(756, 'fr', 'Pays'),
(757, 'en', 'Is it the main address ?'),
(757, 'fr', 'Es-ce l''adresse principale ?'),
(758, 'en', 'Desc'),
(758, 'fr', 'Intitulé'),
(759, 'en', 'Media'),
(759, 'fr', 'Media'),
(760, 'en', 'Long desc'),
(760, 'fr', 'Description');

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `third_id` bigint(20) unsigned NOT NULL COMMENT 'the person is a third',
  `first_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `default_language` varchar(16) COLLATE utf8_bin NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `gender_id` bigint(20) unsigned DEFAULT NULL COMMENT 'the gender of the person,',
  `phone_1` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `phone_2` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `fax` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `birthday` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `skype` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `person`
--

INSERT INTO `person` (`third_id`, `first_name`, `last_name`, `email`, `default_language`, `user_id`, `gender_id`, `phone_1`, `phone_2`, `fax`, `website`, `birthday`, `skype`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', 'admin@kalibao.com', 'fr', 1, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'Mika', 'Bern', 'a@a.com', 'en', 4, 6, '012345678', '', '', '', NULL, '', '2015-06-10 06:40:58', '2015-06-10 06:46:12'),
(42, 'Mika ', 'Test', 'b@b.B', 'fr', NULL, 6, '', '', '', '', NULL, '', '2015-06-18 23:11:02', '2015-06-18 23:11:02'),
(43, 'erf', 'fre', '1@2.fr', 'en', NULL, NULL, '', '', '', '', NULL, '', '2015-06-30 23:50:25', '2015-06-30 23:50:25');

-- --------------------------------------------------------

--
-- Structure de la table `person_gender`
--

CREATE TABLE IF NOT EXISTS `person_gender` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `person_gender`
--

INSERT INTO `person_gender` (`id`, `created_at`, `updated_at`) VALUES
(5, '2015-05-31 23:59:32', '2015-06-02 10:20:45'),
(6, '2015-06-02 10:20:29', '2015-06-02 10:20:29');

-- --------------------------------------------------------

--
-- Structure de la table `person_gender_i18n`
--

CREATE TABLE IF NOT EXISTS `person_gender_i18n` (
  `gender_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `person_gender_i18n`
--

INSERT INTO `person_gender_i18n` (`gender_id`, `i18n_id`, `title`) VALUES
(5, 'en', 'Woman'),
(5, 'fr', 'Femme'),
(6, 'en', 'Man'),
(6, 'fr', 'Homme');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the product',
  `exclude_discount_code` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : discount codes can''t be used on this product',
  `force_secure` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : payment for this product must be a secure payment',
  `archived` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : product is archived (not visible on the front office)',
  `top_product` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : emphasise the product as a top selling product',
  `exclude_from_google` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : exclude the product from google index',
  `link_brand_product` varchar(255) DEFAULT NULL COMMENT 'url for the product on the brand''s website',
  `link_product_test` varchar(255) DEFAULT NULL COMMENT 'url to the product test',
  `available` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 : the product is not yet available',
  `available_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date from which the product will be available',
  `alternative_product` bigint(20) unsigned DEFAULT NULL COMMENT 'id of an alternative productwhich can replace the current one',
  `lidoli_category_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned NOT NULL COMMENT 'id of the product''s brand',
  `supplier_id` bigint(20) unsigned NOT NULL COMMENT 'id of the product''s supplier',
  `catalog_category_id` bigint(20) unsigned NOT NULL COMMENT 'id of the catalog category in which the product is',
  `google_category_id` bigint(20) unsigned NOT NULL COMMENT 'id of the catalog category in which the product is for google bot',
  `stats_category_id` bigint(20) unsigned NOT NULL COMMENT 'id of the category in which the product is for statistics purposes',
  `accountant_category_id` bigint(20) unsigned NOT NULL COMMENT 'id of the category in which the product is for accountant purposes',
  `base_price` decimal(15,4) unsigned NOT NULL COMMENT 'base price of the product. extra cost for the attributes will be added to this price to determine the final price',
  `is_pack` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 : the product is a virtual product representing a bundle of products',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='products table contains all information common to all product variant';

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `exclude_discount_code`, `force_secure`, `archived`, `top_product`, `exclude_from_google`, `link_brand_product`, `link_product_test`, `available`, `available_date`, `alternative_product`, `lidoli_category_id`, `brand_id`, `supplier_id`, `catalog_category_id`, `google_category_id`, `stats_category_id`, `accountant_category_id`, `base_price`, `is_pack`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, 0, NULL, NULL, 0, '2015-06-01 00:00:00', NULL, 0, 1, 1, 1, 1, 1, 1, 166.6583, 0, '2015-06-10 08:29:11', '2015-06-23 11:39:51');

-- --------------------------------------------------------

--
-- Structure de la table `product_i18n`
--

CREATE TABLE IF NOT EXISTS `product_i18n` (
  `product_id` bigint(20) unsigned NOT NULL COMMENT 'id of the translated product',
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `short_description` varchar(2000) DEFAULT NULL COMMENT 'translation for the short description of the product',
  `long_description` varchar(7000) DEFAULT NULL COMMENT 'translation for the long description of the product',
  `comment` varchar(4000) DEFAULT NULL COMMENT 'translation for a comment used to provide additional information on the product',
  `page_title` varchar(750) DEFAULT NULL COMMENT 'translation for the title of the HTML page in front office',
  `name` varchar(500) NOT NULL COMMENT 'translation for the name of the product',
  `infos_shipping` varchar(5000) DEFAULT NULL COMMENT 'translation for additional information related to the shipping of the product',
  `meta_description` varchar(2000) DEFAULT NULL COMMENT 'translation for the description used for the HTML meta tag',
  `meta_keywords` varchar(500) DEFAULT NULL COMMENT 'translation for the keywords used for the HTML keyword tag'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for products';

--
-- Contenu de la table `product_i18n`
--

INSERT INTO `product_i18n` (`product_id`, `i18n_id`, `short_description`, `long_description`, `comment`, `page_title`, `name`, `infos_shipping`, `meta_description`, `meta_keywords`) VALUES
(1, 'fr', NULL, NULL, NULL, NULL, 'produit de test', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product_media`
--

CREATE TABLE IF NOT EXISTS `product_media` (
  `product_id` bigint(20) unsigned NOT NULL COMMENT 'id of the product',
  `media_id` bigint(20) unsigned NOT NULL COMMENT 'id of the media',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='relation table between product and media table';

-- --------------------------------------------------------

--
-- Structure de la table `rbac_permission`
--

CREATE TABLE IF NOT EXISTS `rbac_permission` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `rule_path` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `rbac_permission`
--

INSERT INTO `rbac_permission` (`id`, `name`, `rule_path`, `created_at`, `updated_at`) VALUES
(1, 'create:*', '', '2015-03-20 09:25:53', '2015-03-21 07:43:54'),
(2, 'update:*', '', '2015-03-20 09:26:06', '2015-03-21 07:43:44'),
(3, 'delete:*', '', '2015-03-20 09:26:42', '2015-03-21 07:43:41'),
(4, 'translate:*', '', '2015-03-20 09:26:57', '2015-03-21 07:43:38'),
(5, 'consult:*', '', '2015-03-20 09:28:07', '2015-04-08 05:24:31'),
(6, 'administrate:authorizations', '', '2015-03-21 07:45:49', '2015-04-08 05:24:23'),
(7, 'navigate:backend', '', '2015-03-22 00:34:05', '2015-04-08 05:24:09'),
(8, 'consult:kalibao\\backend\\modules\\rbac\\controllers\\RbacPermissionController', '', '2015-04-05 04:59:30', '2015-04-05 05:52:26'),
(9, 'create:kalibao\\backend\\modules\\rbac\\controllers\\RbacPermissionController', '', '2015-04-05 05:04:08', '2015-04-05 05:52:20'),
(10, 'delete:kalibao\\backend\\modules\\rbac\\controllers\\RbacPermissionController', '', '2015-04-05 05:05:04', '2015-04-05 05:52:12'),
(11, 'translate:kalibao\\backend\\modules\\rbac\\controllers\\RbacPermissionController', '', '2015-04-05 05:05:32', '2015-04-05 05:52:05'),
(12, 'update:kalibao\\backend\\modules\\rbac\\controllers\\RbacPermissionController', '', '2015-04-05 05:05:59', '2015-04-05 05:51:53'),
(13, 'consult:kalibao\\backend\\modules\\rbac\\controllers\\RbacRoleController', '', '2015-04-05 05:10:45', '2015-04-05 05:35:49'),
(14, 'update:kalibao\\backend\\modules\\rbac\\controllers\\RbacRoleController', '', '2015-04-05 05:11:03', '2015-04-05 05:35:40'),
(15, 'create:kalibao\\backend\\modules\\rbac\\controllers\\RbacRoleController', '', '2015-04-05 05:35:12', '2015-04-05 05:35:12'),
(16, 'translate:kalibao\\backend\\modules\\rbac\\controllers\\RbacRoleController', '', '2015-04-05 05:36:14', '2015-04-05 05:36:14'),
(17, 'delete:kalibao\\backend\\modules\\rbac\\controllers\\RbacRoleController', '', '2015-04-05 05:36:33', '2015-04-05 05:36:33'),
(18, 'create:kalibao\\backend\\modules\\rbac\\controllers\\PersonUserController', '', '2015-04-05 05:38:33', '2015-04-05 05:38:33'),
(19, 'update:kalibao\\backend\\modules\\rbac\\controllers\\PersonUserController', '', '2015-04-05 05:38:47', '2015-04-05 05:38:47'),
(20, 'consult:kalibao\\backend\\modules\\rbac\\controllers\\PersonUserController', '', '2015-04-05 05:39:04', '2015-04-05 05:39:04'),
(21, 'delete:kalibao\\backend\\modules\\rbac\\controllers\\PersonUserController', '', '2015-04-05 05:40:29', '2015-04-05 05:40:29'),
(22, 'create:kalibao\\backend\\modules\\message\\controllers\\MessageController', '', '2015-04-05 05:56:20', '2015-04-05 05:56:20'),
(23, 'update:kalibao\\backend\\modules\\message\\controllers\\MessageController', '', '2015-04-05 05:56:31', '2015-04-05 05:56:31'),
(24, 'delete:kalibao\\backend\\modules\\message\\controllers\\MessageController', '', '2015-04-05 05:56:43', '2015-04-05 05:56:43'),
(25, 'consult:kalibao\\backend\\modules\\message\\controllers\\MessageController', '', '2015-04-05 05:57:08', '2015-04-05 05:57:08'),
(26, 'translate:kalibao\\backend\\modules\\message\\controllers\\MessageController', '', '2015-04-05 05:58:31', '2015-04-05 05:58:31'),
(27, 'create:kalibao\\backend\\modules\\message\\controllers\\MessageGroupController', '', '2015-04-05 05:59:28', '2015-04-05 05:59:28'),
(28, 'update:kalibao\\backend\\modules\\message\\controllers\\MessageGroupController', '', '2015-04-05 05:59:41', '2015-04-05 05:59:41'),
(29, 'delete:kalibao\\backend\\modules\\message\\controllers\\MessageGroupController', '', '2015-04-05 05:59:57', '2015-04-05 05:59:57'),
(30, 'consult:kalibao\\backend\\modules\\message\\controllers\\MessageGroupController', '', '2015-04-05 06:00:22', '2015-04-05 06:00:22'),
(31, 'translate:kalibao\\backend\\modules\\message\\controllers\\MessageGroupController', '', '2015-04-05 06:00:39', '2015-04-05 06:00:39'),
(32, 'create:kalibao\\backend\\modules\\mail\\controllers\\MailSendingRoleController', '', '2015-04-05 06:01:51', '2015-04-05 06:01:51'),
(33, 'update:kalibao\\backend\\modules\\mail\\controllers\\MailSendingRoleController', '', '2015-04-05 06:02:13', '2015-04-05 06:02:13'),
(34, 'delete:kalibao\\backend\\modules\\mail\\controllers\\MailSendingRoleController', '', '2015-04-05 06:02:34', '2015-04-05 06:02:34'),
(35, 'consult:kalibao\\backend\\modules\\mail\\controllers\\MailSendingRoleController', '', '2015-04-05 06:02:54', '2015-04-05 06:02:54'),
(36, 'translate:kalibao\\backend\\modules\\mail\\controllers\\MailSendingRoleController', '', '2015-04-05 06:03:11', '2015-04-05 06:03:11'),
(37, 'create:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateController', '', '2015-04-05 06:04:09', '2015-04-05 06:04:09'),
(38, 'update:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateController', '', '2015-04-05 06:04:29', '2015-04-05 06:04:30'),
(39, 'delete:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateController', '', '2015-04-05 06:04:48', '2015-04-05 06:04:48'),
(40, 'consult:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateController', '', '2015-04-05 06:04:59', '2015-04-05 06:04:59'),
(41, 'translate:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateController', '', '2015-04-05 06:05:15', '2015-04-05 06:05:15'),
(42, 'create:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateGroupController', '', '2015-04-05 06:06:04', '2015-04-05 06:06:04'),
(43, 'update:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateGroupController', '', '2015-04-05 06:06:24', '2015-04-05 06:06:24'),
(44, 'delete:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateGroupController', '', '2015-04-05 06:06:39', '2015-04-05 06:06:39'),
(45, 'consult:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateGroupController', '', '2015-04-05 06:06:59', '2015-04-05 06:06:59'),
(46, 'translate:kalibao\\backend\\modules\\mail\\controllers\\MailTemplateGroupController', '', '2015-04-05 06:07:14', '2015-04-05 06:07:14'),
(47, 'create:kalibao\\backend\\modules\\language\\controllers\\LanguageController', '', '2015-04-05 06:09:03', '2015-04-05 06:09:03'),
(48, 'update:kalibao\\backend\\modules\\language\\controllers\\LanguageController', '', '2015-04-05 06:09:13', '2015-04-05 06:09:13'),
(49, 'delete:kalibao\\backend\\modules\\language\\controllers\\LanguageController', '', '2015-04-05 06:09:23', '2015-04-05 06:09:23'),
(50, 'consult:kalibao\\backend\\modules\\language\\controllers\\LanguageController', '', '2015-04-05 06:09:33', '2015-04-05 06:09:33'),
(51, 'translate:kalibao\\backend\\modules\\language\\controllers\\LanguageController', '', '2015-04-05 06:09:52', '2015-04-05 06:09:52'),
(52, 'create:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupController', '', '2015-04-05 06:10:48', '2015-04-05 06:10:48'),
(53, 'update:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupController', '', '2015-04-05 06:11:02', '2015-04-05 06:11:02'),
(54, 'delete:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupController', '', '2015-04-05 06:11:12', '2015-04-05 06:11:12'),
(55, 'consult:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupController', '', '2015-04-05 06:11:27', '2015-04-05 06:11:27'),
(56, 'translate:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupController', '', '2015-04-05 06:11:43', '2015-04-05 06:11:43'),
(57, 'create:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupLanguageController', '', '2015-04-05 06:12:15', '2015-04-05 06:12:15'),
(58, 'update:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupLanguageController', '', '2015-04-05 06:12:31', '2015-04-05 06:12:31'),
(59, 'delete:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupLanguageController', '', '2015-04-05 06:12:50', '2015-04-05 06:12:50'),
(60, 'consult:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupLanguageController', '', '2015-04-05 06:13:03', '2015-04-05 06:13:03'),
(61, 'translate:kalibao\\backend\\modules\\language\\controllers\\LanguageGroupLanguageController', '', '2015-04-05 06:13:22', '2015-04-05 06:13:22'),
(62, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsImageController', '', '2015-04-05 06:15:43', '2015-04-05 06:15:43'),
(63, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsImageController', '', '2015-04-05 06:15:57', '2015-04-05 06:15:57'),
(64, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsImageController', '', '2015-04-05 06:16:06', '2015-04-05 06:16:06'),
(65, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsImageController', '', '2015-04-05 06:16:20', '2015-04-05 06:16:20'),
(66, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsImageController', '', '2015-04-05 06:18:13', '2015-04-05 06:18:13'),
(67, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsImageGroupController', '', '2015-04-05 06:18:50', '2015-04-05 06:18:50'),
(68, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsImageGroupController', '', '2015-04-05 06:19:06', '2015-04-05 06:19:06'),
(69, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsImageGroupController', '', '2015-04-05 06:19:15', '2015-04-05 06:19:15'),
(70, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsImageGroupController', '', '2015-04-05 06:19:25', '2015-04-05 06:19:25'),
(71, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsImageGroupController', '', '2015-04-05 06:19:44', '2015-04-05 06:19:44'),
(72, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsPageController', '', '2015-04-05 06:22:18', '2015-04-05 06:22:18'),
(73, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsPageController', '', '2015-04-05 06:22:31', '2015-04-05 06:22:31'),
(74, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsPageController', '', '2015-04-05 06:22:41', '2015-04-05 06:22:41'),
(75, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsPageController', '', '2015-04-05 06:22:51', '2015-04-05 06:22:51'),
(76, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsPageController', '', '2015-04-05 06:23:16', '2015-04-05 06:23:16'),
(77, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsLayoutController', '', '2015-04-05 06:26:01', '2015-04-05 06:26:01'),
(78, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsLayoutController', '', '2015-04-05 06:26:27', '2015-04-05 06:26:27'),
(79, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsLayoutController', '', '2015-04-05 06:27:38', '2015-04-05 06:27:38'),
(80, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsLayoutController', '', '2015-04-05 06:27:50', '2015-04-05 06:27:50'),
(81, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsLayoutController', '', '2015-04-05 06:28:24', '2015-04-05 06:28:24'),
(82, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetController', '', '2015-04-05 06:28:55', '2015-04-05 06:28:55'),
(83, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetController', '', '2015-04-05 06:29:07', '2015-04-05 06:29:07'),
(84, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetController', '', '2015-04-05 06:29:22', '2015-04-05 06:29:22'),
(85, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetController', '', '2015-04-05 06:29:31', '2015-04-05 06:29:31'),
(86, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetController', '', '2015-04-05 06:30:08', '2015-04-05 06:30:08'),
(87, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetGroupController', '', '2015-04-05 06:30:23', '2015-04-05 06:30:23'),
(88, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetGroupController', '', '2015-04-05 06:30:48', '2015-04-05 06:30:48'),
(89, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetGroupController', '', '2015-04-05 06:31:01', '2015-04-05 06:31:01'),
(90, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetGroupController', '', '2015-04-05 06:31:15', '2015-04-05 06:31:15'),
(91, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsWidgetGroupController', '', '2015-04-05 06:31:36', '2015-04-05 06:31:36'),
(92, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuController', '', '2015-04-05 06:32:03', '2015-04-05 06:32:03'),
(93, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuController', '', '2015-04-05 06:32:46', '2015-04-05 06:32:46'),
(94, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuController', '', '2015-04-05 06:32:54', '2015-04-05 06:32:54'),
(95, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuController', '', '2015-04-05 06:33:02', '2015-04-05 06:33:02'),
(96, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuController', '', '2015-04-05 06:33:12', '2015-04-05 06:33:12'),
(97, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuGroupController', '', '2015-04-05 06:33:22', '2015-04-05 06:33:22'),
(98, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuGroupController', '', '2015-04-05 06:33:39', '2015-04-05 06:33:39'),
(99, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuGroupController', '', '2015-04-05 06:33:50', '2015-04-05 06:33:50'),
(100, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuGroupController', '', '2015-04-05 06:34:09', '2015-04-05 06:34:09'),
(101, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsMenuGroupController', '', '2015-04-05 06:34:30', '2015-04-05 06:34:30'),
(102, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsController', '', '2015-04-05 06:35:00', '2015-04-05 06:35:00'),
(103, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsController', '', '2015-04-05 06:35:21', '2015-04-05 06:35:21'),
(104, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsController', '', '2015-04-05 06:35:32', '2015-04-05 06:35:32'),
(105, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsController', '', '2015-04-05 06:35:41', '2015-04-05 06:35:41'),
(106, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsController', '', '2015-04-05 06:35:54', '2015-04-05 06:35:54'),
(107, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsGroupController', '', '2015-04-05 06:36:26', '2015-04-05 06:36:26'),
(108, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsGroupController', '', '2015-04-05 06:36:39', '2015-04-05 06:36:39'),
(109, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsGroupController', '', '2015-04-05 06:36:49', '2015-04-05 06:36:49'),
(110, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsGroupController', '', '2015-04-05 06:37:01', '2015-04-05 06:37:01'),
(111, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsNewsGroupController', '', '2015-04-05 06:37:16', '2015-04-05 06:37:16'),
(112, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumController', '', '2015-04-05 06:37:36', '2015-04-05 06:37:36'),
(113, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumController', '', '2015-04-05 06:37:56', '2015-04-05 06:37:56'),
(114, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumController', '', '2015-04-05 06:38:09', '2015-04-05 06:38:09'),
(115, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumController', '', '2015-04-05 06:38:25', '2015-04-05 06:38:25'),
(116, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumController', '', '2015-04-05 06:38:40', '2015-04-05 06:38:40'),
(117, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumPhotoController', '', '2015-04-05 06:39:19', '2015-04-05 06:39:19'),
(118, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumPhotoController', '', '2015-04-05 06:39:33', '2015-04-05 06:39:33'),
(119, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumPhotoController', '', '2015-04-05 06:39:42', '2015-04-05 06:39:42'),
(120, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumPhotoController', '', '2015-04-05 06:39:57', '2015-04-05 06:39:57'),
(121, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsAlbumPhotoController', '', '2015-04-05 06:40:17', '2015-04-05 05:02:16'),
(122, 'consult:medias', '', '2015-04-06 03:49:09', '2015-04-06 03:50:27'),
(123, 'consult:cms', '', '2015-04-06 03:49:23', '2015-04-06 03:50:25'),
(124, 'consult:rights', '', '2015-04-06 03:49:53', '2015-04-06 05:07:45'),
(125, 'consult:parameters', '', '2015-04-06 03:50:17', '2015-04-06 03:50:17'),
(126, 'update:kalibao\\backend\\modules\\profile\\controllers\\ProfileController', '', '2015-04-08 05:50:27', '2015-04-08 05:50:27'),
(127, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuController', '', '2015-04-09 04:15:10', '2015-04-09 04:16:15'),
(128, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuController', '', '2015-04-09 04:15:32', '2015-04-09 04:16:29'),
(129, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuController', '', '2015-04-09 04:15:44', '2015-04-09 04:16:37'),
(130, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuController', '', '2015-04-09 04:17:04', '2015-04-09 04:17:04'),
(131, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuController', '', '2015-04-09 04:17:58', '2015-04-09 04:17:58'),
(132, 'consult:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuGroupController', '', '2015-04-09 04:38:50', '2015-04-09 04:41:54'),
(133, 'create:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuGroupController', '', '2015-04-09 04:40:05', '2015-04-09 04:41:45'),
(134, 'update:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuGroupController', '', '2015-04-09 04:40:15', '2015-04-09 04:41:40'),
(135, 'delete:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuGroupController', '', '2015-04-09 04:40:25', '2015-04-09 04:41:27'),
(136, 'translate:kalibao\\backend\\modules\\cms\\controllers\\CmsSimpleMenuGroupController', '', '2015-04-09 04:40:33', '2015-04-09 04:41:31'),
(137, 'update:kalibao\\backend\\modules\\cache\\controllers\\CacheDbController', '', '2015-04-09 05:32:51', '2015-04-09 05:32:51');

-- --------------------------------------------------------

--
-- Structure de la table `rbac_permission_i18n`
--

CREATE TABLE IF NOT EXISTS `rbac_permission_i18n` (
  `rbac_permission_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `rbac_permission_i18n`
--

INSERT INTO `rbac_permission_i18n` (`rbac_permission_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Create'),
(1, 'fr', 'Créer'),
(2, 'en', 'Update'),
(2, 'fr', 'Modifier'),
(3, 'en', 'Delete'),
(3, 'fr', 'Supprimer'),
(4, 'en', 'Translate'),
(4, 'fr', 'Traduire'),
(5, 'en', 'Consult'),
(5, 'fr', 'Consulter'),
(6, 'en', 'Administrate authorizations'),
(6, 'fr', 'Administrer les droits'),
(7, 'en', 'Navigate in backend'),
(7, 'fr', 'Naviguer dans le backend'),
(8, 'en', 'Consult permissions'),
(8, 'fr', 'Consulter les permissions'),
(9, 'en', 'Create permissions'),
(9, 'fr', 'Créer les permissions'),
(10, 'en', 'Delete permissions'),
(10, 'fr', 'Supprimer les permissions'),
(11, 'en', 'Translate permissions'),
(11, 'fr', 'Traduire les permissions'),
(12, 'en', 'Update permissions'),
(12, 'fr', 'Modifier les permissions'),
(13, 'en', 'Consult roles'),
(13, 'fr', 'Consulter les rôles'),
(14, 'en', 'Update roles'),
(14, 'fr', 'Modifier les rôles'),
(15, 'en', 'Create roles'),
(15, 'fr', 'Créer des rôles'),
(16, 'en', 'Translate roles'),
(16, 'fr', 'Traduire des rôles'),
(17, 'en', 'Delete roles'),
(17, 'fr', 'Supprimer des rôles'),
(18, 'en', 'Create users'),
(18, 'fr', 'Créer des utilisateurs'),
(19, 'en', 'Update users'),
(19, 'fr', 'Modifier des utilisateurs'),
(20, 'en', 'Consult users'),
(20, 'fr', 'Consulter des utilisateurs'),
(21, 'en', 'Delete users'),
(21, 'fr', 'Supprimer des utilisateurs'),
(22, 'en', 'Create messages'),
(22, 'fr', 'Créer des messages'),
(23, 'en', 'Update messages'),
(23, 'fr', 'Modifier des messages'),
(24, 'en', 'Delete messages'),
(24, 'fr', 'Supprimer des messages'),
(25, 'en', 'Consult messages'),
(25, 'fr', 'Consulter les messages'),
(26, 'en', 'Translate messages'),
(26, 'fr', 'Traduire les messages'),
(27, 'en', 'Create message groups'),
(27, 'fr', 'Créer des groupes de message'),
(28, 'en', 'Update message groups'),
(28, 'fr', 'Modifier des groupes de message'),
(29, 'en', 'Delete message groups'),
(29, 'fr', 'Supprimer des groupes de message'),
(30, 'en', 'Consult message groups'),
(30, 'fr', 'Consulter les groupes de message'),
(31, 'en', 'Translate message groups'),
(31, 'fr', 'Traduire les groupes de message'),
(32, 'en', 'Add mail sending roles'),
(32, 'fr', 'Ajouter des rôles d''envoie de mail'),
(33, 'en', 'Update mail sending roles'),
(33, 'fr', 'Modifier les rôles d''envoie de mail'),
(34, 'en', 'Delete mail sending roles'),
(34, 'fr', 'Supprimer des rôles d''envoie de mail'),
(35, 'en', 'Consult mail sending roles'),
(35, 'fr', 'Consulter les rôles d''envoie de mail'),
(36, 'en', 'Translate mail sending roles'),
(36, 'fr', 'Traduire les rôles d''envoie de mail'),
(37, 'en', 'Create mail templates'),
(37, 'fr', 'Créer des modèles de mail'),
(38, 'en', 'Update mail templates'),
(38, 'fr', 'Modifier les modèles de mail'),
(39, 'en', 'Delete mail templates'),
(39, 'fr', 'Supprimer des modèles de mail'),
(40, 'en', 'Consult mail templates'),
(40, 'fr', 'Consulter les modèles de mail'),
(41, 'en', 'Translate mail templates'),
(41, 'fr', 'Traduire les modèles de mail'),
(42, 'en', 'Create mail template groups'),
(42, 'fr', 'Créer des groupes de modèles de mail'),
(43, 'en', 'Update mail template groups'),
(43, 'fr', 'Modifier les groupes de modèles de mail'),
(44, 'en', 'Delete mail template groups'),
(44, 'fr', 'Supprimer des groupes de modèles de mail'),
(45, 'en', 'Consult mail template groups'),
(45, 'fr', 'Consulter les groupes de modèles de mail'),
(46, 'en', 'Translate mail template groups'),
(46, 'fr', 'Traduire les groupes de modèles de mail'),
(47, 'en', 'Add languages'),
(47, 'fr', 'Ajouter des langues'),
(48, 'en', 'Update languages'),
(48, 'fr', 'Modifier les langues'),
(49, 'en', 'Delete languages'),
(49, 'fr', 'Supprimer des langues'),
(50, 'en', 'Consult languages'),
(50, 'fr', 'Consulter les langues'),
(51, 'en', 'Translate languages'),
(51, 'fr', 'Traduire des langues'),
(52, 'en', 'Create language groups'),
(52, 'fr', 'Créer des groupes de langue'),
(53, 'en', 'Update language groups'),
(53, 'fr', 'Modifier les groupes de langue'),
(54, 'en', 'Delete language groups'),
(54, 'fr', 'Supprimer des groupes de langue'),
(55, 'en', 'Consult language groups'),
(55, 'fr', 'Consulter les groupes de langue'),
(56, 'en', 'Translate language groups'),
(56, 'fr', 'Traduire les groupes de langue'),
(57, 'en', 'Add languages in a group'),
(57, 'fr', 'Ajouter des langues dans un groupe'),
(58, 'en', 'Update group languages'),
(58, 'fr', 'Modifier les langues d''un groupe'),
(59, 'en', 'Delete group languages'),
(59, 'fr', 'Supprimer des langues d''un groupe'),
(60, 'en', 'Consult group languages'),
(60, 'fr', 'Consulter les langues d''un groupe'),
(61, 'en', 'Translate group languages'),
(61, 'fr', 'Traduire les langues d''un groupe'),
(62, 'en', 'Add images'),
(62, 'fr', 'Ajouter des images'),
(63, 'en', 'Update images'),
(63, 'fr', 'Modifier des images'),
(64, 'en', 'Delete images'),
(64, 'fr', 'Supprimer des images'),
(65, 'en', 'Consult images'),
(65, 'fr', 'Consulter les images'),
(66, 'en', 'Translate images'),
(66, 'fr', 'Traduire les images'),
(67, 'en', 'Create image groups'),
(67, 'fr', 'Créer des groupes d''image'),
(68, 'en', 'Update image groups'),
(68, 'fr', 'Modifier les groupes d''image'),
(69, 'en', 'Delete image groups'),
(69, 'fr', 'Supprimer des groupes d''image'),
(70, 'en', 'Consult image groups'),
(70, 'fr', 'Consulter les groupes d''image'),
(71, 'en', 'Translate image groups'),
(71, 'fr', 'Traduire des groupes d''image'),
(72, 'en', 'Create pages'),
(72, 'fr', 'Créer des pages'),
(73, 'en', 'Update pages'),
(73, 'fr', 'Modifier les pages'),
(74, 'en', 'Delete pages'),
(74, 'fr', 'Supprimer des pages'),
(75, 'en', 'Consult pages'),
(75, 'fr', 'Consulter les pages'),
(76, 'en', 'Translate pages'),
(76, 'fr', 'Traduire des pages'),
(77, 'en', 'Create a layout'),
(77, 'fr', 'Créer une mise en page'),
(78, 'en', 'Update layouts'),
(78, 'fr', 'Modifier les mise en page'),
(79, 'en', 'Delete layouts'),
(79, 'fr', 'Supprimer des mises en page'),
(80, 'en', 'Consult layouts'),
(80, 'fr', 'Consulter les mises en page'),
(81, 'en', 'Translate layouts'),
(81, 'fr', 'Traduire les mises en page'),
(82, 'en', 'Create widgets'),
(82, 'fr', 'Créer des widgets'),
(83, 'en', 'Update widgets'),
(83, 'fr', 'Modifier les widgets'),
(84, 'en', 'Delete widgets'),
(84, 'fr', 'Supprimer des widgets'),
(85, 'en', 'Consult widgets'),
(85, 'fr', 'Consulter les widgets'),
(86, 'en', 'Translate widgets'),
(86, 'fr', 'Traduire des widgets'),
(87, 'en', 'Create widget groups'),
(87, 'fr', 'Créer des groupes de widget'),
(88, 'en', 'Update widget groups'),
(88, 'fr', 'Modifier les groupes de widget'),
(89, 'en', 'Delete widget groups'),
(89, 'fr', 'Supprimer des groupes de widget'),
(90, 'en', 'Consult widget groups'),
(90, 'fr', 'Consulter les groupes de widget'),
(91, 'en', 'Translate widget groups'),
(91, 'fr', 'Traduire des groupes de widget'),
(92, 'en', 'Create a menu'),
(92, 'fr', 'Créer un menu'),
(93, 'en', 'Update menus'),
(93, 'fr', 'Modifier les menus'),
(94, 'fr', 'Supprimer des menus'),
(95, 'en', 'Consult menus'),
(95, 'fr', 'Consulter les menus'),
(96, 'en', 'Translate menus'),
(96, 'fr', 'Traduire des menus'),
(97, 'en', 'Create menu groups'),
(97, 'fr', 'Créer un groupe de menu'),
(98, 'en', 'Update menu groups'),
(98, 'fr', 'Modifier les groupes de menu'),
(99, 'en', 'Delete menu groups'),
(99, 'fr', 'Supprimer des groupes de menu'),
(100, 'en', 'Consult menu groups'),
(100, 'fr', 'Consulter les groupes de menu'),
(101, 'en', 'Translate menu groups'),
(101, 'fr', 'Traduire des groupes de menu'),
(102, 'en', 'Create a news'),
(102, 'fr', 'Créer une news'),
(103, 'en', 'Update news'),
(103, 'fr', 'Modifier les news'),
(104, 'en', 'Delete news'),
(104, 'fr', 'Supprimer des news'),
(105, 'en', 'Consult news'),
(105, 'fr', 'Consulter les news'),
(106, 'en', 'Translate news'),
(106, 'fr', 'Traduire des news'),
(107, 'en', 'Create a news group'),
(107, 'fr', 'Créer un groupe de news'),
(108, 'en', 'Update news groups'),
(108, 'fr', 'Modifier les groupes de news'),
(109, 'en', 'Delete news groups'),
(109, 'fr', 'Supprimer des groupes de news'),
(110, 'en', 'Consult news groups'),
(110, 'fr', 'Consulter les groupes de news'),
(111, 'en', 'Translate news groups'),
(111, 'fr', 'Traduire des groupes de news'),
(112, 'en', 'Create a photo album'),
(112, 'fr', 'Créer un album photo'),
(113, 'en', 'Update photo albums'),
(113, 'fr', 'Modifier les albums photo'),
(114, 'en', 'Delete photo albums'),
(114, 'fr', 'Supprimer des albums photo'),
(115, 'en', 'Consult photo albums'),
(115, 'fr', 'Consulter les albums photo'),
(116, 'en', 'Translate photo albums'),
(116, 'fr', 'Traduire des albums photo'),
(117, 'en', 'Add photos in the album'),
(117, 'fr', 'Ajouter des photos dans l''album'),
(118, 'en', 'Update album photos'),
(118, 'fr', 'Modifier des photos dans l''album'),
(119, 'en', 'Delete album photos'),
(119, 'fr', 'Supprimer des photos dans l''album'),
(120, 'en', 'Consult album photos'),
(120, 'fr', 'Consulter les photos de l''album'),
(121, 'en', 'Translate album photos'),
(121, 'fr', 'Traduire des photos de l''album'),
(122, 'en', 'Consult the medias menu'),
(122, 'fr', 'Consulter le menu Médias'),
(123, 'en', 'Consult the CMS menu'),
(123, 'fr', 'Consulter le menu CMS'),
(124, 'en', 'Consult the rights menu'),
(124, 'fr', 'Consulter le menu des droits'),
(125, 'en', 'Consult the parameters menu'),
(125, 'fr', 'Consulter le menu des paramètres'),
(126, 'en', 'Update your profile'),
(126, 'fr', 'Modifier son profil'),
(127, 'en', 'Consult menus links'),
(127, 'fr', 'Consulter les liens des menus'),
(128, 'en', 'Add menus links'),
(128, 'fr', 'Ajouter des liens dans les menus'),
(129, 'en', 'Update menus links'),
(129, 'fr', 'Modifier les liens des menu'),
(130, 'en', 'Translate menus links'),
(130, 'fr', 'Traduire les liens des menus'),
(131, 'en', 'Delete menus links'),
(131, 'fr', 'Supprimer les liens des menus'),
(132, 'en', 'Consult menus'),
(132, 'fr', 'Consulter des menus'),
(133, 'en', 'Add menus'),
(133, 'fr', 'Ajouter des menus'),
(134, 'en', 'Update menus'),
(134, 'fr', 'Modifier des menus'),
(135, 'en', 'Delete menus'),
(135, 'fr', 'Supprimer des menus'),
(136, 'en', 'Translate menus'),
(136, 'fr', 'Traduire des menus'),
(137, 'en', 'Refresh the schema cache of database'),
(137, 'fr', 'Rafraichir le cache du schema de la base de données');

-- --------------------------------------------------------

--
-- Structure de la table `rbac_role`
--

CREATE TABLE IF NOT EXISTS `rbac_role` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `rule_path` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `rbac_role`
--

INSERT INTO `rbac_role` (`id`, `name`, `rule_path`, `created_at`, `updated_at`) VALUES
(1, 'backend.administrator', '', '2015-03-19 04:47:56', '2015-04-07 10:09:50'),
(2, 'backend.user', '', '2015-03-19 04:50:24', '2015-04-07 10:09:44');

-- --------------------------------------------------------

--
-- Structure de la table `rbac_role_i18n`
--

CREATE TABLE IF NOT EXISTS `rbac_role_i18n` (
  `rbac_role_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `rbac_role_i18n`
--

INSERT INTO `rbac_role_i18n` (`rbac_role_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Backend administrators'),
(1, 'fr', 'Administrateurs du backend'),
(2, 'en', 'Backend users'),
(2, 'fr', 'Utilisateurs du backend');

-- --------------------------------------------------------

--
-- Structure de la table `rbac_role_permission`
--

CREATE TABLE IF NOT EXISTS `rbac_role_permission` (
  `rbac_role_id` bigint(20) unsigned NOT NULL,
  `rbac_permission_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `rbac_role_permission`
--

INSERT INTO `rbac_role_permission` (`rbac_role_id`, `rbac_permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 7);

-- --------------------------------------------------------

--
-- Structure de la table `rbac_user_role`
--

CREATE TABLE IF NOT EXISTS `rbac_user_role` (
  `user_id` bigint(20) unsigned NOT NULL,
  `rbac_role_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `rbac_user_role`
--

INSERT INTO `rbac_user_role` (`user_id`, `rbac_role_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(1, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the supplier',
  `name` varchar(255) DEFAULT NULL COMMENT 'name of the supplier'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='suppliers table';

--
-- Contenu de la table `supplier`
--

INSERT INTO `supplier` (`id`, `name`) VALUES
(1, 'fournisseur 1');

-- --------------------------------------------------------

--
-- Structure de la table `third`
--

CREATE TABLE IF NOT EXISTS `third` (
  `id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL COMMENT 'the role is what kind of third it is.',
  `note` varchar(255) DEFAULT NULL COMMENT 'Some notes about the third.',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='the third is everything ! He mirror a client.';

--
-- Contenu de la table `third`
--

INSERT INTO `third` (`id`, `role_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 1, 'Test De Personne', '2015-06-10 06:40:58', '2015-06-10 06:40:58'),
(41, 2, 'Test De Company', '2015-06-10 06:43:17', '2015-06-10 10:40:22'),
(42, 1, 'Mika Test', '2015-06-18 23:11:02', '2015-06-18 23:11:02'),
(43, 1, '', '2015-06-30 23:50:25', '2015-06-30 23:50:25');

-- --------------------------------------------------------

--
-- Structure de la table `third_role`
--

CREATE TABLE IF NOT EXISTS `third_role` (
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `third_role`
--

INSERT INTO `third_role` (`id`, `created_at`, `updated_at`) VALUES
(1, '2015-05-28 06:21:37', '2015-05-28 06:21:37'),
(2, '2015-05-28 06:21:48', '2015-05-28 23:52:49'),
(3, '2015-06-30 02:22:48', '2015-06-30 02:22:48');

-- --------------------------------------------------------

--
-- Structure de la table `third_role_i18n`
--

CREATE TABLE IF NOT EXISTS `third_role_i18n` (
  `third_role_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `third_role_i18n`
--

INSERT INTO `third_role_i18n` (`third_role_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Person'),
(1, 'fr', 'Personne'),
(2, 'en', 'Company'),
(2, 'fr', 'Societé'),
(3, 'fr', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) unsigned NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `auth_key` varchar(64) COLLATE utf8_bin NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `password_reset_token` varchar(64) COLLATE utf8_bin NOT NULL,
  `active_password_reset` tinyint(1) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `auth_key`, `status`, `password_reset_token`, `active_password_reset`, `created_at`, `updated_at`) VALUES
(1, 'admin@kalibao.com', '$2y$13$8cyx3BngE2HDb1nNfVsPn.txQhdF/yxs3jxIUgBSS/.Fm5fTzcn3S', '', 1, '', 0, '2012-12-20 12:40:50', '2015-04-12 07:39:57'),
(2, 'noreply@kalibao.com', '$2y$13$Ptg3ANmuFF48fVoRsoZbrO3OLlkWzJ2/uBrU.Oyi9FXRfb5bxwzDS', 'frYXFpqdAIz4JfouEWLg9Q77PXp3ZT4s', 0, '', 0, '2015-03-18 23:00:00', '2015-04-12 05:40:43'),
(3, 'g@g.G', '$2y$13$IMcwVsS9zRRu7pV5Evrf3.Gp244t10zMB.JLxY3suvfk4CpM/8b/O', 'APf9sa-OAyg926VV1MG6jMjuUqJS5P1w', 1, '', 0, '2015-06-08 08:01:39', '2015-06-08 08:01:39'),
(4, 'a@a.com', '$2y$13$D71dOTIehOgz0HIf1Qtp3uxYWSg0CpVeDcaf7qT.v9Qep.PSZBjKa', 'MlhNbPBilcwGAZBTRN8D8ep_1zvKXZPn', 1, '', 0, '2015-06-10 06:46:11', '2015-06-10 06:46:11');

-- --------------------------------------------------------

--
-- Structure de la table `variable`
--

CREATE TABLE IF NOT EXISTS `variable` (
  `id` bigint(20) unsigned NOT NULL,
  `variable_group_id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `val` text COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `variable`
--

INSERT INTO `variable` (`id`, `variable_group_id`, `name`, `val`, `created_at`, `updated_at`) VALUES
(2, 2, 'auto_login_duration', '7', '2012-12-21 09:34:02', '2015-02-28 02:56:58'),
(3, 1, 'send_role_id:from', '1', '2013-01-29 17:35:43', '2014-06-23 13:16:27'),
(4, 1, 'send_role_id:to', '2', '2013-01-29 17:36:12', '2014-06-23 13:16:23'),
(5, 1, 'send_role_id:cc', '3', '2013-01-29 17:36:33', '2015-02-26 02:27:39'),
(6, 1, 'send_role_id:bcc', '4', '2013-01-29 17:36:51', '2014-06-23 13:16:14'),
(14, 2, 'person_token_action:resetPassword', 'backend:resetPassword', '2014-06-23 13:27:09', '2015-02-27 00:30:17'),
(15, 2, 'person_token_expired_at:resetPassword', '12', '2014-06-23 13:34:14', '2015-03-08 08:00:32'),
(25, 1, 'mail_template_sql_alias_mailto', 'mt_email_to', '2014-12-05 12:48:51', '2015-04-02 07:40:44'),
(26, 1, 'mail_template_sql_alias_mailfrom', 'mt_email_from', '2014-12-05 12:49:22', '2015-04-02 07:40:53'),
(27, 1, 'mail_template_sql_alias_sender', 'mt_email_sender', '2014-12-05 12:49:59', '2015-04-02 07:40:56'),
(54, 1, 'language_group_id:kalibao.backend', '1', '2014-06-22 16:01:48', '2015-04-04 09:10:43'),
(55, 1, 'language_group_id:kalibao.frontend', '2', '2015-04-10 06:04:54', '2015-04-10 06:05:47'),
(56, 1, 'message_group_id:kalibao', '1', '0000-00-00 00:00:00', '2015-04-11 09:45:00'),
(57, 1, 'message_group_id:kalibao.backend', '2', '2015-04-10 22:00:00', '2015-04-11 09:46:13'),
(58, 1, 'message_group_id:kalibao.frontend', '3', '2015-04-11 09:46:34', '2015-04-11 09:47:32');

-- --------------------------------------------------------

--
-- Structure de la table `variable_group`
--

CREATE TABLE IF NOT EXISTS `variable_group` (
  `id` int(10) unsigned NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `variable_group`
--

INSERT INTO `variable_group` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'kalibao', '2012-12-28 15:46:26', '2014-07-30 19:24:31'),
(2, 'kalibao.backend', '2012-12-20 17:28:37', '2015-03-28 02:35:51'),
(3, 'kalibao.frontend', '2014-08-05 07:36:32', '2015-03-28 02:34:51');

-- --------------------------------------------------------

--
-- Structure de la table `variable_group_i18n`
--

CREATE TABLE IF NOT EXISTS `variable_group_i18n` (
  `variable_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `variable_group_i18n`
--

INSERT INTO `variable_group_i18n` (`variable_group_id`, `i18n_id`, `title`) VALUES
(1, 'en', 'Kalibao'),
(1, 'fr', 'Kalibao'),
(2, 'en', 'Kalibao > Backend'),
(2, 'fr', 'Kalibao > Backend'),
(3, 'en', 'Kalibao > Frontend'),
(3, 'fr', 'Kalibao > Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `variable_i18n`
--

CREATE TABLE IF NOT EXISTS `variable_i18n` (
  `variable_id` bigint(20) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `variable_i18n`
--

INSERT INTO `variable_i18n` (`variable_id`, `i18n_id`, `description`) VALUES
(2, 'en', 'Time during which an autologin session keep alive (in days)'),
(2, 'fr', 'Nombre de jours pendant lesquels une session auto-login reste active'),
(3, 'en', 'ID of FROM sending role'),
(3, 'fr', 'Identifiant du role d''envoie d''email "FROM"'),
(4, 'en', 'ID of TO sending role'),
(4, 'fr', 'Identifiant du role d''envoie d''email "TO"'),
(5, 'en', 'ID of CC sending role'),
(5, 'fr', 'Identifiant du role d''envoie d''email "CC"'),
(6, 'en', 'ID of BCC sending role'),
(6, 'fr', 'Identifiant du role d''envoie d''email "BCC"'),
(14, 'en', 'Token action used in the password reset module'),
(14, 'fr', 'Action du jeton utilisé dans le module de réinitialisation du mot de passe'),
(15, 'en', 'Time during which the reset password action keep alive (in hours)'),
(15, 'fr', 'Temps pendant lequel l''action de réinitialisation du mot de passe reste active (en heure)'),
(25, 'en', 'Sql alias in mail template for mail recipient'),
(25, 'fr', 'Sql alias in mail template for mail recipient'),
(26, 'en', 'Sql alias in mail template for mail sender'),
(26, 'fr', 'Alias SQL utilis&eacute; dans les mail template pour désigner l''envoyeur'),
(27, 'en', 'Sql alias in mail template for sender name'),
(27, 'fr', 'Alias SQL utilisé dans les mail template pour désigner le nom de l''envoyeur'),
(54, 'en', 'Group language ID of kalibao.frontend application'),
(54, 'fr', 'Identifiant du groupe de langue de l''application kalibao.backend'),
(55, 'fr', 'Identifiant du groupe de langue de l''application kalibao.frontend'),
(56, 'en', 'Group message ID of kalibao'),
(56, 'fr', 'Identifiant du groupe de message  kalibao'),
(57, 'en', 'Group message ID of kalibao.backend'),
(57, 'fr', 'Identifiant du groupe de message kalibao.backend'),
(58, 'en', 'Group message ID of kalibao.frontend'),
(58, 'fr', 'Identifiant du groupe de message kalibao.frontend');

-- --------------------------------------------------------

--
-- Structure de la table `variant`
--

CREATE TABLE IF NOT EXISTS `variant` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'id of the variant',
  `product_id` bigint(20) unsigned NOT NULL COMMENT 'product related to the variant',
  `code` varchar(15) DEFAULT NULL COMMENT 'internal reference for the variant',
  `supplier_code` varchar(100) DEFAULT NULL COMMENT 'reference for the variant in the supplier''s store',
  `barcode` varchar(100) DEFAULT NULL COMMENT 'EAN13 code for the variant',
  `order` int(11) unsigned DEFAULT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'visibility of the variant in the front website',
  `primary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 if the variant is the default variant for the product',
  `top_selling` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 if the variant is a top selling variant',
  `height` int(11) unsigned DEFAULT NULL COMMENT 'height of the product (mm)',
  `width` int(11) unsigned DEFAULT NULL COMMENT 'width of the product (mm)',
  `length` int(11) unsigned DEFAULT NULL COMMENT 'length of the product (mm)',
  `weight` int(11) unsigned DEFAULT NULL COMMENT 'weight of the product (g)',
  `logistic_strategy_id` bigint(20) unsigned DEFAULT NULL,
  `last_inventory_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping_period_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping_period_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `selling_period_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `selling_period_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `discount_id` bigint(20) unsigned DEFAULT NULL COMMENT 'id of the discount applyed to the variant',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='information related to a variant of the product';

--
-- Contenu de la table `variant`
--

INSERT INTO `variant` (`id`, `product_id`, `code`, `supplier_code`, `barcode`, `order`, `visible`, `primary`, `top_selling`, `height`, `width`, `length`, `weight`, `logistic_strategy_id`, `last_inventory_date`, `shipping_period_start`, `shipping_period_end`, `selling_period_start`, `selling_period_end`, `discount_id`, `created_at`, `updated_at`) VALUES
(8, 1, '8', 'foo', '', 1, 0, 1, 0, 17, 16, 15, 100, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, '2015-06-18 08:43:58', '2015-06-18 12:50:49'),
(9, 1, '9', '', '', 2, 0, 1, 0, NULL, NULL, NULL, NULL, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, '2015-06-18 08:43:58', '2015-06-18 12:50:49'),
(10, 1, '10', '', '', 3, 0, 1, 0, NULL, NULL, NULL, NULL, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10, '2015-06-18 08:43:58', '2015-06-18 12:50:49'),
(11, 1, '11', '', '', 4, 0, 1, 0, NULL, NULL, NULL, NULL, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 11, '2015-06-18 08:43:58', '2015-06-18 12:50:49'),
(12, 1, '12', '', '', 5, 0, 1, 0, NULL, NULL, NULL, NULL, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12, '2015-06-18 08:43:58', '2015-06-18 12:50:49'),
(13, 1, '13', '', '', 6, 0, 1, 0, NULL, NULL, NULL, NULL, 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13, '2015-06-18 08:43:58', '2015-06-18 12:50:49');

-- --------------------------------------------------------

--
-- Structure de la table `variant_attribute`
--

CREATE TABLE IF NOT EXISTS `variant_attribute` (
  `variant_id` bigint(20) unsigned NOT NULL COMMENT 'id of the variant',
  `attribute_id` bigint(20) unsigned NOT NULL COMMENT 'id of the attribute',
  `extra_cost` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT 'cost added to the base price of the product',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='relation table between variant and attribute table';

--
-- Contenu de la table `variant_attribute`
--

INSERT INTO `variant_attribute` (`variant_id`, `attribute_id`, `extra_cost`, `created_at`, `updated_at`) VALUES
(8, 1, 10.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(8, 4, 20.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(9, 1, 10.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(9, 5, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(10, 2, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(10, 4, 20.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(11, 2, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(11, 5, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(12, 3, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(12, 4, 20.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(13, 3, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31'),
(13, 5, 0.0000, '2015-06-18 08:43:58', '2015-06-18 01:05:31');

-- --------------------------------------------------------

--
-- Structure de la table `variant_i18n`
--

CREATE TABLE IF NOT EXISTS `variant_i18n` (
  `variant_id` bigint(20) unsigned NOT NULL COMMENT 'id of the variant',
  `i18n_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'id of the language',
  `description` varchar(8000) DEFAULT NULL COMMENT 'translation for the description of the related variant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='translations for variants description';

--
-- Contenu de la table `variant_i18n`
--

INSERT INTO `variant_i18n` (`variant_id`, `i18n_id`, `description`) VALUES
(8, 'fr', ''),
(9, 'fr', ''),
(10, 'fr', ''),
(11, 'fr', ''),
(12, 'fr', ''),
(13, 'fr', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`third_id`),
  ADD KEY `index3` (`address_type_id`);

--
-- Index pour la table `address_type`
--
ALTER TABLE `address_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `address_type_i18n`
--
ALTER TABLE `address_type_i18n`
  ADD PRIMARY KEY (`address_type_id`,`i18n_id`),
  ADD KEY `fk_address_type_i18n_2_idx` (`i18n_id`);

--
-- Index pour la table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attribute_attribute_type1_idx` (`attribute_type_id`);

--
-- Index pour la table `attribute_i18n`
--
ALTER TABLE `attribute_i18n`
  ADD PRIMARY KEY (`attribute_id`,`i18n_id`),
  ADD KEY `fk_attribute_i18n_attribute1_idx` (`attribute_id`),
  ADD KEY `fk_attribute_i18n_language1_idx` (`i18n_id`);

--
-- Index pour la table `attribute_type`
--
ALTER TABLE `attribute_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `attribute_type_i18n`
--
ALTER TABLE `attribute_type_i18n`
  ADD PRIMARY KEY (`attribute_type_id`,`i18n_id`),
  ADD KEY `fk_attribute_type_i18n_attribute_type1_idx` (`attribute_type_id`),
  ADD KEY `fk_attribute_type_i18n_language1_idx` (`i18n_id`);

--
-- Index pour la table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bundle`
--
ALTER TABLE `bundle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_has_variant_variant1_idx` (`bundle_variant`),
  ADD KEY `fk_product_has_variant_product1_idx` (`product_id`),
  ADD KEY `fk_bundle_variant1_idx` (`variant_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_category1_idx` (`parent`),
  ADD KEY `fk_category_media1_idx` (`media_id`);

--
-- Index pour la table `category_i18n`
--
ALTER TABLE `category_i18n`
  ADD PRIMARY KEY (`category_id`,`i18n_id`),
  ADD KEY `fk_category_i18n_category1_idx` (`category_id`),
  ADD KEY `fk_category_i18n_language1` (`i18n_id`);

--
-- Index pour la table `cms_image`
--
ALTER TABLE `cms_image`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_path` (`file_path`),
  ADD KEY `cms_image_group_id` (`cms_image_group_id`);

--
-- Index pour la table `cms_image_group`
--
ALTER TABLE `cms_image_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cms_image_group_i18n`
--
ALTER TABLE `cms_image_group_i18n`
  ADD PRIMARY KEY (`cms_image_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_image_i18n`
--
ALTER TABLE `cms_image_i18n`
  ADD PRIMARY KEY (`cms_image_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_layout`
--
ALTER TABLE `cms_layout`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cms_layout_i18n`
--
ALTER TABLE `cms_layout_i18n`
  ADD PRIMARY KEY (`cms_layout_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_news`
--
ALTER TABLE `cms_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cms_news_group_id` (`cms_news_group_id`);

--
-- Index pour la table `cms_news_group`
--
ALTER TABLE `cms_news_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cms_news_group_i18n`
--
ALTER TABLE `cms_news_group_i18n`
  ADD PRIMARY KEY (`cms_news_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_news_i18n`
--
ALTER TABLE `cms_news_i18n`
  ADD PRIMARY KEY (`cms_news_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_page`
--
ALTER TABLE `cms_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cms_layout_id` (`cms_layout_id`);

--
-- Index pour la table `cms_page_content`
--
ALTER TABLE `cms_page_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cms_page_id_2` (`cms_page_id`,`index`),
  ADD KEY `cms_page_id` (`cms_page_id`);

--
-- Index pour la table `cms_page_content_i18n`
--
ALTER TABLE `cms_page_content_i18n`
  ADD PRIMARY KEY (`cms_page_content_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_page_i18n`
--
ALTER TABLE `cms_page_i18n`
  ADD PRIMARY KEY (`cms_page_id`,`i18n_id`),
  ADD UNIQUE KEY `language_2` (`i18n_id`,`slug`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_simple_menu`
--
ALTER TABLE `cms_simple_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `position` (`position`,`cms_simple_menu_group_id`),
  ADD KEY `cms_simple_menu_group_id` (`cms_simple_menu_group_id`);

--
-- Index pour la table `cms_simple_menu_group`
--
ALTER TABLE `cms_simple_menu_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cms_simple_menu_group_i18n`
--
ALTER TABLE `cms_simple_menu_group_i18n`
  ADD PRIMARY KEY (`cms_simple_menu_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_simple_menu_i18n`
--
ALTER TABLE `cms_simple_menu_i18n`
  ADD PRIMARY KEY (`cms_simple_menu_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_social`
--
ALTER TABLE `cms_social`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cms_social_i18n`
--
ALTER TABLE `cms_social_i18n`
  ADD PRIMARY KEY (`cms_social_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_widget`
--
ALTER TABLE `cms_widget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cms_widget_group_id` (`cms_widget_group_id`);

--
-- Index pour la table `cms_widget_group`
--
ALTER TABLE `cms_widget_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cms_widget_group_i18n`
--
ALTER TABLE `cms_widget_group_i18n`
  ADD PRIMARY KEY (`cms_widget_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `cms_widget_i18n`
--
ALTER TABLE `cms_widget_i18n`
  ADD PRIMARY KEY (`cms_widget_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`third_id`),
  ADD KEY `index2` (`company_type`);

--
-- Index pour la table `company_contact`
--
ALTER TABLE `company_contact`
  ADD PRIMARY KEY (`company_id`,`person_id`),
  ADD KEY `fk_contact_2_idx` (`person_id`);

--
-- Index pour la table `company_type`
--
ALTER TABLE `company_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `company_type_i18n`
--
ALTER TABLE `company_type_i18n`
  ADD PRIMARY KEY (`company_type_id`,`i18n_id`),
  ADD KEY `fk_society_type_i18n_1_idx` (`i18n_id`);

--
-- Index pour la table `cross_selling`
--
ALTER TABLE `cross_selling`
  ADD PRIMARY KEY (`variant_id_1`,`variant_id_2`),
  ADD KEY `fk_variant_has_variant_variant2_idx` (`variant_id_2`),
  ADD KEY `fk_variant_has_variant_variant1_idx` (`variant_id_1`),
  ADD KEY `fk_cross_selling_discount1_idx` (`discount_id`);

--
-- Index pour la table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `interface_setting`
--
ALTER TABLE `interface_setting`
  ADD PRIMARY KEY (`interface_id`,`user_id`),
  ADD KEY `person_id` (`user_id`);

--
-- Index pour la table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `language_group`
--
ALTER TABLE `language_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `language_group_i18n`
--
ALTER TABLE `language_group_i18n`
  ADD PRIMARY KEY (`language_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `language_group_language`
--
ALTER TABLE `language_group_language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `language_group_id_2` (`language_group_id`,`language_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Index pour la table `language_i18n`
--
ALTER TABLE `language_i18n`
  ADD PRIMARY KEY (`language_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `logistic_strategy`
--
ALTER TABLE `logistic_strategy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock_strategy_supplier1_idx` (`supplier_id`);

--
-- Index pour la table `logistic_strategy_i18n`
--
ALTER TABLE `logistic_strategy_i18n`
  ADD PRIMARY KEY (`logistic_strategy_id`,`i18n_id`),
  ADD KEY `fk_stock_strategy_i18n_language1_idx` (`i18n_id`);

--
-- Index pour la table `mail_sending_role`
--
ALTER TABLE `mail_sending_role`
  ADD PRIMARY KEY (`person_id`,`mail_template_id`,`mail_send_role_id`),
  ADD KEY `mail_template_id` (`mail_template_id`),
  ADD KEY `mail_send_role_id` (`mail_send_role_id`);

--
-- Index pour la table `mail_send_role`
--
ALTER TABLE `mail_send_role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mail_send_role_i18n`
--
ALTER TABLE `mail_send_role_i18n`
  ADD PRIMARY KEY (`mail_send_role_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `mail_template`
--
ALTER TABLE `mail_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_template_type_id` (`mail_template_group_id`);

--
-- Index pour la table `mail_template_group`
--
ALTER TABLE `mail_template_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mail_template_group_i18n`
--
ALTER TABLE `mail_template_group_i18n`
  ADD PRIMARY KEY (`mail_template_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `mail_template_i18n`
--
ALTER TABLE `mail_template_i18n`
  ADD PRIMARY KEY (`mail_template_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_media_media_type1_idx` (`media_type_id`);

--
-- Index pour la table `media_i18n`
--
ALTER TABLE `media_i18n`
  ADD PRIMARY KEY (`media_id`,`i18n_id`),
  ADD KEY `fk_media_i18n_media1_idx` (`media_id`),
  ADD KEY `fk_media_i18n_language1` (`i18n_id`);

--
-- Index pour la table `media_type`
--
ALTER TABLE `media_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `media_type_i18n`
--
ALTER TABLE `media_type_i18n`
  ADD PRIMARY KEY (`media_type_id`,`i18n_id`),
  ADD KEY `fk_media_i18n_copy1_media_type1_idx` (`media_type_id`),
  ADD KEY `fk_media_i18n_language10` (`i18n_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `message_category_id` (`message_group_id`,`source`),
  ADD KEY `category_id` (`message_group_id`);

--
-- Index pour la table `message_group`
--
ALTER TABLE `message_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message_group_i18n`
--
ALTER TABLE `message_group_i18n`
  ADD PRIMARY KEY (`message_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `message_i18n`
--
ALTER TABLE `message_i18n`
  ADD PRIMARY KEY (`message_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`third_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `default_language` (`default_language`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `gender_id` (`gender_id`);

--
-- Index pour la table `person_gender`
--
ALTER TABLE `person_gender`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `person_gender_i18n`
--
ALTER TABLE `person_gender_i18n`
  ADD PRIMARY KEY (`gender_id`,`i18n_id`),
  ADD KEY `fk_gender_i18n_2_idx` (`i18n_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_product1_idx` (`alternative_product`),
  ADD KEY `fk_product_category1_idx` (`catalog_category_id`),
  ADD KEY `fk_product_category2_idx` (`google_category_id`),
  ADD KEY `fk_product_category3_idx` (`stats_category_id`),
  ADD KEY `fk_product_category4_idx` (`accountant_category_id`),
  ADD KEY `fk_product_brand1_idx` (`brand_id`),
  ADD KEY `fk_product_supplier1_idx` (`supplier_id`);

--
-- Index pour la table `product_i18n`
--
ALTER TABLE `product_i18n`
  ADD PRIMARY KEY (`product_id`,`i18n_id`),
  ADD KEY `fk_product_i18n_product1_idx` (`product_id`),
  ADD KEY `fk_product_i18n_language1_idx` (`i18n_id`);

--
-- Index pour la table `product_media`
--
ALTER TABLE `product_media`
  ADD PRIMARY KEY (`product_id`,`media_id`),
  ADD KEY `fk_product_has_media_media1_idx` (`media_id`),
  ADD KEY `fk_product_has_media_product_idx` (`product_id`);

--
-- Index pour la table `rbac_permission`
--
ALTER TABLE `rbac_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `rbac_permission_i18n`
--
ALTER TABLE `rbac_permission_i18n`
  ADD PRIMARY KEY (`rbac_permission_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `rbac_role`
--
ALTER TABLE `rbac_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `rbac_role_i18n`
--
ALTER TABLE `rbac_role_i18n`
  ADD PRIMARY KEY (`rbac_role_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `rbac_role_permission`
--
ALTER TABLE `rbac_role_permission`
  ADD PRIMARY KEY (`rbac_role_id`,`rbac_permission_id`),
  ADD KEY `rbac_permission_id` (`rbac_permission_id`);

--
-- Index pour la table `rbac_user_role`
--
ALTER TABLE `rbac_user_role`
  ADD PRIMARY KEY (`user_id`,`rbac_role_id`),
  ADD KEY `rbac_role_id` (`rbac_role_id`);

--
-- Index pour la table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `third`
--
ALTER TABLE `third`
  ADD PRIMARY KEY (`id`,`role_id`),
  ADD KEY `index2` (`role_id`);

--
-- Index pour la table `third_role`
--
ALTER TABLE `third_role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `third_role_i18n`
--
ALTER TABLE `third_role_i18n`
  ADD PRIMARY KEY (`third_role_id`,`i18n_id`),
  ADD KEY `fk_third_role_i18n_1_idx` (`i18n_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`username`);

--
-- Index pour la table `variable`
--
ALTER TABLE `variable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_param` (`variable_group_id`,`name`);

--
-- Index pour la table `variable_group`
--
ALTER TABLE `variable_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `variable_group_i18n`
--
ALTER TABLE `variable_group_i18n`
  ADD PRIMARY KEY (`variable_group_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `variable_i18n`
--
ALTER TABLE `variable_i18n`
  ADD PRIMARY KEY (`variable_id`,`i18n_id`),
  ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attribute_has_product_product1_idx` (`product_id`),
  ADD KEY `fk_variant_discount1_idx` (`discount_id`),
  ADD KEY `fk_variant_stock_strategy1_idx` (`logistic_strategy_id`);

--
-- Index pour la table `variant_attribute`
--
ALTER TABLE `variant_attribute`
  ADD PRIMARY KEY (`variant_id`,`attribute_id`),
  ADD KEY `fk_variation_has_attribute_attribute1_idx` (`attribute_id`),
  ADD KEY `fk_variation_has_attribute_variation1_idx` (`variant_id`);

--
-- Index pour la table `variant_i18n`
--
ALTER TABLE `variant_i18n`
  ADD PRIMARY KEY (`variant_id`,`i18n_id`),
  ADD KEY `fk_variation_i18n_variation1_idx` (`variant_id`),
  ADD KEY `fk_variant_i18n_language1_idx` (`i18n_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `address_type`
--
ALTER TABLE `address_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the attribute',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `attribute_type`
--
ALTER TABLE `attribute_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the attribute type',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the brand',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `bundle`
--
ALTER TABLE `bundle`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the bundle';
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the category, ',AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `cms_image`
--
ALTER TABLE `cms_image`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `cms_image_group`
--
ALTER TABLE `cms_image_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `cms_layout`
--
ALTER TABLE `cms_layout`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `cms_news`
--
ALTER TABLE `cms_news`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `cms_news_group`
--
ALTER TABLE `cms_news_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `cms_page`
--
ALTER TABLE `cms_page`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT pour la table `cms_page_content`
--
ALTER TABLE `cms_page_content`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT pour la table `cms_simple_menu`
--
ALTER TABLE `cms_simple_menu`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `cms_simple_menu_group`
--
ALTER TABLE `cms_simple_menu_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `cms_social`
--
ALTER TABLE `cms_social`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `cms_widget`
--
ALTER TABLE `cms_widget`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `cms_widget_group`
--
ALTER TABLE `cms_widget_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `company_type`
--
ALTER TABLE `company_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the discount',AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `language_group`
--
ALTER TABLE `language_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `language_group_i18n`
--
ALTER TABLE `language_group_i18n`
  MODIFY `language_group_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `language_group_language`
--
ALTER TABLE `language_group_language`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `logistic_strategy`
--
ALTER TABLE `logistic_strategy`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the logistic strategy',AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `mail_send_role`
--
ALTER TABLE `mail_send_role`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `mail_template_group`
--
ALTER TABLE `mail_template_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the media',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `media_type`
--
ALTER TABLE `media_type`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the media type',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=761;
--
-- AUTO_INCREMENT pour la table `message_group`
--
ALTER TABLE `message_group`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `person_gender`
--
ALTER TABLE `person_gender`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the product',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `rbac_permission`
--
ALTER TABLE `rbac_permission`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT pour la table `rbac_role`
--
ALTER TABLE `rbac_role`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the supplier',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `third`
--
ALTER TABLE `third`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT pour la table `third_role`
--
ALTER TABLE `third_role`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `variable`
--
ALTER TABLE `variable`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT pour la table `variable_group`
--
ALTER TABLE `variable_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `variant`
--
ALTER TABLE `variant`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of the variant',AUTO_INCREMENT=16;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_1` FOREIGN KEY (`address_type_id`) REFERENCES `address_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_address_2` FOREIGN KEY (`third_id`) REFERENCES `third` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `address_type_i18n`
--
ALTER TABLE `address_type_i18n`
  ADD CONSTRAINT `fk_address_type_i18n_1` FOREIGN KEY (`address_type_id`) REFERENCES `address_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_address_type_i18n_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `attribute`
--
ALTER TABLE `attribute`
  ADD CONSTRAINT `fk_attribute_attribute_type1` FOREIGN KEY (`attribute_type_id`) REFERENCES `attribute_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `attribute_i18n`
--
ALTER TABLE `attribute_i18n`
  ADD CONSTRAINT `fk_attribute_i18n_attribute1` FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attribute_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `attribute_type_i18n`
--
ALTER TABLE `attribute_type_i18n`
  ADD CONSTRAINT `fk_attribute_type_i18n_attribute_type1` FOREIGN KEY (`attribute_type_id`) REFERENCES `attribute_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attribute_type_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `bundle`
--
ALTER TABLE `bundle`
  ADD CONSTRAINT `fk_bundle_variant1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_has_variant_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_has_variant_variant1` FOREIGN KEY (`bundle_variant`) REFERENCES `variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_category1` FOREIGN KEY (`parent`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `category_i18n`
--
ALTER TABLE `category_i18n`
  ADD CONSTRAINT `category_i18n_ibfk_1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_i18n_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `cms_image`
--
ALTER TABLE `cms_image`
  ADD CONSTRAINT `cms_image_ibfk_1` FOREIGN KEY (`cms_image_group_id`) REFERENCES `cms_image_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_image_group_i18n`
--
ALTER TABLE `cms_image_group_i18n`
  ADD CONSTRAINT `cms_image_group_i18n_ibfk_1` FOREIGN KEY (`cms_image_group_id`) REFERENCES `cms_image_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_image_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_image_i18n`
--
ALTER TABLE `cms_image_i18n`
  ADD CONSTRAINT `cms_image_i18n_ibfk_1` FOREIGN KEY (`cms_image_id`) REFERENCES `cms_image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_image_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_layout_i18n`
--
ALTER TABLE `cms_layout_i18n`
  ADD CONSTRAINT `cms_layout_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_layout_i18n_ibfk_3` FOREIGN KEY (`cms_layout_id`) REFERENCES `cms_layout` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_news`
--
ALTER TABLE `cms_news`
  ADD CONSTRAINT `cms_news_ibfk_1` FOREIGN KEY (`cms_news_group_id`) REFERENCES `cms_news_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_news_group_i18n`
--
ALTER TABLE `cms_news_group_i18n`
  ADD CONSTRAINT `cms_news_group_i18n_ibfk_1` FOREIGN KEY (`cms_news_group_id`) REFERENCES `cms_news_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_news_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_news_i18n`
--
ALTER TABLE `cms_news_i18n`
  ADD CONSTRAINT `cms_news_i18n_ibfk_1` FOREIGN KEY (`cms_news_id`) REFERENCES `cms_news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_news_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_page`
--
ALTER TABLE `cms_page`
  ADD CONSTRAINT `cms_page_ibfk_1` FOREIGN KEY (`cms_layout_id`) REFERENCES `cms_layout` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_page_content`
--
ALTER TABLE `cms_page_content`
  ADD CONSTRAINT `cms_page_content_ibfk_2` FOREIGN KEY (`cms_page_id`) REFERENCES `cms_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_page_content_i18n`
--
ALTER TABLE `cms_page_content_i18n`
  ADD CONSTRAINT `cms_page_content_i18n_ibfk_1` FOREIGN KEY (`cms_page_content_id`) REFERENCES `cms_page_content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_page_content_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_page_i18n`
--
ALTER TABLE `cms_page_i18n`
  ADD CONSTRAINT `cms_page_i18n_ibfk_1` FOREIGN KEY (`cms_page_id`) REFERENCES `cms_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_page_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_simple_menu`
--
ALTER TABLE `cms_simple_menu`
  ADD CONSTRAINT `cms_simple_menu_ibfk_1` FOREIGN KEY (`cms_simple_menu_group_id`) REFERENCES `cms_simple_menu_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_simple_menu_group_i18n`
--
ALTER TABLE `cms_simple_menu_group_i18n`
  ADD CONSTRAINT `cms_simple_menu_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_simple_menu_group_i18n_ibfk_3` FOREIGN KEY (`cms_simple_menu_group_id`) REFERENCES `cms_simple_menu_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_simple_menu_i18n`
--
ALTER TABLE `cms_simple_menu_i18n`
  ADD CONSTRAINT `cms_simple_menu_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_simple_menu_i18n_ibfk_3` FOREIGN KEY (`cms_simple_menu_id`) REFERENCES `cms_simple_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_social_i18n`
--
ALTER TABLE `cms_social_i18n`
  ADD CONSTRAINT `cms_social_i18n_ibfk_1` FOREIGN KEY (`cms_social_id`) REFERENCES `cms_social` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_social_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_widget`
--
ALTER TABLE `cms_widget`
  ADD CONSTRAINT `cms_widget_ibfk_1` FOREIGN KEY (`cms_widget_group_id`) REFERENCES `cms_widget_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_widget_group_i18n`
--
ALTER TABLE `cms_widget_group_i18n`
  ADD CONSTRAINT `cms_widget_group_i18n_ibfk_1` FOREIGN KEY (`cms_widget_group_id`) REFERENCES `cms_widget_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_widget_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms_widget_i18n`
--
ALTER TABLE `cms_widget_i18n`
  ADD CONSTRAINT `cms_widget_i18n_ibfk_1` FOREIGN KEY (`cms_widget_id`) REFERENCES `cms_widget` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_widget_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`company_type`) REFERENCES `company_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_society_2` FOREIGN KEY (`third_id`) REFERENCES `third` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `company_contact`
--
ALTER TABLE `company_contact`
  ADD CONSTRAINT `company_contact_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`third_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contact_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`third_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `company_type_i18n`
--
ALTER TABLE `company_type_i18n`
  ADD CONSTRAINT `company_type_i18n_ibfk_1` FOREIGN KEY (`company_type_id`) REFERENCES `company_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_society_type_i18n_1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cross_selling`
--
ALTER TABLE `cross_selling`
  ADD CONSTRAINT `fk_cross_selling_discount1` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_has_variant_variant1` FOREIGN KEY (`variant_id_1`) REFERENCES `variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_has_variant_variant2` FOREIGN KEY (`variant_id_2`) REFERENCES `variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `interface_setting`
--
ALTER TABLE `interface_setting`
  ADD CONSTRAINT `interface_setting_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `language_group_i18n`
--
ALTER TABLE `language_group_i18n`
  ADD CONSTRAINT `language_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `language_group_i18n_ibfk_3` FOREIGN KEY (`language_group_id`) REFERENCES `language_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `language_group_language`
--
ALTER TABLE `language_group_language`
  ADD CONSTRAINT `language_group_language_ibfk_1` FOREIGN KEY (`language_group_id`) REFERENCES `language_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `language_group_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `language_i18n`
--
ALTER TABLE `language_i18n`
  ADD CONSTRAINT `language_i18n_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `logistic_strategy`
--
ALTER TABLE `logistic_strategy`
  ADD CONSTRAINT `fk_stock_strategy_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `logistic_strategy_i18n`
--
ALTER TABLE `logistic_strategy_i18n`
  ADD CONSTRAINT `fk_stock_strategy_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stock_strategy_i18n_stock_strategy1` FOREIGN KEY (`logistic_strategy_id`) REFERENCES `logistic_strategy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mail_sending_role`
--
ALTER TABLE `mail_sending_role`
  ADD CONSTRAINT `mail_sending_role_ibfk_5` FOREIGN KEY (`mail_template_id`) REFERENCES `mail_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mail_sending_role_ibfk_6` FOREIGN KEY (`mail_send_role_id`) REFERENCES `mail_send_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mail_sending_role_ibfk_7` FOREIGN KEY (`person_id`) REFERENCES `person` (`third_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mail_send_role_i18n`
--
ALTER TABLE `mail_send_role_i18n`
  ADD CONSTRAINT `mail_send_role_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mail_send_role_i18n_ibfk_5` FOREIGN KEY (`mail_send_role_id`) REFERENCES `mail_send_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mail_template`
--
ALTER TABLE `mail_template`
  ADD CONSTRAINT `mail_template_ibfk_2` FOREIGN KEY (`mail_template_group_id`) REFERENCES `mail_template_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mail_template_group_i18n`
--
ALTER TABLE `mail_template_group_i18n`
  ADD CONSTRAINT `mail_template_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mail_template_group_i18n_ibfk_5` FOREIGN KEY (`mail_template_group_id`) REFERENCES `mail_template_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mail_template_i18n`
--
ALTER TABLE `mail_template_i18n`
  ADD CONSTRAINT `mail_template_i18n_ibfk_3` FOREIGN KEY (`mail_template_id`) REFERENCES `mail_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mail_template_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `fk_media_media_type1` FOREIGN KEY (`media_type_id`) REFERENCES `media_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `media_i18n`
--
ALTER TABLE `media_i18n`
  ADD CONSTRAINT `fk_media_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_media_i18n_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `media_type_i18n`
--
ALTER TABLE `media_type_i18n`
  ADD CONSTRAINT `fk_media_i18n_copy1_media_type1` FOREIGN KEY (`media_type_id`) REFERENCES `media_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_media_i18n_language10` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`message_group_id`) REFERENCES `message_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message_group_i18n`
--
ALTER TABLE `message_group_i18n`
  ADD CONSTRAINT `message_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_group_i18n_ibfk_5` FOREIGN KEY (`message_group_id`) REFERENCES `message_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message_i18n`
--
ALTER TABLE `message_i18n`
  ADD CONSTRAINT `message_i18n_ibfk_6` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_i18n_ibfk_7` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person_1` FOREIGN KEY (`gender_id`) REFERENCES `person_gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_person_2` FOREIGN KEY (`third_id`) REFERENCES `third` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`default_language`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `person_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `person_gender_i18n`
--
ALTER TABLE `person_gender_i18n`
  ADD CONSTRAINT `fk_gender_i18n_1` FOREIGN KEY (`gender_id`) REFERENCES `person_gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gender_i18n_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_brand1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_category1` FOREIGN KEY (`catalog_category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category2` FOREIGN KEY (`google_category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category3` FOREIGN KEY (`stats_category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category4` FOREIGN KEY (`accountant_category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_product1` FOREIGN KEY (`alternative_product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `product_i18n`
--
ALTER TABLE `product_i18n`
  ADD CONSTRAINT `fk_product_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_i18n_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_media`
--
ALTER TABLE `product_media`
  ADD CONSTRAINT `fk_product_has_media_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_has_media_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rbac_permission_i18n`
--
ALTER TABLE `rbac_permission_i18n`
  ADD CONSTRAINT `rbac_permission_i18n_ibfk_1` FOREIGN KEY (`rbac_permission_id`) REFERENCES `rbac_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rbac_permission_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rbac_role_i18n`
--
ALTER TABLE `rbac_role_i18n`
  ADD CONSTRAINT `rbac_role_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rbac_role_i18n_ibfk_5` FOREIGN KEY (`rbac_role_id`) REFERENCES `rbac_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rbac_role_permission`
--
ALTER TABLE `rbac_role_permission`
  ADD CONSTRAINT `rbac_role_permission_ibfk_1` FOREIGN KEY (`rbac_role_id`) REFERENCES `rbac_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rbac_role_permission_ibfk_2` FOREIGN KEY (`rbac_permission_id`) REFERENCES `rbac_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rbac_user_role`
--
ALTER TABLE `rbac_user_role`
  ADD CONSTRAINT `rbac_user_role_ibfk_2` FOREIGN KEY (`rbac_role_id`) REFERENCES `rbac_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rbac_user_role_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `third`
--
ALTER TABLE `third`
  ADD CONSTRAINT `fk_third_1` FOREIGN KEY (`role_id`) REFERENCES `third_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `third_role_i18n`
--
ALTER TABLE `third_role_i18n`
  ADD CONSTRAINT `fk_third_role_i18n_1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_third_role_i18n_2` FOREIGN KEY (`third_role_id`) REFERENCES `third_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `variable`
--
ALTER TABLE `variable`
  ADD CONSTRAINT `variable_ibfk_1` FOREIGN KEY (`variable_group_id`) REFERENCES `variable_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `variable_group_i18n`
--
ALTER TABLE `variable_group_i18n`
  ADD CONSTRAINT `variable_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `variable_group_i18n_ibfk_5` FOREIGN KEY (`variable_group_id`) REFERENCES `variable_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `variable_i18n`
--
ALTER TABLE `variable_i18n`
  ADD CONSTRAINT `variable_i18n_ibfk_4` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `variable_i18n_ibfk_5` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `variant`
--
ALTER TABLE `variant`
  ADD CONSTRAINT `fk_attribute_has_product_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_discount1` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_variant_stock_strategy1` FOREIGN KEY (`logistic_strategy_id`) REFERENCES `logistic_strategy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `variant_attribute`
--
ALTER TABLE `variant_attribute`
  ADD CONSTRAINT `fk_variation_has_attribute_attribute1` FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `variant_attribute_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `variant_i18n`
--
ALTER TABLE `variant_i18n`
  ADD CONSTRAINT `fk_variant_i18n_language1` FOREIGN KEY (`i18n_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_variation_i18n_variation1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
