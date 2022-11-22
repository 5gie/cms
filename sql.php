<?php
require_once('./vendor/autoload.php');
require_once('./config/parameters.php');
use Src\Config\Db;

$install['employee'] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "employee` (
  `id_employee` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `email` VARCHAR(250) NOT NULL,
  `password` VARCHAR(250) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `reset_password_token` VARCHAR(250) NULL,
  `date_add` datetime,
  `date_upd` datetime,
  PRIMARY KEY (`id_employee`),
  INDEX (`id_employee`),
  INDEX (`email`)
) DEFAULT CHARSET=utf8";

// $install[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "powerpage_section` (
//   `id_powerpage_section` INT UNSIGNED NOT NULL AUTO_INCREMENT,
//   `id_powerpage` INT UNSIGNED NOT NULL,
//   `type` VARCHAR(10) NOT NULL,
//   `active` tinyint(1) NOT NULL DEFAULT '0',
//   `sort` int(5) NOT NULL,
//   `date_add` datetime,
//   `date_upd` datetime,
//   PRIMARY KEY (`id_powerpage_section`),
//   INDEX (`id_powerpage_section`),
//   INDEX (`id_powerpage`),
//   INDEX (`sort`)
// ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

// $install[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "powerpage_item` (
//   `id_powerpage_item` INT UNSIGNED NOT NULL AUTO_INCREMENT,
//   `id_powerpage_section` INT UNSIGNED NOT NULL,
//   `sort` int(5) NOT NULL,
//   `image` varchar(250) NOT NULL DEFAULT '',
//   `custom` varchar(250) NOT NULL DEFAULT '',
//   `id_object` INT UNSIGNED NULL,
//   `date_add` datetime,
//   `date_upd` datetime,
//   PRIMARY KEY (`id_powerpage_item`),
//   INDEX (`id_powerpage_item`),
//   INDEX (`id_powerpage_section`),
//   INDEX (`sort`)
// ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

// $install[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "powerpage_item_lang` (
//   `id_powerpage_item` INT UNSIGNED NOT NULL,
//   `id_lang` int(10) unsigned NOT NULL ,
//   `title` varchar(250) NOT NULL,
//   `content` longtext NOT NULL,
//    PRIMARY KEY (`id_powerpage_item`, `id_lang`),
//    INDEX (`id_powerpage_item`),
//    INDEX (`id_lang`),
//    INDEX (`title`)
// ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

foreach($install as $key => $sql){
    if(!Db::getInstance()->execute($sql)){
        echo 'Błąd przy instalacji bazy ' . $key . '<br>';
    }
}