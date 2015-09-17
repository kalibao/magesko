-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 17 Septembre 2015 à 09:44
-- Version du serveur :  5.5.41-0ubuntu0.14.04.1
-- Version de PHP :  5.5.9-1ubuntu4.7


--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `message_group_id`, `source`, `created_at`, `updated_at`) VALUES
(786, 2, 'branch:affiliation', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(785, 2, 'branch:affiliation_category_id', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(784, 2, 'branch:google_shopping', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(783, 2, 'branch:google_shopping_category_id', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(782, 2, 'branch:unfold', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(781, 2, 'branch:big_menu_only_first_level', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(780, 2, 'branch:display_brands_types', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(779, 2, 'branch:offset', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(778, 2, 'branch:presentation_type', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(777, 2, 'branch:background', '0000-00-00 00:00:00', '2015-09-15 23:31:48'),
(776, 2, 'branch:visible', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(775, 2, 'branch:media_id', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(774, 2, 'branch:order', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(773, 2, 'branch:parent', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(772, 2, 'branch:tree_id', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(771, 2, 'branch:branch_type_id', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(770, 2, 'branch:id', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(769, 2, 'branch_i18n:h1_tag', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(768, 2, 'branch_i18n:meta_keywords', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(767, 2, 'branch_i18n:meta_description', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(766, 2, 'branch_i18n:meta_title', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(765, 2, 'branch_i18n:url', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(764, 2, 'branch_i18n:description', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(763, 2, 'branch_i18n:label', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(787, 2, 'branch_i18n:i18n_id', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(788, 2, 'branch_i18n:branch_id', '0000-00-00 00:00:00', '0000-00-00 00:00:00');


--
-- Contenu de la table `message_i18n`
--

INSERT INTO `message_i18n` (`message_id`, `i18n_id`, `translation`) VALUES
(786, 'fr', 'Affiliation'),
(786, 'en', 'Affiliation'),
(785, 'fr', 'Catégorie Affiliation'),
(785, 'en', 'Affiliation category'),
(784, 'fr', 'Google Shopping'),
(784, 'en', 'Google Shopping'),
(783, 'fr', 'Catégorie Google shopping'),
(783, 'en', 'Google shopping category'),
(782, 'fr', 'Forcer l''ouverture au niveau 2'),
(782, 'en', 'Open 2nd level'),
(781, 'fr', 'big_menu_only_first_level'),
(781, 'en', 'big_menu_only_first_level'),
(780, 'fr', 'Affichage marque/type'),
(780, 'en', 'Display brand/type'),
(779, 'fr', 'Offset'),
(779, 'en', 'Offset'),
(778, 'fr', 'Mode d''affichage'),
(778, 'en', 'Display mode'),
(777, 'fr', 'Couleur de fond'),
(777, 'en', 'Background color'),
(776, 'fr', 'Visible'),
(776, 'en', 'Visible'),
(775, 'fr', 'Media lié'),
(775, 'en', 'Linked media'),
(774, 'fr', 'Ordre'),
(774, 'en', 'Order'),
(773, 'fr', 'Parent'),
(773, 'en', 'Parent'),
(772, 'fr', 'Id de l''arbre'),
(772, 'en', 'Tree id'),
(771, 'fr', 'Type de branche'),
(771, 'en', 'Branch type'),
(770, 'fr', 'Branche'),
(770, 'en', 'Branch'),
(769, 'fr', 'Balise H1'),
(769, 'en', 'H1 tag'),
(768, 'fr', 'Meta keywords'),
(768, 'en', 'Meta keywords'),
(767, 'fr', 'Meta description'),
(767, 'en', 'Meta description'),
(766, 'fr', 'Meta title'),
(766, 'en', 'Meta title'),
(765, 'fr', 'Url'),
(765, 'en', 'Url'),
(764, 'fr', 'Description'),
(764, 'en', 'Description'),
(763, 'fr', 'Nom de la branche'),
(763, 'en', 'Branch name'),
(788, 'fr', 'Langage'),
(788, 'en', 'Language'),
(787, 'fr', 'Branche'),
(787, 'en', 'Branch');

