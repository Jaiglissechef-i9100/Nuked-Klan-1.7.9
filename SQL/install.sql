-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 10 Novembre 2012 à 16:57
-- Version du serveur: 5.5.28-1~dotdeb.0-log
-- Version de PHP: 5.3.18-1~dotdeb.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

--
-- Base de données: `NK-179`
--

-- --------------------------------------------------------

--
-- Structure de la table `nuked_action`
--

DROP TABLE IF EXISTS `nuked_action`;
CREATE TABLE IF NOT EXISTS `nuked_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `pseudo` text COLLATE latin1_general_ci NOT NULL,
  `action` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_annonces`
--

DROP TABLE IF EXISTS `nuked_annonces`;
CREATE TABLE IF NOT EXISTS `nuked_annonces` (
  `artid` int(11) NOT NULL auto_increment,
  `anid` int(11) NOT NULL default '0',
  `title` varchar(40) collate latin1_general_ci NOT NULL default '',
  `content` text collate latin1_general_ci NOT NULL,
  `counter` int(11) NOT NULL default '0',
  `pseudo` text collate latin1_general_ci NOT NULL,
  `email` varchar(40) collate latin1_general_ci NOT NULL default '',
  `ville` varchar(25) collate latin1_general_ci NOT NULL default '',
  `date` varchar(30) collate latin1_general_ci NOT NULL default '',
  `pays` varchar(30) collate latin1_general_ci NOT NULL default '',
  `prix` varchar(10) collate latin1_general_ci NOT NULL default '',
  `duree` varchar(30) collate latin1_general_ci NOT NULL default '',
  `active` char(1) collate latin1_general_ci NOT NULL default '',
  `obsol` varchar(30) collate latin1_general_ci NOT NULL default '',
  `url_screen` varchar(200) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`artid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_annonces_cat`
--

DROP TABLE IF EXISTS `nuked_annonces_cat`;
CREATE TABLE IF NOT EXISTS `nuked_annonces_cat` (
  `anid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `anname` varchar(40) collate latin1_general_ci NOT NULL default '',
  `foto` varchar(80) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`anid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_banlist`
--

DROP TABLE IF EXISTS `nuked_banlist`;
CREATE TABLE IF NOT EXISTS `nuked_banlist` (
  `id` int(11) NOT NULL auto_increment,
  `identifiant` varchar(50) collate latin1_general_ci NOT NULL default '',
  `pseudo` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison` varchar(50) collate latin1_general_ci NOT NULL default '',
  `admin` varchar(50) collate latin1_general_ci NOT NULL default '',
  `date` varchar(50) collate latin1_general_ci NOT NULL default '',
  `serveur` varchar(100) collate latin1_general_ci NOT NULL default '',
  `record` varchar(50) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Structure de la table `nuked_banlist_config`
--

DROP TABLE IF EXISTS `nuked_banlist_config`;
CREATE TABLE IF NOT EXISTS `nuked_banlist_config` (
  `id` int(11) NOT NULL auto_increment,
  `iden` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison1` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison2` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison3` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison4` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison5` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison6` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison7` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison8` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison9` varchar(50) collate latin1_general_ci NOT NULL default '',
  `raison10` varchar(50) collate latin1_general_ci NOT NULL default '',
  `serveur1` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur2` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur3` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur4` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur5` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur6` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur7` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur8` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur9` varchar(100) collate latin1_general_ci NOT NULL default '',
  `serveur10` varchar(100) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_banlist_config`
--

INSERT INTO `nuked_banlist_config` (`id`, `iden`, `raison1`, `raison2`, `raison3`, `raison4`, `raison5`, `raison6`, `raison7`, `raison8`, `raison9`, `raison10`, `serveur1`, `serveur2`, `serveur3`, `serveur4`, `serveur5`, `serveur6`, `serveur7`, `serveur8`, `serveur9`, `serveur10`) VALUES
(1, 'identifiant', 'raison1', 'raison2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_banned`
--

DROP TABLE IF EXISTS `nuked_banned`;
CREATE TABLE IF NOT EXISTS `nuked_banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pseudo` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `dure` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `texte` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_block`
--

DROP TABLE IF EXISTS `nuked_block`;
CREATE TABLE IF NOT EXISTS `nuked_block` (
  `bid` int(10) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '0',
  `position` int(2) NOT NULL DEFAULT '0',
  `module` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `type` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `nivo` int(1) NOT NULL DEFAULT '0',
  `page` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;

--
-- Contenu de la table `nuked_block`
--

INSERT INTO `nuked_block` (`bid`, `active`, `position`, `module`, `titre`, `content`, `type`, `nivo`, `page`) VALUES
(1, 2, 1, '', 'Login', '', 'login', 0, 'Tous'),
(2, 1, 1, '', 'Menu', '[News]|News||0|NEWLINE[Archives]|Archives||0|NEWLINE[Forum]|Forum||0|NEWLINE[Download]|Téléchargements||0|NEWLINE[Members]|Membres||0|NEWLINE[Team]|Team||0|NEWLINE[Defy]|Nous Défier||0|NEWLINE[Recruit]|Recrutement||0|NEWLINE[Sections]|Articles||0|NEWLINE[Server]|Serveurs||0|NEWLINE[Links]|Liens Web||0|NEWLINE[Calendar]|Calendrier||0|NEWLINE[Gallery]|Galerie||0|NEWLINE[Wars]|Matchs||0|NEWLINE[Irc]|IrC||0|NEWLINE[Guestbook]|Livre d''Or||0|NEWLINE[Search]|Recherche||0|NEWLINE|<b>Membre</b>||1|NEWLINE[User]|Compte||1|NEWLINE|<b>Admin</b>||2|NEWLINE[Admin]|Administration||2|', 'menu', 0, 'Tous'),
(3, 1, 2, 'Search', 'Recherche', '', 'module', 0, 'Tous'),
(4, 2, 2, '', 'Sondage', '', 'survey', 0, 'Tous'),
(5, 2, 3, 'Wars', 'Matchs', '', 'module', 0, 'Tous'),
(6, 1, 3, 'Stats', 'Stats', '', 'module', 0, 'Tous'),
(7, 0, 0, 'Irc', 'Irc Awards', '', 'module', 0, 'Tous'),
(8, 0, 0, 'Server', 'Serveur monitor', '', 'module', 0, 'Tous'),
(9, 0, 0, '', 'Suggestion', '', 'suggest', 1, 'Tous'),
(10, 0, 0, 'Textbox', 'Tribune libre', '', 'module', 0, 'Tous'),
(11, 1, 4, '', 'Partenaires', '<div style="text-align: center;padding: 10px;"><a href="http://www.nuked-klan.org" onclick="window.open(this.href); return false;"><img style="border: 0;" src="images/ban.png" alt="" title="Nuked-klaN CMS" /></a></div><div style="text-align: center;padding: 10px;"><a href="http://www.nitroserv.fr" onclick="window.open(this.href); return false;"><img style="border: 0;" src="images/nitroserv.png" alt="" title="Location de serveurs de jeux" /></a></div>', 'html', 0, 'Tous'),
(12, 1, 0, 'Video', 'Nos videos', '', 'module', 0, 'Tous'),
(13, 2, 2, 'Banlist', 'Derniers banni', '', 'module', 1, 'Tous'),
(14, 1, 0, 'Wow_recrutement', 'Recrutement', '', 'module', 0, 'Tous'),
(15, 4, 0, 'Tags', 'Nuage de mots', '', 'module', 0, 'Tous');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_calendar`
--

DROP TABLE IF EXISTS `nuked_calendar`;
CREATE TABLE IF NOT EXISTS `nuked_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `date_jour` int(2) DEFAULT NULL,
  `date_mois` int(2) DEFAULT NULL,
  `date_an` int(4) DEFAULT NULL,
  `heure` varchar(5) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `auteur` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_comment`
--

DROP TABLE IF EXISTS `nuked_comment`;
CREATE TABLE IF NOT EXISTS `nuked_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `im_id` int(100) DEFAULT NULL,
  `autor` text COLLATE latin1_general_ci,
  `autor_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `comment` text COLLATE latin1_general_ci,
  `date` varchar(12) COLLATE latin1_general_ci DEFAULT NULL,
  `autor_ip` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `im_id` (`im_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_comment_mod`
--

DROP TABLE IF EXISTS `nuked_comment_mod`;
CREATE TABLE IF NOT EXISTS `nuked_comment_mod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` text COLLATE latin1_general_ci NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `nuked_comment_mod`
--

INSERT INTO `nuked_comment_mod` (`id`, `module`, `active`) VALUES
(1, 'news', 1),
(2, 'download', 1),
(3, 'links', 1),
(4, 'survey', 1),
(5, 'wars', 1),
(6, 'gallery', 1),
(7, 'sections', 1),
(8, 'video', 0),
(9, 'Steam_ban', 1),
(10, 'gallery_v2', 1),
(11, 'replays', 1);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_config`
--

DROP TABLE IF EXISTS `nuked_config`;
CREATE TABLE IF NOT EXISTS `nuked_config` (
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `value` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_config`
--

INSERT INTO `nuked_config` (`name`, `value`) VALUES
('time_generate', 'on'),
('dateformat', '%d/%m/%Y'),
('datezone', '+0100'),
('version', '1.7.9'),
('date_install', '1352562979'),
('langue', 'french'),
('stats_share', '1'),
('stats_timestamp', '86400'),
('name', 'Nuked-klaN 1.7.9'),
('slogan', 'PHP 4 Gamers'),
('tag_pre', ''),
('tag_suf', ''),
('url', 'http://localhost/nk'),
('mail', 'admin@admin.com'),
('footmessage', ''),
('nk_status', 'open'),
('index_site', 'News'),
('theme', 'Impact_Nk'),
('keyword', ''),
('description', ''),
('inscription', 'on'),
('inscription_mail', ''),
('inscription_avert', ''),
('inscription_charte', ''),
('validation', 'auto'),
('user_delete', 'on'),
('video_editeur', 'on'),
('scayt_editeur', 'on'),
('suggest_avert', ''),
('irc_chan', 'nuked-klan'),
('irc_serv', 'quakenet.org'),
('server_ip', ''),
('server_port', ''),
('server_pass', ''),
('server_game', ''),
('forum_title', ''),
('forum_desc', ''),
('forum_rank_team', 'off'),
('forum_field_max', '10'),
('forum_file', 'on'),
('forum_file_level', '1'),
('forum_file_maxsize', '1000'),
('thread_forum_page', '20'),
('mess_forum_page', '10'),
('hot_topic', '20'),
('post_flood', '10'),
('gallery_title', ''),
('max_img_line', '2'),
('max_img', '6'),
('max_news', '5'),
('max_download', '10'),
('hide_download', 'on'),
('max_liens', '10'),
('max_sections', '10'),
('max_wars', '30'),
('max_archives', '30'),
('max_members', '30'),
('max_shout', '20'),
('mess_guest_page', '10'),
('sond_delay', '24'),
('level_analys', '-1'),
('visit_delay', '10'),
('recrute', '1'),
('recrute_charte', ''),
('recrute_mail', ''),
('recrute_inbox', ''),
('defie_charte', ''),
('defie_mail', ''),
('defie_inbox', ''),
('birthday', 'all'),
('avatar_upload', 'on'),
('avatar_url', 'on'),
('cookiename', 'nuked'),
('sess_inactivemins', '5'),
('sess_days_limit', '365'),
('nbc_timeout', '300'),
('screen', 'on'),
('contact_mail', 'admin@admin.com'),
('contact_flood', '60'),
('forum_cat_prim', 'off'),
('image_forums', 'on'),
('image_cat_mini', 'on'),
('birthday_forum', 'on'),
('gamer_details', 'on'),
('profil_details', 'on'),
('forum_skin', 'Nk-Default'),
('forum_who_primaire', 'oui'),
('forum_who_secondaire', 'oui'),
('forum_who_viewforum', 'oui'),
('forum_who_viewtopic', 'oui'),
('forum_name_primaire', 'oui'),
('forum_name_secondaire', 'oui'),
('forum_name_viewforum', 'oui'),
('forum_name_viewtopic', 'oui'),
('forum_search_primaire', 'oui'),
('forum_search_secondaire', 'oui'),
('forum_search_viewforum', 'oui'),
('forum_search_viewtopic', 'oui'),
('forum_quick_edit', 'non'),
('forum_quick_modo', 'non'),
('forum_quick_user', 'non'),
('Guestbookpost', '0'),
('Guestbooktemplate', '0'),
('max_video', '10'),
('cat_idem', '0'),
('news_forum', '1'),
('img_cat', '100'),
('nb_img_lignes', '3'),
('img_none', 'modules/Annonces/images/no_foto.gif'),
('index_page', ''),
('tags', 'keyword'),
('max_ban', '5'),
('adm_ban', '5'),
('pref1_ban', '5'),
('pref2_ban', '9');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_contact`
--

DROP TABLE IF EXISTS `nuked_contact`;
CREATE TABLE IF NOT EXISTS `nuked_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `message` text COLLATE latin1_general_ci NOT NULL,
  `email` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `nom` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ip` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `titre` (`titre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_defie`
--

DROP TABLE IF EXISTS `nuked_defie`;
CREATE TABLE IF NOT EXISTS `nuked_defie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pseudo` text COLLATE latin1_general_ci NOT NULL,
  `clan` text COLLATE latin1_general_ci NOT NULL,
  `mail` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `icq` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `irc` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pays` text COLLATE latin1_general_ci NOT NULL,
  `date` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `heure` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `serveur` text COLLATE latin1_general_ci NOT NULL,
  `game` int(11) NOT NULL DEFAULT '0',
  `type` text COLLATE latin1_general_ci NOT NULL,
  `map` text COLLATE latin1_general_ci NOT NULL,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_discussion`
--

DROP TABLE IF EXISTS `nuked_discussion`;
CREATE TABLE IF NOT EXISTS `nuked_discussion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `pseudo` text COLLATE latin1_general_ci NOT NULL,
  `texte` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_downloads`
--

DROP TABLE IF EXISTS `nuked_downloads`;
CREATE TABLE IF NOT EXISTS `nuked_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `taille` varchar(6) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `count` int(10) NOT NULL DEFAULT '0',
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url2` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `broke` int(11) NOT NULL DEFAULT '0',
  `url3` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `level` int(1) NOT NULL DEFAULT '0',
  `hit` int(11) NOT NULL DEFAULT '0',
  `edit` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `screen` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `autor` text COLLATE latin1_general_ci NOT NULL,
  `url_autor` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `comp` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_downloads_cat`
--

DROP TABLE IF EXISTS `nuked_downloads_cat`;
CREATE TABLE IF NOT EXISTS `nuked_downloads_cat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `titre` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE latin1_general_ci NOT NULL,
  `level` int(1) NOT NULL DEFAULT '0',
  `position` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_erreursql`
--

DROP TABLE IF EXISTS `nuked_erreursql`;
CREATE TABLE IF NOT EXISTS `nuked_erreursql` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `lien` text COLLATE latin1_general_ci NOT NULL,
  `texte` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_espace_membre`
--

DROP TABLE IF EXISTS `nuked_espace_membre`;
CREATE TABLE IF NOT EXISTS `nuked_espace_membre` (
  `id` int(30) NOT NULL auto_increment,
  `user_id` varchar(200) collate latin1_general_ci NOT NULL default '',
  `pseudo` varchar(60) collate latin1_general_ci NOT NULL default '',
  `fichier` varchar(60) collate latin1_general_ci NOT NULL default '',
  `date` varchar(200) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_espace_membre_commun`
--

DROP TABLE IF EXISTS `nuked_espace_membre_commun`;
CREATE TABLE IF NOT EXISTS `nuked_espace_membre_commun` (
  `id` int(30) NOT NULL auto_increment,
  `user_id` varchar(200) collate latin1_general_ci NOT NULL default '',
  `pseudo` varchar(60) collate latin1_general_ci NOT NULL default '',
  `fichier` varchar(60) collate latin1_general_ci NOT NULL default '',
  `date` varchar(200) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_espace_membre_galerie`
--

DROP TABLE IF EXISTS `nuked_espace_membre_galerie`;
CREATE TABLE IF NOT EXISTS `nuked_espace_membre_galerie` (
  `id` int(30) NOT NULL auto_increment,
  `user_id` varchar(20) collate latin1_general_ci NOT NULL default '',
  `value` varchar(20) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_espace_membre_prefs`
--

DROP TABLE IF EXISTS `nuked_espace_membre_prefs`;
CREATE TABLE IF NOT EXISTS `nuked_espace_membre_prefs` (
  `id` int(30) NOT NULL auto_increment,
  `nom` varchar(20) collate latin1_general_ci NOT NULL default '',
  `value` varchar(20) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Contenu de la table `nuked_espace_membre_prefs`
--

INSERT INTO `nuked_espace_membre_prefs` (`id`, `nom`, `value`) VALUES
(1, 'nb_img', '5'),
(2, 'galerie', 'on'),
(3, 'nb_fichier', '10'),
(4, 'nb_membre', '5'),
(5, 'max_upload', '2'),
(6, 'niveau_upload', '2'),
(7, 'nb_quotas', '5'),
(8, 'nb_quotas_commun', '20');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_espace_membre_statu`
--

DROP TABLE IF EXISTS `nuked_espace_membre_statu`;
CREATE TABLE IF NOT EXISTS `nuked_espace_membre_statu` (
  `id` int(30) NOT NULL auto_increment,
  `nom` varchar(10) collate latin1_general_ci NOT NULL default '',
  `statu` char(1) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Contenu de la table `nuked_espace_membre_statu`
--

INSERT INTO `nuked_espace_membre_statu` (`id`, `nom`, `statu`) VALUES
(1, 'bmp', '1'),
(2, 'gif', '1'),
(3, 'png', '1'),
(4, 'jpg', '1'),
(5, 'jpeg', '1'),
(6, 'zip', '1'),
(7, 'rar', '1'),
(8, 'ace', '1');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_facebook`
--

DROP TABLE IF EXISTS `nuked_facebook`;
CREATE TABLE IF NOT EXISTS `nuked_facebook` (
  `id` int(11) NOT NULL auto_increment,
  `id_facebook` varchar(30) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_faqs`
--

DROP TABLE IF EXISTS `nuked_faqs`;
CREATE TABLE IF NOT EXISTS `nuked_faqs` (
  `id` int(10) NOT NULL auto_increment,
  `questions` text collate latin1_general_ci NOT NULL,
  `reponses` text collate latin1_general_ci NOT NULL,
  `cat` int(11) NOT NULL default '0',
  `date` varchar(30) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_faqs_cat
--

DROP TABLE IF EXISTS `nuked_faqs_cat`;
CREATE TABLE IF NOT EXISTS `nuked_faqs_cat` (
  `cid` int(11) NOT NULL auto_increment,
  `titre` varchar(50) collate latin1_general_ci NOT NULL default '',
  `image` text collate latin1_general_ci,
  PRIMARY KEY  (`cid`),
  KEY `titre` (`titre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums`
--

DROP TABLE IF EXISTS `nuked_forums`;
CREATE TABLE IF NOT EXISTS `nuked_forums` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cat` int(11) NOT NULL DEFAULT '0',
  `nom` text COLLATE latin1_general_ci NOT NULL,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  `moderateurs` text COLLATE latin1_general_ci NOT NULL,
  `niveau` int(1) NOT NULL DEFAULT '0',
  `level` int(1) NOT NULL DEFAULT '0',
  `ordre` int(5) NOT NULL DEFAULT '0',
  `level_poll` int(1) NOT NULL DEFAULT '0',
  `level_vote` int(1) NOT NULL DEFAULT '0',
  `image` varchar(200) collate latin1_general_ci default NULL,
  PRIMARY KEY (`id`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_forums`
--

INSERT INTO `nuked_forums` (`id`, `cat`, `nom`, `comment`, `moderateurs`, `niveau`, `level`, `ordre`, `level_poll`, `level_vote`) VALUES
(1, 1, 'Forum', 'Test Forum', '', 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_cat`
--

DROP TABLE IF EXISTS `nuked_forums_cat`;
CREATE TABLE IF NOT EXISTS `nuked_forums_cat` (
  `id` int(11) NOT NULL auto_increment,
  `cat_primaire` int(5) NOT NULL default '0',
  `nom` varchar(100) collate latin1_general_ci default NULL,
  `level` int(1) NOT NULL default '0',
  `ordre` int(5) NOT NULL default '0',
  `niveau` int(1) NOT NULL default '0',
  `moderateurs` text collate latin1_general_ci NOT NULL,
  `comment` text collate latin1_general_ci NOT NULL,
  `image` varchar(200) collate latin1_general_ci default NULL,
  `imagemini` varchar(200) collate latin1_general_ci default NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_forums_cat`
--

INSERT INTO `nuked_forums_cat` (`id`, `nom`, `ordre`, `niveau`) VALUES
(1, 'Categorie 1', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_messages`
--

DROP TABLE IF EXISTS `nuked_forums_messages`;
CREATE TABLE IF NOT EXISTS `nuked_forums_messages` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `txt` text COLLATE latin1_general_ci NOT NULL,
  `date` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `edition` text COLLATE latin1_general_ci NOT NULL,
  `auteur` text COLLATE latin1_general_ci NOT NULL,
  `auteur_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `auteur_ip` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `bbcodeoff` int(1) NOT NULL DEFAULT '0',
  `smileyoff` int(1) NOT NULL DEFAULT '0',
  `cssoff` int(1) NOT NULL DEFAULT '0',
  `usersig` int(1) NOT NULL DEFAULT '0',
  `emailnotify` int(1) NOT NULL DEFAULT '0',
  `thread_id` int(5) NOT NULL DEFAULT '0',
  `forum_id` mediumint(10) NOT NULL DEFAULT '0',
  `file` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `auteur_id` (`auteur_id`),
  KEY `thread_id` (`thread_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_options`
--

DROP TABLE IF EXISTS `nuked_forums_options`;
CREATE TABLE IF NOT EXISTS `nuked_forums_options` (
  `id` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  `option_text` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `option_vote` int(11) NOT NULL DEFAULT '0',
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_poll`
--

DROP TABLE IF EXISTS `nuked_forums_poll`;
CREATE TABLE IF NOT EXISTS `nuked_forums_poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL DEFAULT '0',
  `titre` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_primaire`
--

DROP TABLE IF EXISTS `nuked_forums_primaire`;
CREATE TABLE IF NOT EXISTS `nuked_forums_primaire` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(100) collate latin1_general_ci default NULL,
  `ordre` int(5) NOT NULL default '0',
  `niveau` int(1) NOT NULL default '0',
  `image` varchar(200) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_rank`
--

DROP TABLE IF EXISTS `nuked_forums_rank`;
CREATE TABLE IF NOT EXISTS `nuked_forums_rank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `type` int(1) NOT NULL DEFAULT '0',
  `post` int(4) NOT NULL DEFAULT '0',
  `image` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `nuked_forums_rank`
--

INSERT INTO `nuked_forums_rank` (`id`, `nom`, `type`, `post`, `image`) VALUES
(1, 'Noob', 0, 0, 'modules/Forum/images/rank/star1.gif'),
(2, 'Jeune membre', 0, 10, 'modules/Forum/images/rank/star2.gif'),
(3, 'Membre', 0, 100, 'modules/Forum/images/rank/star3.gif'),
(4, 'Membre averti', 0, 500, 'modules/Forum/images/rank/star4.gif'),
(5, 'Posteur Fou', 0, 1000, 'modules/Forum/images/rank/star5.gif'),
(6, 'Modérateur', 1, 0, 'modules/Forum/images/rank/mod.gif'),
(7, 'Administrateur', 2, 0, 'modules/Forum/images/rank/mod.gif');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_read`
--

DROP TABLE IF EXISTS `nuked_forums_read`;
CREATE TABLE IF NOT EXISTS `nuked_forums_read` (
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `thread_id` text COLLATE latin1_general_ci NOT NULL,
  `forum_id` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_threads`
--

DROP TABLE IF EXISTS `nuked_forums_threads`;
CREATE TABLE IF NOT EXISTS `nuked_forums_threads` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `date` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `closed` int(1) NOT NULL DEFAULT '0',
  `auteur` text COLLATE latin1_general_ci NOT NULL,
  `auteur_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `forum_id` int(5) NOT NULL DEFAULT '0',
  `last_post` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `view` int(10) NOT NULL DEFAULT '0',
  `annonce` int(1) NOT NULL DEFAULT '0',
  `sondage` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `auteur_id` (`auteur_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_forums_vote`
--

DROP TABLE IF EXISTS `nuked_forums_vote`;
CREATE TABLE IF NOT EXISTS `nuked_forums_vote` (
  `poll_id` int(11) NOT NULL DEFAULT '0',
  `auteur_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `auteur_ip` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_gallery`
--

DROP TABLE IF EXISTS `nuked_gallery`;
CREATE TABLE IF NOT EXISTS `nuked_gallery` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url2` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url_file` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `cat` int(11) NOT NULL DEFAULT '0',
  `date` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `count` int(10) NOT NULL DEFAULT '0',
  `autor` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_gallery_cat`
--

DROP TABLE IF EXISTS `nuked_gallery_cat`;
CREATE TABLE IF NOT EXISTS `nuked_gallery_cat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `titre` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE latin1_general_ci NOT NULL,
  `position` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_gallery_v2`
--

DROP TABLE IF EXISTS `nuked_gallery_v2`;
CREATE TABLE IF NOT EXISTS `nuked_gallery_v2` (
  `sid` int(11) NOT NULL auto_increment,
  `titre` text NOT NULL,
  `description` text NOT NULL,
  `url` varchar(200) NOT NULL default '',
  `url_file` varchar(200) NOT NULL default '',
  `cat` int(11) NOT NULL default '0',
  `date` varchar(12) NOT NULL default '',
  `count` int(10) NOT NULL default '0',
  `count_dl` int(10) NOT NULL default '0',
  `autor` text NOT NULL,
  `level` int(1) NOT NULL default '0',
  `type` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL default '0',
  `taille` varchar(6) NOT NULL,
  `mot_cle` text NOT NULL,
  `actif` int(1) NOT NULL default '0',
  PRIMARY KEY  (`sid`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_gallery_v2_cat`
--

DROP TABLE IF EXISTS `nuked_gallery_v2_cat`;
CREATE TABLE IF NOT EXISTS `nuked_gallery_v2_cat` (
  `cid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `titre` varchar(50) NOT NULL default '',
  `image` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `position` int(2) unsigned NOT NULL default '0',
  `level` int(1) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_gallery_v2_config`
--

DROP TABLE IF EXISTS `nuked_gallery_v2_config`;
CREATE TABLE IF NOT EXISTS `nuked_gallery_v2_config` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `nuked_gallery_v2_config`
--

INSERT INTO `nuked_gallery_v2_config` (`name`, `value`) VALUES
('mess_admin_page', '20'),
('color_player', '5D6953'),
('max_cat', '9'),
('rep_img', 'upload/Gallery_v2/'),
('mess_guest_page', '6'),
('aff_prev_next', 'off'),
('title', ''),
('dl_lvl', '1'),
('dl_ok', 'on'),
('suggest', '1'),
('max_size', '5'),
('lvl_suggest', '1'),
('dl_zip', '0'),
('lvl_dl_zip', '9'),
('make_thumb', '0'),
('block_type', '1');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_games`
--

DROP TABLE IF EXISTS `nuked_games`;
CREATE TABLE IF NOT EXISTS `nuked_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `titre` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `icon` varchar(150) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pref_1` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pref_2` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pref_3` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pref_4` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pref_5` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `map` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_games`
--

INSERT INTO `nuked_games` (`id`, `name`, `titre`, `icon`, `pref_1`, `pref_2`, `pref_3`, `pref_4`, `pref_5`, `map`) VALUES
(1, 'Counter Strike Source', 'Préférences CS', 'images/games/cs.gif', 'Autre pseudo', 'Map favorite', 'Arme favorite', 'Skin Terro', 'Skin CT', 'de_dust2|de_inferno');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_games_prefs`
--

DROP TABLE IF EXISTS `nuked_games_prefs`;
CREATE TABLE IF NOT EXISTS `nuked_games_prefs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` int(11) NOT NULL DEFAULT '0',
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pref_1` text COLLATE latin1_general_ci NOT NULL,
  `pref_2` text COLLATE latin1_general_ci NOT NULL,
  `pref_3` text COLLATE latin1_general_ci NOT NULL,
  `pref_4` text COLLATE latin1_general_ci NOT NULL,
  `pref_5` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_guestbook`
--

DROP TABLE IF EXISTS `nuked_guestbook`;
CREATE TABLE IF NOT EXISTS `nuked_guestbook` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(60) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` varchar(70) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0',
  `host` varchar(60) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `comment` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_irc_awards`
--

DROP TABLE IF EXISTS `nuked_irc_awards`;
CREATE TABLE IF NOT EXISTS `nuked_irc_awards` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE latin1_general_ci NOT NULL,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_liens`
--

DROP TABLE IF EXISTS `nuked_liens`;
CREATE TABLE IF NOT EXISTS `nuked_liens` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `titre` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `cat` int(11) NOT NULL DEFAULT '0',
  `webmaster` text COLLATE latin1_general_ci NOT NULL,
  `country` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  `broke` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_liens_cat`
--

DROP TABLE IF EXISTS `nuked_liens_cat`;
CREATE TABLE IF NOT EXISTS `nuked_liens_cat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `titre` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE latin1_general_ci NOT NULL,
  `position` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_match`
--

DROP TABLE IF EXISTS `nuked_match`;
CREATE TABLE IF NOT EXISTS `nuked_match` (
  `warid` int(10) NOT NULL AUTO_INCREMENT,
  `etat` int(1) NOT NULL DEFAULT '0',
  `team` int(11) NOT NULL DEFAULT '0',
  `game` int(11) NOT NULL DEFAULT '0',
  `adversaire` text COLLATE latin1_general_ci,
  `url_adv` varchar(60) COLLATE latin1_general_ci DEFAULT NULL,
  `pays_adv` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `type` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `style` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date_jour` int(2) DEFAULT NULL,
  `date_mois` int(2) DEFAULT NULL,
  `date_an` int(4) DEFAULT NULL,
  `heure` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `map` text COLLATE latin1_general_ci,
  `tscore_team` float DEFAULT NULL,
  `tscore_adv` float DEFAULT NULL,
  `score_team` text COLLATE latin1_general_ci NOT NULL,
  `score_adv` text COLLATE latin1_general_ci NOT NULL,
  `report` text COLLATE latin1_general_ci,
  `auteur` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `url_league` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `dispo` text COLLATE latin1_general_ci,
  `pas_dispo` text COLLATE latin1_general_ci,
  PRIMARY KEY (`warid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_match_files`
--

DROP TABLE IF EXISTS `nuked_match_files`;
CREATE TABLE IF NOT EXISTS `nuked_match_files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `im_id` int(10) NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `im_id` (`im_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_modules`
--

DROP TABLE IF EXISTS `nuked_modules`;
CREATE TABLE IF NOT EXISTS `nuked_modules` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `niveau` int(1) NOT NULL DEFAULT '0',
  `admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=23 ;

--
-- Contenu de la table `nuked_modules`
--

INSERT INTO `nuked_modules` (`id`, `nom`, `niveau`, `admin`) VALUES
(1, 'News', 0, 2),
(2, 'Forum', 0, 2),
(3, 'Wars', 0, 2),
(4, 'Irc', 0, 2),
(5, 'Survey', 0, 3),
(6, 'Links', 0, 3),
(7, 'Sections', 0, 3),
(8, 'Server', 0, 3),
(9, 'Download', 0, 3),
(10, 'Gallery', 0, 3),
(11, 'Suggest', 0, 3),
(12, 'Textbox', 0, 9),
(13, 'Calendar', 0, 2),
(14, 'Members', 0, 9),
(15, 'Team', 0, 9),
(16, 'Defy', 0, 3),
(17, 'Recruit', 0, 3),
(18, 'Comment', 0, 9),
(19, 'Vote', 0, 9),
(20, 'Stats', 0, 2),
(21, 'Contact', 0, 3),
(22, 'Equipe', 0, 2),
(23, 'Video', 0, 9),
(24, 'Annonces', 0, 3),
(25, 'Facebook', 1, 9),
(26, 'Horoscope', 1, 9),
(27, 'Banlist', 1, 9),
(28, 'Page', 0, 9),
(29, 'Faqs', 0, 3),
(30, 'Portfolio', 0, 3),
(31, 'Wow_recrutement', 0, 9),
(32, 'Ts3viewer', 1, 9),
(33, 'FileEditor', 9, 9),
(34, 'Email', 9, 9),
(35, 'Tournament', 0, 2),
(36, 'Ticket', 0, 9),
(37, 'Reglement', 0, 9),
(38, 'Tags', '0', '3'),
(39, 'myliens', 0, 9),
(40, 'Steam_ban', 0, 9),
(41, 'Gallery_v2', 0, 9),
(42, 'Strats', '3', '7'),
(43, 'Espace_membre', 1, 9),
(44, 'Private_Message', 9, 9),
(45, 'Guestbook', 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_mod_frms`
--

DROP TABLE IF EXISTS `nuked_mod_frms`;
CREATE TABLE IF NOT EXISTS `nuked_mod_frms` (
  `id` int(13) NOT NULL auto_increment,
  `titre` varchar(255) collate latin1_general_ci NOT NULL,
  `descr` text collate latin1_general_ci,
  `niveau` int(1) NOT NULL,
  `nivresp` int(1) NOT NULL,
  `chkmail` varchar(3) collate latin1_general_ci NOT NULL,
  `mail` varchar(60) collate latin1_general_ci default NULL,
  `nbr_chps` int(2) NOT NULL,
  `captch` varchar(3) collate latin1_general_ci NOT NULL,
  `etat` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_mod_frms`
--

INSERT INTO `nuked_mod_frms` (`id`, `titre`, `descr`, `niveau`, `nivresp`, `chkmail`, `mail`, `nbr_chps`, `captch`, `etat`) VALUES
(1, 'Exemple de formulaire', 'Courte description', 0, 2, '', 'mail@hotmail.com', 5, '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_mod_frms_details`
--

DROP TABLE IF EXISTS `nuked_mod_frms_details`;
CREATE TABLE IF NOT EXISTS `nuked_mod_frms_details` (
  `id` int(13) NOT NULL auto_increment,
  `idform` int(5) NOT NULL,
  `label` varchar(60) collate latin1_general_ci NOT NULL,
  `type` varchar(12) collate latin1_general_ci NOT NULL,
  `defaut` varchar(255) collate latin1_general_ci default NULL,
  `requis` varchar(2) collate latin1_general_ci NOT NULL,
  `position` int(2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idform` (`idform`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `nuked_mod_frms_details`
--

INSERT INTO `nuked_mod_frms_details` (`id`, `idform`, `label`, `type`, `defaut`, `requis`, `position`) VALUES
(1, 1, 'Nom', 'input', '', 'on', 1),
(2, 1, 'Prenom', 'input', '', '', 2),
(3, 1, 'Email', 'mail', 'mail@domaine.com', 'on', 3),
(4, 1, 'Age', 'numeric', 'Numerique', '', 4),
(5, 1, 'Commentaire', 'textarea', '', '', 5);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_mod_frms_rec`
--

DROP TABLE IF EXISTS `nuked_mod_frms_rec`;
CREATE TABLE IF NOT EXISTS `nuked_mod_frms_rec` (
  `id` int(13) NOT NULL auto_increment,
  `id_form` int(5) NOT NULL,
  `id_user` varchar(20) collate latin1_general_ci NOT NULL,
  `ip` varchar(16) collate latin1_general_ci NOT NULL,
  `date` varchar(16) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_form` (`id_form`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_mod_frms_rec_details`
--

DROP TABLE IF EXISTS `nuked_mod_frms_rec_details`;
CREATE TABLE IF NOT EXISTS `nuked_mod_frms_rec_details` (
  `id_rec` int(5) NOT NULL,
  `id_frm_details` int(5) NOT NULL,
  `valeur` varchar(255) collate latin1_general_ci NOT NULL,
  KEY `id_rec` (`id_rec`),
  KEY `id_frm_details` (`id_frm_details`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_mumble`
--

DROP TABLE IF EXISTS `nuked_mumble`;
CREATE TABLE IF NOT EXISTS `nuked_mumble` (
  `name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `mumble_jsonurl` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_mumble`
--

INSERT INTO nuked_mumble (name, mumble_jsonurl) VALUES
('config', '');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_nbconnecte`
--

DROP TABLE IF EXISTS `nuked_nbconnecte`;
CREATE TABLE IF NOT EXISTS `nuked_nbconnecte` (
  `IP` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `type` int(10) NOT NULL DEFAULT '0',
  `date` int(14) NOT NULL DEFAULT '0',
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `username` varchar(40) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`IP`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_nbconnecte`
--

INSERT INTO `nuked_nbconnecte` (`IP`, `type`, `date`, `user_id`, `username`) VALUES
('80.236.56.247', 0, 1352563331, '', '');


-- --------------------------------------------------------

--
-- Structure de la table `nuked_nbconnect_jour`
--

DROP TABLE IF EXISTS `nuked_nbconnect_jour`;
CREATE TABLE IF NOT EXISTS `nuked_nbconnect_jour` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(30) collate latin1_general_ci NOT NULL default '',
  `temps` bigint(20) NOT NULL default '0',
  `hier` varchar(10) collate latin1_general_ci NOT NULL default '',
  `record` varchar(10) collate latin1_general_ci NOT NULL default '',
  `ip` varchar(20) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_news`
--

DROP TABLE IF EXISTS `nuked_news`;
CREATE TABLE IF NOT EXISTS `nuked_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `titre` text COLLATE latin1_general_ci,
  `auteur` text COLLATE latin1_general_ci,
  `auteur_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `texte` text COLLATE latin1_general_ci,
  `suite` text COLLATE latin1_general_ci,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `bbcodeoff` int(1) NOT NULL DEFAULT '0',
  `smileyoff` int(1) NOT NULL DEFAULT '0',
  `published` INT(1) default NULL,
  `niveau` INT(1) default NULL,
  `allow_comments` INT(1) default NULL,
  `thread_id` int(5) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_news`
--

INSERT INTO `nuked_news` (`id`, `cat`, `titre`, `auteur`, `auteur_id`, `texte`, `suite`, `date`, `bbcodeoff`, `smileyoff`, `published`, `niveau`, `allow_comments`) VALUES
(1, '1', 'Bienvenue sur votre site NuKed-KlaN 1.7.9', 'admin', 'zbdwzpdqq76N3XirqaC0', 'Bienvenue sur votre site NuKed-KlaN, votre installation s''est, à priori, bien déroulée, rendez-vous dans la partie administration pour commencer à utiliser votre site tout simplement en vous loguant avec le pseudo indiqué lors de l''install. En cas de problèmes, veuillez le signaler sur  <a href="http://www.nuked-klan.org">http://www.nuked-klan.org</a> dans le forum prévu à cet effet.', '', '1352563028', 0, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_news_cat`
--

DROP TABLE IF EXISTS `nuked_news_cat`;
CREATE TABLE IF NOT EXISTS `nuked_news_cat` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `titre` text COLLATE latin1_general_ci,
  `description` text COLLATE latin1_general_ci,
  `image` text COLLATE latin1_general_ci,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_news_cat`
--

INSERT INTO `nuked_news_cat` (`nid`, `titre`, `description`, `image`) VALUES
(1, 'Counter Strike Source', 'Le meilleur MOD pour Half-Life', 'modules/News/images/cs.gif');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_notification`
--

DROP TABLE IF EXISTS `nuked_notification`;
CREATE TABLE IF NOT EXISTS `nuked_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `type` text COLLATE latin1_general_ci NOT NULL,
  `texte` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_page`
--

DROP TABLE IF EXISTS `nuked_page`;
CREATE TABLE IF NOT EXISTS `nuked_page` (
  `id` int(11) NOT NULL auto_increment,
  `niveau` int(1) NOT NULL default '0',
  `titre` varchar(50) collate latin1_general_ci NOT NULL default '',
  `content` text collate latin1_general_ci NOT NULL,
  `url` varchar(80) collate latin1_general_ci NOT NULL default '',
  `type` varchar(5) collate latin1_general_ci NOT NULL default '',
  `show_title` int(1) NOT NULL default '0',
  `members` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `titre` (`titre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_paypal`
--

DROP TABLE IF EXISTS `nuked_paypal`;
CREATE TABLE IF NOT EXISTS `nuked_paypal` (
  `id` int(11) NOT NULL auto_increment,
  `email` text collate latin1_general_ci NOT NULL,
  `nom` text collate latin1_general_ci NOT NULL,
  `montantdons` varchar(4) collate latin1_general_ci NOT NULL default '0',
  `logo` text collate latin1_general_ci NOT NULL,
  `affiche` text collate latin1_general_ci NOT NULL,
  `flash` text collate latin1_general_ci NOT NULL,
  `ok` text collate latin1_general_ci NOT NULL,
  `ko` text collate latin1_general_ci NOT NULL,
  `cible` char(3) collate latin1_general_ci NOT NULL,
  `copy` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_paypal`
--

INSERT INTO `nuked_paypal` (`id`, `email`, `nom`, `montantdons`, `logo`, `affiche`, `flash`, `ok`, `ko`, `cible`, `copy`) VALUES
(1, '', '', '', 'modules/Paypal/img/boutons/bouton10.png', 'Flash', 'flash3', '<p>\r\n	merci, %donateur% de votre dons de %donner% en date du %date%</p>\r\n', '', 'non', '<a href=''http://www.palacewar.eu'' title=''PalaceWaR''>&copy;</a><a href=''http://www.nk-create.com'' title=''Nk-Create''>&copy;</a>');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_paypal_accepte`
--

DROP TABLE IF EXISTS `nuked_paypal_accepte`;
CREATE TABLE IF NOT EXISTS `nuked_paypal_accepte` (
  `id` int(11) NOT NULL auto_increment,
  `autor` text collate latin1_general_ci NOT NULL,
  `autor_id` varchar(20) collate latin1_general_ci NOT NULL default '',
  `date` varchar(30) collate latin1_general_ci NOT NULL default '',
  `montant` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_paypal_flash`
--

DROP TABLE IF EXISTS `nuked_paypal_flash`;
CREATE TABLE IF NOT EXISTS `nuked_paypal_flash` (
  `id` int(11) NOT NULL auto_increment,
  `var3` char(3) collate latin1_general_ci NOT NULL default '',
  `var2` char(3) collate latin1_general_ci NOT NULL default '',
  `var5` char(3) collate latin1_general_ci NOT NULL default '',
  `var4` char(3) collate latin1_general_ci NOT NULL default '',
  `var8` char(3) collate latin1_general_ci NOT NULL default '',
  `var6` char(3) collate latin1_general_ci NOT NULL default '',
  `var7` char(3) collate latin1_general_ci NOT NULL default '',
  `flaw` char(3) collate latin1_general_ci NOT NULL default '',
  `flah` char(3) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `nuked_paypal_flash`
--

INSERT INTO `nuked_paypal_flash` (`id`, `var3`, `var2`, `var5`, `var4`, `var8`, `var6`, `var7`, `flaw`, `flah`) VALUES
(1, '20', '200', '7', '5', '1', '0', '0', '220', '40'),
(2, 'off', 'off', 'off', 'o', 'off', 'off', 'off', '200', '30'),
(3, 'off', 'off', 'off', 'o', 'off', 'off', 'off', 'off', 'off'),
(4, 'off', 'on', 'on', 'on', 'on', 'on', 'off', '160', '160');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_portfolio_cat`
--

DROP TABLE IF EXISTS `nuked_portfolio_cat`;
CREATE TABLE IF NOT EXISTS `nuked_portfolio_cat` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `nom` (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_portfolio_crea`
--

DROP TABLE IF EXISTS `nuked_portfolio_crea`;
CREATE TABLE IF NOT EXISTS `nuked_portfolio_crea` (
  `id` int(20) NOT NULL auto_increment,
  `titre` varchar(255) collate latin1_general_ci NOT NULL default '',
  `description` text collate latin1_general_ci NOT NULL,
  `cat` varchar(100) collate latin1_general_ci NOT NULL,
  `date` int(20) NOT NULL default '0',
  `url_site` varchar(100) collate latin1_general_ci NOT NULL default '',
  `url_apercu` varchar(100) collate latin1_general_ci default NULL,
  `url_vignette` varchar(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `titre` (`titre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_portfolio_pref`
--

DROP TABLE IF EXISTS `nuked_portfolio_pref`;
CREATE TABLE IF NOT EXISTS `nuked_portfolio_pref` (
  `nb_crea` int(20) NOT NULL default '10',
  PRIMARY KEY  (`nb_crea`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_portfolio_pref`
--

INSERT INTO `nuked_portfolio_pref` (`nb_crea`) VALUES
(10);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_recrute`
--

DROP TABLE IF EXISTS `nuked_recrute`;
CREATE TABLE IF NOT EXISTS `nuked_recrute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pseudo` text COLLATE latin1_general_ci NOT NULL,
  `prenom` text COLLATE latin1_general_ci NOT NULL,
  `age` int(3) NOT NULL DEFAULT '0',
  `mail` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `icq` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `country` text COLLATE latin1_general_ci NOT NULL,
  `game` int(11) NOT NULL DEFAULT '0',
  `connection` text COLLATE latin1_general_ci NOT NULL,
  `experience` text COLLATE latin1_general_ci NOT NULL,
  `dispo` text COLLATE latin1_general_ci NOT NULL,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `game` (`game`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Structure de la table `nuked_reglement`
--

DROP TABLE IF EXISTS `nuked_reglement`;
CREATE TABLE IF NOT EXISTS `nuked_reglement` (
  `id` int(11) NOT NULL auto_increment,
  `titre` varchar(200) collate latin1_general_ci NOT NULL,
  `lien` varchar(255) collate latin1_general_ci NOT NULL,
  `niveau` int(2) NOT NULL,
  `largeur` varchar(10) collate latin1_general_ci NOT NULL,
  `valeur` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_reglement_details`
--

DROP TABLE IF EXISTS `nuked_reglement_details`;
CREATE TABLE IF NOT EXISTS `nuked_reglement_details` (
  `id` int(12) NOT NULL auto_increment,
  `id_reglement` int(5) NOT NULL,
  `titre` text collate latin1_general_ci NOT NULL,
  `contenu` text collate latin1_general_ci NOT NULL,
  `ordre` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_reglement` (`id_reglement`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_replays`
--

DROP TABLE IF EXISTS `nuked_replays`;
CREATE TABLE IF NOT EXISTS `nuked_replays` (
  `id` int(30) NOT NULL auto_increment,
  `titre` varchar(90) collate latin1_general_ci NOT NULL,
  `texte` text collate latin1_general_ci NOT NULL,
  `evenement` varchar(90) collate latin1_general_ci NOT NULL,
  `map` varchar(30) collate latin1_general_ci NOT NULL,
  `duree` varchar(10) collate latin1_general_ci NOT NULL,
  `taille` varchar(10) collate latin1_general_ci NOT NULL,
  `version` varchar(10) collate latin1_general_ci NOT NULL,
  `url` varchar(90) collate latin1_general_ci NOT NULL,
  `id_equipe` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `id_user` varchar(20) collate latin1_general_ci NOT NULL,
  `date_ajout` varchar(12) collate latin1_general_ci NOT NULL,
  `compteur` int(11) NOT NULL default '0',
  `game` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_replays_config`
--

DROP TABLE IF EXISTS `nuked_replays_config`;
CREATE TABLE IF NOT EXISTS `nuked_replays_config` (
  `id` int(11) NOT NULL auto_increment,
  `1vs1` text collate latin1_general_ci NOT NULL,
  `2vs2` text collate latin1_general_ci NOT NULL,
  `3vs3` text collate latin1_general_ci NOT NULL,
  `4vs4` text collate latin1_general_ci NOT NULL,
  `5vs5` text collate latin1_general_ci NOT NULL,
  `2vs2vs2` text collate latin1_general_ci NOT NULL,
  `2vs2vs2vs2` text collate latin1_general_ci NOT NULL,
  `ffa3pl` text collate latin1_general_ci NOT NULL,
  `ffa4pl` text collate latin1_general_ci NOT NULL,
  `ffa5pl` text collate latin1_general_ci NOT NULL,
  `ffa6pl` text collate latin1_general_ci NOT NULL,
  `ffa8pl` text collate latin1_general_ci NOT NULL,
  `max_replays` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_replays_config`
--

INSERT INTO `nuked_replays_config` (`id`, `1vs1`, `2vs2`, `3vs3`, `4vs4`, `5vs5`, `2vs2vs2`, `2vs2vs2vs2`, `ffa3pl`, `ffa4pl`, `ffa5pl`, `ffa6pl`, `ffa8pl`, `max_replays`) VALUES
(1, 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', '15');

-- --------------------------------------------------------

--
-- Table structure for table `nuked_replays_equipes`
--

DROP TABLE IF EXISTS `nuked_replays_equipes`;
CREATE TABLE IF NOT EXISTS `nuked_replays_equipes` (
  `joueur1` varchar(30) collate latin1_general_ci NOT NULL,
  `joueur2` varchar(30) collate latin1_general_ci NOT NULL,
  `joueur3` varchar(30) collate latin1_general_ci default NULL,
  `joueur4` varchar(30) collate latin1_general_ci default NULL,
  `joueur5` varchar(30) collate latin1_general_ci default NULL,
  `joueur6` varchar(30) collate latin1_general_ci default NULL,
  `joueur7` varchar(30) collate latin1_general_ci default NULL,
  `joueur8` varchar(30) collate latin1_general_ci default NULL,
  `joueur9` varchar(30) collate latin1_general_ci default NULL,
  `joueur10` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur1` varchar(30) collate latin1_general_ci NOT NULL,
  `racejoueur2` varchar(30) collate latin1_general_ci NOT NULL,
  `racejoueur3` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur4` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur5` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur6` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur7` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur8` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur9` varchar(30) collate latin1_general_ci default NULL,
  `racejoueur10` varchar(30) collate latin1_general_ci default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nuked_replays_maps`
--

DROP TABLE IF EXISTS `nuked_replays_maps`;
CREATE TABLE IF NOT EXISTS `nuked_replays_maps` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(30) collate latin1_general_ci NOT NULL,
  `image` varchar(30) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nuked_replays_race`
--

DROP TABLE IF EXISTS `nuked_replays_race`;
CREATE TABLE IF NOT EXISTS `nuked_replays_race` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(30) collate latin1_general_ci NOT NULL,
  `image` varchar(30) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_sections`
--

DROP TABLE IF EXISTS `nuked_sections`;
CREATE TABLE IF NOT EXISTS `nuked_sections` (
  `artid` int(11) NOT NULL AUTO_INCREMENT,
  `secid` int(11) NOT NULL DEFAULT '0',
  `title` text COLLATE latin1_general_ci NOT NULL,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `autor` text COLLATE latin1_general_ci NOT NULL,
  `autor_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `counter` int(11) NOT NULL DEFAULT '0',
  `bbcodeoff` int(1) NOT NULL DEFAULT '0',
  `smileyoff` int(1) NOT NULL DEFAULT '0',
  `date` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`artid`),
  KEY `secid` (`secid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_sections_cat`
--

DROP TABLE IF EXISTS `nuked_sections_cat`;
CREATE TABLE IF NOT EXISTS `nuked_sections_cat` (
  `secid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `secname` varchar(40) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE latin1_general_ci NOT NULL,
  `position` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`secid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_serveur`
--

DROP TABLE IF EXISTS `nuked_serveur`;
CREATE TABLE IF NOT EXISTS `nuked_serveur` (
  `sid` int(30) NOT NULL AUTO_INCREMENT,
  `game` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ip` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `port` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pass` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `cat` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`sid`),
  KEY `game` (`game`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_serveur_cat`
--

DROP TABLE IF EXISTS `nuked_serveur_cat`;
CREATE TABLE IF NOT EXISTS `nuked_serveur_cat` (
  `cid` int(30) NOT NULL AUTO_INCREMENT,
  `titre` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_sessions`
--

DROP TABLE IF EXISTS `nuked_sessions`;
CREATE TABLE IF NOT EXISTS `nuked_sessions` (
  `id` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `last_used` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ip` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `vars` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_shoutbox`
--

DROP TABLE IF EXISTS `nuked_shoutbox`;
CREATE TABLE IF NOT EXISTS `nuked_shoutbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` text COLLATE latin1_general_ci,
  `ip` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `texte` text COLLATE latin1_general_ci,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_shoutbox`
--

INSERT INTO `nuked_shoutbox` (`id`, `auteur`, `ip`, `texte`, `date`) VALUES
(1, 'admin', '80.236.56.247', 'Bienvenue sur votre site NuKed-KlaN 1.7.9', '1352563028');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_smilies`
--

DROP TABLE IF EXISTS `nuked_smilies`;
CREATE TABLE IF NOT EXISTS `nuked_smilies` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;

--
-- Contenu de la table `nuked_smilies`
--

INSERT INTO `nuked_smilies` (`id`, `code`, `url`, `name`) VALUES
(1, ':rolleyes:', 'rolleyes.gif', 'Rolleyes'),
(2, ':)', 'smile.gif', 'Smile'),
(3, ';)', 'wink.gif', 'Wink'),
(4, 'B)', 'cool.gif', 'Cool'),
(5, ':P', 'tongue.gif', 'Tongue'),
(6, ':(', 'sad.gif', 'Sad'),
(7, ':D', 'biggrin.gif', 'Very Happy'),
(8, ':unsure:', 'unsure.gif', 'Unsure'),
(9, ':mellow:', 'mellow.gif', 'Mellow'),
(10, ':wacko:', 'wacko.gif', 'Wacko'),
(11, ':angry:', 'angry.gif', 'Angry'),
(12, ':blink:', 'blink.gif', 'Blink'),
(13, ':ph34r:', 'ph34r.gif', 'Ph34r'),
(14, ':blush:', 'blush.gif', 'Blush'),
(15, ':excl:', 'excl.gif', 'Excl'),
(16, ':wub:', 'wub.gif', 'Wub'),
(17, ':huh:', 'huh.gif', 'Huh'),
(18, ':lol:', 'laugh.gif', 'Laugh'),
(19, ':mad:', 'mad.gif', 'Mad'),
(20, '<_<', 'dry.gif', 'Dry'),
(21, '-_-', 'sleep.gif', 'Sleep'),
(22, '^_^', 'happy.gif', 'Happy'),
(23, ':o', 'ohmy.gif', 'Ohmy'),
(24, ':burk:', 'burk.gif', 'Beurk'),
(25, '<3', 'smack.gif', 'Smack'),
(26, ':/', 'redface.gif', 'Upset');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_sondage`
--

DROP TABLE IF EXISTS `nuked_sondage`;
CREATE TABLE IF NOT EXISTS `nuked_sondage` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date` varchar(15) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `niveau` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_sondage`
--

INSERT INTO `nuked_sondage` (`sid`, `titre`, `date`, `niveau`) VALUES
(1, 'Aimez-vous Nuked-klan ?', '1352562995', 0);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_sondage_check`
--

DROP TABLE IF EXISTS `nuked_sondage_check`;
CREATE TABLE IF NOT EXISTS `nuked_sondage_check` (
  `ip` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pseudo` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `heurelimite` int(14) NOT NULL DEFAULT '0',
  `sid` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_sondage_data`
--

DROP TABLE IF EXISTS `nuked_sondage_data`;
CREATE TABLE IF NOT EXISTS `nuked_sondage_data` (
  `sid` int(11) NOT NULL DEFAULT '0',
  `optionText` char(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `optionCount` int(11) NOT NULL DEFAULT '0',
  `voteID` int(11) NOT NULL DEFAULT '0',
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_sondage_data`
--

INSERT INTO `nuked_sondage_data` (`sid`, `optionText`, `optionCount`, `voteID`) VALUES
(1, 'Ca déchire, continuez !', 0, 1),
(1, 'Mouais, pas mal...', 0, 2),
(1, 'C''est naze, arrêtez-vous !', 0, 3),
(1, 'C''est quoi Nuked-Klan ?', 0, 4);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_staff`
--

DROP TABLE IF EXISTS `nuked_staff`;
CREATE TABLE IF NOT EXISTS `nuked_staff` (
  `id` int(11) NOT NULL auto_increment,
  `membre_id` varchar(20) collate latin1_german2_ci NOT NULL default '',
  `categorie_id` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  `status_id` varchar(25) collate latin1_german2_ci NOT NULL default '',
  `rang_id` varchar(25) collate latin1_german2_ci NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_staff_cat`
--

DROP TABLE IF EXISTS `nuked_staff_cat`;
CREATE TABLE IF NOT EXISTS `nuked_staff_cat` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) collate latin1_german2_ci NOT NULL default '',
  `img` varchar(255) collate latin1_german2_ci NOT NULL default '',
  `ordre` int(5) NOT NULL default '0',
  `tag` text collate latin1_german2_ci NOT NULL,
  `tag2` text collate latin1_german2_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_staff_rang`
--

DROP TABLE IF EXISTS `nuked_staff_rang`;
CREATE TABLE IF NOT EXISTS `nuked_staff_rang` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(25) collate latin1_german2_ci NOT NULL default '',
  `ordre` int(5) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_staff_status`
--

DROP TABLE IF EXISTS `nuked_staff_status`;
CREATE TABLE IF NOT EXISTS `nuked_staff_status` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(25) collate latin1_german2_ci NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_stats`
--

DROP TABLE IF EXISTS `nuked_stats`;
CREATE TABLE IF NOT EXISTS `nuked_stats` (
  `nom` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `type` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_stats`
--

INSERT INTO `nuked_stats` (`nom`, `type`, `count`) VALUES
('Gallery', 'pages', 0),
('Archives', 'pages', 0),
('Calendar', 'pages', 0),
('Defy', 'pages', 0),
('Download', 'pages', 0),
('Guestbook', 'pages', 0),
('Irc', 'pages', 0),
('Links', 'pages', 0),
('Wars', 'pages', 0),
('News', 'pages', 0),
('Search', 'pages', 0),
('Recruit', 'pages', 0),
('Sections', 'pages', 0),
('Server', 'pages', 0),
('Members', 'pages', 0),
('Team', 'pages', 0),
('Forum', 'pages', 0),
('Gallery_v2', 'pages', 0),
('Faqs', 'pages', '0');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_stats_visitor`
--

DROP TABLE IF EXISTS `nuked_stats_visitor`;
CREATE TABLE IF NOT EXISTS `nuked_stats_visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ip` varchar(15) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `host` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `browser` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `os` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `referer` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `day` int(2) NOT NULL DEFAULT '0',
  `month` int(2) NOT NULL DEFAULT '0',
  `year` int(4) NOT NULL DEFAULT '0',
  `hour` int(2) NOT NULL DEFAULT '0',
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `host` (`host`),
  KEY `browser` (`browser`),
  KEY `os` (`os`),
  KEY `referer` (`referer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Structure de la table `nuked_steam_ban`
--

DROP TABLE IF EXISTS `nuked_steam_ban`;
CREATE TABLE IF NOT EXISTS `nuked_steam_ban` (
  `sid` int(11) NOT NULL auto_increment,
  `pseudo` varchar(200) collate latin1_general_ci NOT NULL default '',
  `steamid` varchar(200) collate latin1_general_ci NOT NULL default '',
  `raison` varchar(60) collate latin1_general_ci NOT NULL default '',
  `temps` varchar(60) collate latin1_general_ci NOT NULL default '',
  `ki` varchar(60) collate latin1_general_ci NOT NULL default '',
  `url_video` varchar(200) collate latin1_general_ci NOT NULL default '',
  `screenshot` varchar(200) collate latin1_general_ci NOT NULL default '',
  `commentaire` text collate latin1_general_ci NOT NULL,
  `date` varchar(60) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_strat`
--

DROP TABLE IF EXISTS `nuked_strat`;
CREATE TABLE IF NOT EXISTS `nuked_strat` (
  `strat_id` int(10) NOT NULL auto_increment,
  `strat_map_id` int(10) NOT NULL,
  `title` text collate latin1_general_ci NOT NULL,
  `text` text collate latin1_general_ci NOT NULL,
  `picture` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`strat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_strats_map`
--

DROP TABLE IF EXISTS `nuked_strats_map`;
CREATE TABLE IF NOT EXISTS `nuked_strats_map` (
  `strat_map_id` int(10) NOT NULL auto_increment,
  `map_name` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`strat_map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_suggest`
--

DROP TABLE IF EXISTS `nuked_suggest`;
CREATE TABLE IF NOT EXISTS `nuked_suggest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` mediumtext COLLATE latin1_general_ci NOT NULL,
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `proposition` longtext COLLATE latin1_general_ci NOT NULL,
  `date` varchar(14) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_team`
--

DROP TABLE IF EXISTS `nuked_team`;
CREATE TABLE IF NOT EXISTS `nuked_team` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `tag` text COLLATE latin1_general_ci NOT NULL,
  `tag2` text COLLATE latin1_general_ci NOT NULL,
  `ordre` int(5) NOT NULL DEFAULT '0',
  `game` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_team_rank`
--

DROP TABLE IF EXISTS `nuked_team_rank`;
CREATE TABLE IF NOT EXISTS `nuked_team_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ordre` int(5) NOT NULL DEFAULT '0',
  `image` varchar(200) collate latin1_general_ci default NULL,
  `couleur` varchar(6) collate latin1_general_ci default NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_ticket`
--

DROP TABLE IF EXISTS `nuked_ticket`;
CREATE TABLE IF NOT EXISTS `nuked_ticket` (
  `id` int(11) NOT NULL auto_increment,
  `backadmin` char(6) collate latin1_general_ci NOT NULL,
  `backuser` char(6) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_ticket`
--

INSERT INTO `nuked_ticket` (`id`, `backadmin`, `backuser`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_ticket_msg`
--

DROP TABLE IF EXISTS `nuked_ticket_msg`;
CREATE TABLE IF NOT EXISTS `nuked_ticket_msg` (
  `aleatoire` varchar(10) collate latin1_general_ci NOT NULL,
  `message` text collate latin1_general_ci NOT NULL,
  `date` varchar(30) collate latin1_general_ci NOT NULL,
  `author` text collate latin1_general_ci NOT NULL,
  KEY `aleatoire` (`aleatoire`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_ticket_send`
--

DROP TABLE IF EXISTS `nuked_ticket_send`;
CREATE TABLE IF NOT EXISTS `nuked_ticket_send` (
  `id` int(11) NOT NULL auto_increment,
  `author` text collate latin1_general_ci NOT NULL,
  `email` char(80) collate latin1_general_ci NOT NULL,
  `objet` text collate latin1_general_ci NOT NULL,
  `service` text collate latin1_general_ci NOT NULL,
  `aleatoire` text collate latin1_general_ci NOT NULL,
  `date` varchar(30) collate latin1_general_ci NOT NULL,
  `statut` varchar(6) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_themes_slide`
--

DROP TABLE IF EXISTS `nuked_themes_slide`;
CREATE TABLE IF NOT EXISTS `nuked_themes_slide` (
  `id` int(11) NOT NULL auto_increment,
  `titre` text collate latin1_general_ci NOT NULL,
  `url` varchar(200) collate latin1_general_ci NOT NULL default '',
  `img` varchar(200) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_tournament_intro`
--

DROP TABLE IF EXISTS `nuked_tournament_intro`;
CREATE TABLE IF NOT EXISTS `nuked_tournament_intro` (
  `intro` text collate latin1_general_ci NOT NULL,
  `type` int(10) NOT NULL default '4',
  FULLTEXT KEY `intro` (`intro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_tournament_intro`
--

INSERT INTO `nuked_tournament_intro` (`intro`, `type`) VALUES
('Welcome to the Tournament. Please register!', 4),
('Welcome to the Tournament. Please register!', 4);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_tournament_match`
--

DROP TABLE IF EXISTS `nuked_tournament_match`;
CREATE TABLE IF NOT EXISTS `nuked_tournament_match` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(30) collate latin1_general_ci NOT NULL default '',
  `date` varchar(12) collate latin1_general_ci NOT NULL default '',
  `winner` int(11) NOT NULL default '0',
  `score1` int(11) NOT NULL default '0',
  `score2` int(11) NOT NULL default '0',
  `report` varchar(200) collate latin1_general_ci NOT NULL default '',
  `screen1` varchar(100) collate latin1_general_ci NOT NULL default '',
  `screen2` varchar(100) collate latin1_general_ci NOT NULL default '',
  `screen3` varchar(100) collate latin1_general_ci NOT NULL default '',
  `screen4` varchar(100) collate latin1_general_ci NOT NULL default '',
  `status1` varchar(100) collate latin1_general_ci NOT NULL default '',
  `status2` varchar(100) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

--
-- Contenu de la table `nuked_tournament_match`
--

INSERT INTO `nuked_tournament_match` (`id`, `title`, `date`, `winner`, `score1`, `score2`, `report`, `screen1`, `screen2`, `screen3`, `screen4`, `status1`, `status2`) VALUES
(1, '_TOURNAMENTWIN', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(2, '_TOURNAMENTHALFWIN1', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(3, '_TOURNAMENTHALFWIN2', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(4, '_TOURNAMENTQUARTER1', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(5, '_TOURNAMENTQUARTER2', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(6, '_TOURNAMENTQUARTER3', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(7, '_TOURNAMENTQUARTER4', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(8, '_TOURNAMENTEIGHTER1', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(9, '_TOURNAMENTEIGHTER2', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(10, '_TOURNAMENTEIGHTER3', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(11, '_TOURNAMENTEIGHTER4', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(12, '_TOURNAMENTEIGHTER5', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(13, '_TOURNAMENTEIGHTER6', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(14, '_TOURNAMENTEIGHTER7', '1471739338', 0, 0, 0, '', '', '', '', '', '', ''),
(15, '_TOURNAMENTEIGHTER8', '1471739338', 0, 0, 0, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_tournament_team`
--

DROP TABLE IF EXISTS `nuked_tournament_team`;
CREATE TABLE IF NOT EXISTS `nuked_tournament_team` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) collate latin1_general_ci NOT NULL default '',
  `tag` varchar(10) collate latin1_general_ci NOT NULL default '',
  `url` varchar(100) collate latin1_general_ci NOT NULL default '',
  `picture` varchar(100) collate latin1_general_ci NOT NULL default '',
  `leader` varchar(30) collate latin1_general_ci NOT NULL default '',
  `leadersteam` varchar(30) collate latin1_general_ci NOT NULL default '',
  `leaderid` varchar(20) collate latin1_general_ci NOT NULL default '',
  `mail` varchar(30) collate latin1_general_ci NOT NULL default '',
  `member1` varchar(30) collate latin1_general_ci NOT NULL default '',
  `steam1` varchar(30) collate latin1_general_ci NOT NULL default '',
  `member2` varchar(30) collate latin1_general_ci NOT NULL default '',
  `steam2` varchar(30) collate latin1_general_ci NOT NULL default '',
  `member3` varchar(30) collate latin1_general_ci NOT NULL default '',
  `steam3` varchar(30) collate latin1_general_ci NOT NULL default '',
  `member4` varchar(30) collate latin1_general_ci NOT NULL default '',
  `steam4` varchar(30) collate latin1_general_ci NOT NULL default '',
  `validated` int(1) NOT NULL default '0',
  UNIQUE KEY `name` (`name`,`tag`,`url`,`picture`,`mail`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_tmpses`
--

DROP TABLE IF EXISTS `nuked_tmpses`;
CREATE TABLE IF NOT EXISTS `nuked_tmpses` (
  `session_id` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `session_vars` text COLLATE latin1_general_ci NOT NULL,
  `session_start` bigint(20) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_ts3viewer`
--

DROP TABLE IF EXISTS `nuked_ts3viewer`;
CREATE TABLE IF NOT EXISTS `nuked_ts3viewer` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `ip` varchar(30) collate latin1_general_ci NOT NULL default '',
  `q_port` varchar(10) collate latin1_general_ci NOT NULL default '',
  `s_port` varchar(10) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_ts3viewer_pref`
--

DROP TABLE IF EXISTS `nuked_ts3viewer_pref`;
CREATE TABLE IF NOT EXISTS `nuked_ts3viewer_pref` (
  `id` int(11) NOT NULL auto_increment,
  `srvid` int(10) NOT NULL default '1',
  `width_module` int(10) NOT NULL default '500',
  `width_blok` int(10) NOT NULL default '200',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_ts3viewer_pref`
--

INSERT INTO `nuked_ts3viewer_pref` (`id`, `srvid`, `width_module`, `width_blok`) VALUES
(1, 1, 500, 250);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_userbox`
--

DROP TABLE IF EXISTS `nuked_userbox`;
CREATE TABLE IF NOT EXISTS `nuked_userbox` (
  `mid` int(50) NOT NULL AUTO_INCREMENT,
  `user_from` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_for` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `titre` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `message` text COLLATE latin1_general_ci NOT NULL,
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `user_from` (`user_from`),
  KEY `user_for` (`user_for`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_users`
--

DROP TABLE IF EXISTS `nuked_users`;
CREATE TABLE IF NOT EXISTS `nuked_users` (
  `id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `team` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `team2` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `team3` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `rang` int(11) NOT NULL DEFAULT '0',
  `ordre` int(5) NOT NULL DEFAULT '0',
  `pseudo` text COLLATE latin1_general_ci NOT NULL,
  `mail` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `icq` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `msn` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `aim` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `yim` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` varchar(150) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pass` varchar(80) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `niveau` int(1) NOT NULL DEFAULT '0',
  `date` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `avatar` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `signature` text COLLATE latin1_general_ci NOT NULL,
  `user_theme` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_langue` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `game` int(11) NOT NULL DEFAULT '0',
  `country` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `count` int(10) NOT NULL DEFAULT '0',
  `erreur` int(10) NOT NULL DEFAULT '0',
  `token` varchar(13) COLLATE latin1_general_ci DEFAULT NULL,
  `token_time` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `xfire` varchar(50) collate latin1_general_ci default NULL,
  `facebook` varchar(50) collate latin1_general_ci default NULL,
  `origin` varchar(50) collate latin1_general_ci default NULL,
  `steam` varchar(50) collate latin1_general_ci default NULL,
  `twitter` varchar(50) collate latin1_general_ci default NULL,
  `skype` varchar(50) collate latin1_general_ci default NULL,
  PRIMARY KEY (`id`),
  KEY `team` (`team`),
  KEY `team2` (`team2`),
  KEY `team3` (`team3`),
  KEY `rang` (`rang`),
  KEY `game` (`game`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `nuked_users`
--

--
-- Login / MDP : admin / admin
-- Tip : Regenerate new password with "Lost password".
-- Info : Regénérez un nouveau pass avec la fonction mot de passe perdu.
--

INSERT INTO `nuked_users` (`id`, `team`, `team2`, `team3`, `rang`, `ordre`, `pseudo`, `mail`, `email`, `icq`, `msn`, `aim`, `yim`, `url`, `pass`, `niveau`, `date`, `avatar`, `signature`, `user_theme`, `user_langue`, `game`, `country`, `count`, `erreur`, `token`, `token_time`) VALUES
('zbdwzpdqq76N3XirqaC0', '', '', '', 0, 0, 'admin', 'admin@admin.com', '', '', '', '', '', '', '#6d6f0c5908203486612affee75bd500e6', 9, '1352563028', '', '', '', '', 1, 'France.gif', 0, 0, '', '0');

-- --------------------------------------------------------

--
-- Structure de la table `nuked_users_config`
--

DROP TABLE IF EXISTS `nuked_users_config`;
CREATE TABLE IF NOT EXISTS `nuked_users_config` (
  `id` int(11) NOT NULL auto_increment,
  `mail` text collate latin1_general_ci NOT NULL,
  `icq` text collate latin1_general_ci NOT NULL,
  `msn` text collate latin1_general_ci NOT NULL,
  `aim` text collate latin1_general_ci NOT NULL,
  `yim` text collate latin1_general_ci NOT NULL,
  `xfire` text collate latin1_general_ci NOT NULL,
  `facebook` text collate latin1_general_ci NOT NULL,
  `originea` text collate latin1_general_ci NOT NULL,
  `steam` text collate latin1_general_ci NOT NULL,
  `twiter` text collate latin1_general_ci NOT NULL,
  `skype` text collate latin1_general_ci NOT NULL,
  `lien` text collate latin1_general_ci NOT NULL,
  `nivoreq` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `nuked_users_config`
--

INSERT INTO `nuked_users_config` (`id`, `mail`, `icq`, `msn`, `aim`, `yim`, `xfire`, `facebook`, `originea`, `steam`, `twiter`, `skype`, `lien`, `nivoreq`) VALUES
(1, 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 0);

-- --------------------------------------------------------

--
-- Structure de la table `nuked_users_detail`
--

DROP TABLE IF EXISTS `nuked_users_detail`;
CREATE TABLE IF NOT EXISTS `nuked_users_detail` (
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `prenom` text COLLATE latin1_general_ci,
  `age` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `sexe` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ville` text COLLATE latin1_general_ci,
  `photo` varchar(150) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `motherboard` text COLLATE latin1_general_ci,
  `cpu` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `ram` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `video` text COLLATE latin1_general_ci,
  `resolution` text COLLATE latin1_general_ci,
  `son` text COLLATE latin1_general_ci,
  `ecran` text COLLATE latin1_general_ci,
  `souris` text COLLATE latin1_general_ci,
  `clavier` text COLLATE latin1_general_ci,
  `connexion` text COLLATE latin1_general_ci,
  `system` text COLLATE latin1_general_ci,
  `pref_1` text COLLATE latin1_general_ci NOT NULL,
  `pref_2` text COLLATE latin1_general_ci NOT NULL,
  `pref_3` text COLLATE latin1_general_ci NOT NULL,
  `pref_4` text COLLATE latin1_general_ci NOT NULL,
  `pref_5` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_video`
--

DROP TABLE IF EXISTS `nuked_video`;
CREATE TABLE IF NOT EXISTS `nuked_video` (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` text collate latin1_general_ci NOT NULL,
  `type` text collate latin1_general_ci NOT NULL,
  `titre` text collate latin1_general_ci NOT NULL,
  `description` text collate latin1_general_ci NOT NULL,
  `image` text collate latin1_general_ci NOT NULL,
  `status` text collate latin1_general_ci NOT NULL,
  `lien` text collate latin1_general_ci NOT NULL,
  `vue` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_video_cat`
--

DROP TABLE IF EXISTS `nuked_video_cat`;
CREATE TABLE IF NOT EXISTS `nuked_video_cat` (
  `idcat` int(11) NOT NULL auto_increment,
  `categorie` text collate latin1_general_ci NOT NULL,
  `statuscat` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idcat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_vote`
--

DROP TABLE IF EXISTS `nuked_vote`;
CREATE TABLE IF NOT EXISTS `nuked_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `vid` int(100) DEFAULT NULL,
  `ip` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `vote` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nuked_Wow_recrutement`
--

DROP TABLE IF EXISTS `nuked_Wow_recrutement`;
CREATE TABLE IF NOT EXISTS `nuked_Wow_recrutement` (
  `classes` varchar(50) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `role` mediumtext NOT NULL,
  `color` varchar(7) NOT NULL,
  KEY `statut` (`statut`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `nuked_Wow_recrutement`
--

INSERT INTO `nuked_Wow_recrutement` (`classes`, `statut`, `role`, `color`) VALUES
('_SHAMAN', 'on', '1|1|1', '1353DE'),
('_ROGUE', 'on', '1|1|1', 'DEF569'),
('_PRIEST', 'on', '1|1|1', 'FFFFFF'),
('_PALADIN', 'on', '1|1|1', 'F58CBA'),
('_DK', 'on', '1|1|1', 'A91F3B'),
('_MAGE', 'on', '1|1|1', '69CCD1'),
('_HUNT', 'on', '1|1|1', 'ABD464'),
('_DRUID', 'on', '1|1|1', 'E38512'),
('_WARLOCK', 'on', '1|1|1', '764B80'),
('_WARRIOR', 'on', '1|1|1', '804000'),
('_PANDAREN', 'on', '1|1|1', '008467');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
