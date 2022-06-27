# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.3.34-MariaDB-0ubuntu0.20.04.1)
# Database: scarlet_live
# Generation Time: 2022-06-26 15:19:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table clans
# ------------------------------------------------------------

LOCK TABLES `clans` WRITE;
/*!40000 ALTER TABLE `clans` DISABLE KEYS */;

INSERT INTO `clans` (`id`, `name`, `shortName`)
VALUES
    (1,'Australian Armed Forces - Apex Testing','AAF - AT'),
    (2,'Australian Armed Forces','AAF'),
    (3,'Blocked','Blocked');

/*!40000 ALTER TABLE `clans` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------



# Dump of table password_resets
# ------------------------------------------------------------



# Dump of table users
# ------------------------------------------------------------

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `type`, `key`, `installDir`, `comment`, `clanID`, `remember_token`, `created_at`, `updated_at`, `remark`, `playerID`)
VALUES
    (16,'gnrnr',NULL,'special','aa954ba504ae0c9e421b0d531e2e4b4a',NULL,NULL,0,NULL,NULL,'2021-10-25 07:29:18',NULL,NULL),
    (17,'bluey','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6','leader','b1ff923140c7a4c815e46825205ea3eb','D:\\Steam\\SteamApps\\common\\Arma 3',NULL,0,NULL,NULL,'2021-11-10 07:31:00','The Bloke in Charge',NULL),
    (24,'antipop','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6\n','special','86db73982a25796055cb34587b4a247d',NULL,'',0,NULL,NULL,'2021-10-25 07:20:28','Part Time Ghost',NULL),
    (28,'omega','$2y$10$xPTDzxsirHYitfxnCnY0E.9O6keDsqkTjKFTtzlQ09DPa0Bz8G7hW','veteran','42de65d777b8bcb2a2cf5396c87f8508','\\\\Mac\\Home\\Desktop',NULL,2,NULL,NULL,'2022-05-23 16:15:29','Software Engineer and Web Developer','76561198016006482'),
    (29,'det0n8ted','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6','staff','70136a6e2b9b97c2480af57363ca06f1','D:\\Steam\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,'2021-11-10 05:26:45','External Unit liaison','76561198008930274'),
    (31,'Jazza','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6','special','ff639169c79fa99e084363af3182040e','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,'2022-06-07 11:12:32','Lead Mission Maker','76561198015817978'),
    (32,'AUserver',NULL,'special','229d8da81dadd0129407d08f77e3c110','C:\\Games',NULL,0,NULL,NULL,'2022-06-03 07:40:36','',NULL),
    (39,'leno',NULL,'member','a73b2af6de927deb40c8a236c4ccf505','D:\\Games\\SteamLibrary\\steamapps\\common\\Arma 3\\Mods',NULL,0,NULL,NULL,'2020-08-12 10:33:44','',NULL),
    (46,'Monty','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6','staff','6bd6e4c26978b5c0b5bf6c67a8fc88b3','G:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,'2022-01-24 07:21:22','Mods Admin','76561198000746503'),
    (70,'Aliasalpha',NULL,'member','15a93766bab066fecb5c6262bbfd8a40','H:\\SteamLibrary\\steamapps\\Common\\Arma 3',NULL,0,NULL,NULL,'2022-06-19 09:54:57','',NULL),
    (97,'skyth',NULL,'member','4a6b92df08c35f26047e925916416c6b',NULL,NULL,0,NULL,NULL,'2022-02-25 23:38:17','Staff',NULL),
    (101,'MeltingPineapple',NULL,'member','44997bc9483711418bba036041b49bff','E:\\AAF',NULL,0,NULL,NULL,'2018-07-06 03:46:32','',NULL),
    (142,'Franc0',NULL,'member','f6935cb0253e6dae27392655be4dab2a','G:\\Steam\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,'2019-12-09 08:26:12','Does all the Things',NULL),
    (201,'lachy',NULL,'member','049a73f38549a51f2d44a69dd8fbf4fc','M:\\Steam Games\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,'2020-08-01 03:54:52','',NULL),
    (273,'Shadow',NULL,'member','b49de85d2dfd94a03fea0e60328b5439','G:\\Games\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,NULL,'',NULL),
    (353,'capt. spectre',NULL,'staff','c86ac5925f58f3f9c8b477e433dbb583','D:\\Steam\\SteamApps\\common\\Arma 3',NULL,0,NULL,NULL,'2021-11-13 07:39:43','Training Admin',NULL),
    (369,'hulksey','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6','staff','165c906b0cadf407c2ce8942373d8691','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,0,NULL,NULL,'2021-11-10 05:43:13','Mission Making Admin',NULL),
    (395,'wee',NULL,'member','90fc03d05667c65af4d3865f16c2f5ec','F:\\',NULL,1,NULL,NULL,'2022-03-12 14:58:06','',NULL),
    (405,'ljfox',NULL,'member','17cc14ddc1c96b8b00dc7a7387f73d25','C:\\SteamLibrary\\steamapps\\common\\Arma 3\\AAF MODS',NULL,1,NULL,NULL,'2021-08-31 04:55:25','',NULL),
    (471,'mccready',NULL,'member','39a22d906ae91c5168517ee9fa9d8dd4','E:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2017-06-17 13:25:35','2020-08-01 03:59:30','',NULL),
    (484,'Hipster Pingu',NULL,'member','d8697b5fb64089f23cf0aa14a4bf3142','C:\\Users\\brend\\Desktop',NULL,2,NULL,'2017-06-23 07:35:09','2021-07-27 11:48:17','',NULL),
    (545,'SneakingTurtle',NULL,'recruit','0535b331d8688beb51a1cef39a784d15','D:\\SteamLibrary\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2017-08-01 09:03:09','2022-03-07 05:17:25','',NULL),
    (552,'TheIronTank',NULL,'member','8a5b8f186e0ad7fd0798051a8c0dbf44','E:\\SteamLibrary\\SteamApps\\common\\Arma 3',NULL,2,NULL,'2017-08-07 07:31:17','2018-04-25 12:19:44','',NULL),
    (555,'Cryptic',NULL,'member','941694a9eb29125ed31cca19aec890ad','A:\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2017-08-07 07:33:11','2022-04-30 07:34:45','',NULL),
    (566,'AussieArchAngel',NULL,'member','16bf75a89a563cd304002c755c8114e2','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2017-08-18 12:49:31','2020-09-19 00:08:23','',NULL),
    (596,'otaKhu',NULL,'member','d5ffd4e77f2c22dfb16a2804bf620eec','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2017-09-06 08:18:28','2021-01-16 02:15:52','',NULL),
    (680,'Rajiin','$2y$10$bV0F9XmVHgVgYxjonq96OexySVJ4DoYXCRgaNjS/zBOU940StgEI2','staff','0bea7e76c16cfb1a7e3135d51dc268e4','E:\\Arma 3 (AAF mods)\\Scarlet Downloaded mods',NULL,2,NULL,'2017-11-26 06:17:28','2022-02-04 12:23:19','Head Recruiter',NULL),
    (681,'Lightning','$2y$10$niWmmqjQUZb5LK/Wx6OMVOyxhs7V1xagrJo8CxObfea2..jwRwAf6','staff','8fde8acda4acf72fa83c434d2d9f6ed0','F:\\Games\\steamapps\\common\\Arma 3',NULL,2,NULL,'2017-11-26 08:06:41','2021-11-10 01:04:45','Communications Specialist',NULL),
    (683,'Snipe',NULL,'member','25098c3d37d0abeb2cf6a60be178fc78','S:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2017-11-27 05:51:02','2020-12-18 08:38:15',NULL,'76561198038614629'),
    (738,'BlackIrishGuy',NULL,'member','7474920bc4db6416f9f2a09f9abdafbc','D:\\Games\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-01-10 07:28:23','2022-02-01 08:55:26','',NULL),
    (820,'Samus',NULL,'member','e711f2d24820d315e155bf13df667712','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-04-19 08:00:43','2018-07-28 11:52:01','',NULL),
    (872,'Heffio',NULL,'member','e3c082e0a9ef2c4c863a0e3888874e7e','F:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-05-17 09:08:43','2022-02-27 08:27:53',NULL,NULL),
    (881,'Thane1607',NULL,'member','d7d5f0fa6a8c2c3b44b66a80929018ce','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-05-17 09:10:51','2020-09-06 06:50:28','',NULL),
    (887,'Fitzypyro',NULL,'member','0da6808163055747f16bed972cb33648','E:\\Program Files (x86)\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-05-30 08:13:08','2020-11-08 12:51:50','',NULL),
    (897,'Slaodacht',NULL,'member','6266b306da2b41fb6439a39a7c8712f5','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-06-10 06:06:40','2021-07-19 06:06:46','',NULL),
    (906,'TheRiddler',NULL,'member','9eed00e9011e6eb6ef1f8256a6db1612','D:\\Steam NVMe SSD\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-06-16 23:01:19','2021-09-18 10:28:45','',NULL),
    (923,'AussieScotsman',NULL,'member','2f8ed3fd60309a0780999bf599e19be8','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-06-29 07:37:10','2020-12-19 00:14:46','',NULL),
    (933,'Deadpell',NULL,'member','f34b05d0d38f7750aa0404914bbee0ae','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-06-30 01:38:37','2020-08-04 08:54:31','',NULL),
    (947,'gurnhawk',NULL,'member','340e926957767430959e5959a3ed52aa','F:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-07-16 08:26:44','2018-10-03 12:29:15','',NULL),
    (953,'ypk2909',NULL,'member','25c6a110fc7ff4ad3a869e2f8a9d6b76','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-07-16 08:28:40','2021-08-18 06:57:00','',NULL),
    (1016,'Mother77',NULL,'member','11e0e4e24c36fcaa86c3277bad7c29c7','D:\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-10-10 04:50:04','2022-02-28 09:17:49',NULL,NULL),
    (1078,'stuba',NULL,'member','23a660d0537946daed8d8f5528a4476f','F:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2018-12-14 07:02:53','2020-10-22 07:44:06','',NULL),
    (1091,'Razorwork',NULL,'member','a38b72bea53a0961783ad7d5ff7d34f8','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-01-06 10:21:58','2020-01-01 09:30:24','',NULL),
    (1100,'Graham',NULL,'member','007dd4b26897961493392aca4888a984','E:\\Steam\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2019-01-10 22:27:22','2022-06-25 03:39:55','',NULL),
    (1101,'Mayhem',NULL,'special','76bbdb2be9f823416d744e9c4a8b3c34','','[Mav] Group (Split off from ZSU)',2,NULL,'2019-01-24 08:00:06','2020-07-31 12:47:35','',NULL),
    (1116,'Ryan',NULL,'member','f275dc84233bcd772c569fbe22c9ac25','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-01-28 09:18:26','2020-08-06 10:29:58','',NULL),
    (1119,'Strutty',NULL,'member','2ce76b7e63afcd97972663654f0bdacc','X:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-01-28 09:18:43','2020-11-25 11:59:15','',NULL),
    (1152,'Definta',NULL,'member','42042e345e30991d5a626b0925a8b6b3','E:\\Games\\Steam Games\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-04-02 08:08:23','2020-08-16 05:19:21','',NULL),
    (1207,'Puddleflop',NULL,'member','54e970b3fd5c54a82ce48fd56fd3a422','G:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-06-30 09:42:26','2022-02-15 07:04:50','',NULL),
    (1223,'Solid Raptor',NULL,'member','707633aa261e0b2e346081acaed7c66a','E:\\Games\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-07-29 09:23:01','2020-08-01 09:04:54','',NULL),
    (1225,'Furnace',NULL,'member','6538e92b497761f652936a0727ef6537','C:\\Program Files (x86)\\Steam\\SteamApps\\common\\Arma 3',NULL,2,NULL,'2019-08-08 08:13:37','2019-12-07 08:35:35','',NULL),
    (1227,'Princess Andromeda',NULL,'member','65bd59026fd89d22cd148dc1bf2b6f65','E:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-08-08 08:14:03','2021-03-01 09:37:18','',NULL),
    (1229,'Riceball985',NULL,'member','1ebfdb126802e3beea0ccb5d5e84f3ad','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-08-24 05:03:02','2021-05-19 04:35:48','',NULL),
    (1246,'jick16',NULL,'member','bd369e3b2566999cb40babeb13b4c7b2','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-10-02 03:50:54','2021-02-24 11:10:00','',NULL),
    (1251,'Grimshot',NULL,'member','2343d3b6d218faf77bfe0b2709a73028','G:\\steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2019-10-06 08:51:30','2021-10-23 08:47:42','',NULL),
    (1252,'Kaneki','$2y$10$IxIF3oWuXU5umNiBrAuzY.NK2haiP82FZQ.SWf6YoHLQCSWNOi.WC','member','b5f8fe0b9927f86c90760dafedb31fc7','E:\\Scarlet',NULL,2,NULL,'2019-10-06 08:52:11','2022-02-15 10:31:38','',NULL),
    (1254,'L3ad_Magn3t',NULL,'member','cbd6b1c41527080a72bd7d31192490fc','G:\\Battlestate Games\\@mods',NULL,2,NULL,'2019-10-06 08:52:44','2021-09-18 10:04:34','',NULL),
    (1261,'Wikus',NULL,'member','2cc17a956245d7b50677ddefd2443b10','F:\\Steam\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2019-10-06 08:53:48','2021-02-14 07:52:02','',NULL),
    (1316,'bmatt155',NULL,'member','27244a2aa4380c82e1c59a220139576d','D:\\',NULL,2,NULL,'2020-02-11 09:55:06','2020-09-21 10:07:52','',NULL),
    (1339,'Sharp',NULL,'member','98b38ed95b74811651aefc247561c3d9','C:\\',NULL,2,NULL,'2020-03-31 08:37:43','2021-10-19 10:44:24','',NULL),
    (1391,'wrickerish',NULL,'member','d5c2c10a8f25ee4e027a9d2d140e5f2b','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2020-07-22 08:52:04','2021-11-04 06:07:57','',NULL),
    (1394,'Atlas',NULL,'member','26cc609591b38ef41726c1889245b213','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2020-08-01 04:40:28','2022-04-09 09:44:18','',NULL),
    (1407,'AAFServer_HC',NULL,'special','2a6a40a8a458d6a35843b7fa1692639d',NULL,NULL,2,NULL,'2020-08-11 11:50:28','2022-02-12 07:45:54','',NULL),
    (1414,'Greg',NULL,'member','e2efeac49accd7821f960529c483c481','C:\\Modding',NULL,2,NULL,'2020-09-06 09:30:13','2022-03-14 09:06:28','',NULL),
    (1415,'M3rKiN',NULL,'member','b0fc5451a729b90e18ddeda1615fac79','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2020-09-06 09:30:26','2021-08-08 07:27:11','',NULL),
    (1425,'sultanofdarts',NULL,'member','f0453b066e757f729ca25890f59e2d14','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2020-10-03 05:46:53','2021-10-08 07:42:10','',NULL),
    (1443,'Salad',NULL,'member','4fc6aa17a6293a9cb301054f145a2f0b','D:\\Steam\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2020-11-08 09:39:30','2021-10-24 10:50:30','',NULL),
    (1453,'Jarrod',NULL,'member','3e74038ab5c5ca29551295dd489aa3f5','B:\\SteamLibrary\\steamapps\\common\\Arma 3\\AAF mods',NULL,2,NULL,'2020-12-06 08:47:43','2022-04-30 01:13:46','',NULL),
    (1479,'Avelyne',NULL,'applicant','f9c3ae4a399edb55f6766bcd284e2f74','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\Scarlet',NULL,2,NULL,'2021-01-10 08:47:24','2021-12-01 05:49:31','',NULL),
    (1518,'arcadian_angel',NULL,'member','190ac57d144a47e4c0673dfd246a7a8c','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-02-28 08:44:17','2021-10-23 02:48:49','',NULL),
    (1531,'vyncis',NULL,'member','2f297b98ff17c444d5bfdb7fa7b60dd3','E:\\My Stuff\\Games\\Steam\\SteamApps\\common\\Arma 3',NULL,2,NULL,'2021-02-28 08:48:42','2022-03-02 03:32:55','',NULL),
    (1536,'DasGI',NULL,'member','a59cbccd9c39e6cdf2e3ca1056c90d96','D:\\',NULL,2,NULL,'2021-03-28 08:37:44','2021-12-07 23:18:22','',NULL),
    (1553,'Milkshakedelux',NULL,'applicant','c16cac516e25c25bc5cae664f5246c64',NULL,NULL,2,NULL,'2021-04-25 10:01:17','2022-06-13 09:13:37','',NULL),
    (1554,'Grey111',NULL,'member','dd120114c3034998f4384248ffb4b5c5','E:\\Scarlett Thing',NULL,2,NULL,'2021-04-25 10:02:12','2021-11-09 11:20:48','',NULL),
    (1557,'BBK',NULL,'applicant','7e06ab7b826a57d44c912c27341220c7',NULL,NULL,2,NULL,'2021-05-23 09:57:03','2022-02-26 00:34:30',NULL,NULL),
    (1561,'Murgos',NULL,'member','4754bad48f87327b152a6a12c8e38852','D:\\Games\\Mods\\ARMA 3',NULL,2,NULL,'2021-05-23 09:57:36','2022-01-25 07:19:48','',NULL),
    (1567,'forux',NULL,'member','fd3b44efe62b9aa4290a23a0ce3b2a2c','G:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-06-06 06:26:08','2022-02-27 05:11:27','',NULL),
    (1578,'PBRStreetgang',NULL,'member','470ce4769bae2fbffd818aae654168fe','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-06-29 09:57:57','2022-03-02 05:13:07','',NULL),
    (1579,'Bosscow',NULL,'member','e20408e27a7b02f95419489891fe8ec6','C:\\Users\\User\\Desktop\\AAF Arma Mods',NULL,2,NULL,'2021-07-05 09:10:54','2021-07-06 01:21:41','',NULL),
    (1605,'Luna',NULL,'recruit','75aa6a9e898ec5d892f07e9a8ada050c','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\arma 3 scarlet mods',NULL,2,NULL,'2021-09-27 08:00:03','2021-12-08 08:04:27','',NULL),
    (1613,'Wilson',NULL,'member','26882b1be2210ff0577aa8560d1a829c','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2021-10-22 09:19:05','2021-10-23 09:58:11','',NULL),
    (1615,'Khan',NULL,'applicant','04c8303427471f616d4e79da65284ded','G:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-22 09:49:10','2021-10-22 09:59:26','',NULL),
    (1616,'Dreamer',NULL,'member','9fe4bc771719c64af743a020fcc60286','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-22 10:22:24','2022-03-29 08:12:38','',NULL),
    (1618,'Pac of Ace',NULL,'applicant','29196326ddf6a1541bc5b00cd24e276f','D:\\Games\\AAF Mods',NULL,2,NULL,'2021-10-22 11:42:02','2021-10-23 09:41:47','',NULL),
    (1620,'Rabinist',NULL,'applicant','3d41727e9c90e80a79d0be937032f984','C:\\Program Files (x86)\\Steam Library\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-23 08:18:52','2021-10-23 08:38:06','',NULL),
    (1621,'Cinnamon',NULL,'applicant','13b37981654f8d5937000acb1c8fe413','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-23 08:19:04','2022-04-01 10:33:33','',NULL),
    (1622,'tsutek',NULL,'applicant','310290018ed273a9da314bc938dc9036','M:\\Games\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-23 08:24:18','2022-01-25 09:36:04','',NULL),
    (1623,'PSYKOPUFF',NULL,'member','25fbcb84e67673e60c3c2532094ff00d','C:\\Program Files\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-23 10:22:57','2022-05-01 09:11:52','',NULL),
    (1625,'Gillian',NULL,'applicant','67383ab1237f7247f6ac7810e1a26825','D:\\',NULL,2,NULL,'2021-10-24 08:51:58','2021-10-24 09:01:42','',NULL),
    (1626,'SuborbitalBacon',NULL,'applicant','b2cfe7f018a6cbb09276d38a4164f8e5','E:\\arma_mods',NULL,2,NULL,'2021-10-24 08:52:48','2021-10-24 08:56:02','',NULL),
    (1627,'Timbo4p78',NULL,'applicant','9d20dd45408d82fd92cd2480a08db6e9','T:\\Not Steam\\steamapps\\AAF Mods',NULL,2,NULL,'2021-10-24 08:52:59','2021-10-24 09:07:46','',NULL),
    (1628,'Iain',NULL,'applicant','260ebf90f5fb2f8a23fdfbaeab4b92d1','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-26 08:00:27','2021-10-26 08:01:33','',NULL),
    (1629,'Grizz',NULL,'member','00d635a65fd840a6237f06ff635b59cb','F:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-26 08:36:37','2022-03-30 08:14:12','',NULL),
    (1630,'Maso',NULL,'recruit','0d766aa70505b6997cd48b6964323144','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-10-26 08:46:21','2021-10-26 08:47:53','',NULL),
    (1633,'James',NULL,'applicant','c1af3db723bb6f6b6e4f8e0f9a72f9de','F:\\Steam Games\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2021-10-28 08:30:07','2021-10-28 08:31:27','',NULL),
    (1634,'Mav',NULL,'applicant','a2834754745d59ca81d6b69d760a8817','D:\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-02 07:50:23','2021-11-12 06:17:34','',NULL),
    (1635,'Tashi',NULL,'recruit','fb62ab4501291d5719828c5f06e9007f','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-08 07:23:03','2021-11-13 08:57:54','',NULL),
    (1636,'Joeiron3',NULL,'member','92930279abde68b9a3ac3a9550bfa85e','D:\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-09 12:08:26','2022-02-27 08:53:14','',NULL),
    (1638,'Goose',NULL,'applicant','c36bd167ece900472aa533513d573918','G:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-28 08:38:07','2022-02-11 12:00:13','',NULL),
    (1639,'Inferno',NULL,'applicant','c6400ab8147f7604470b57e5ce0a3bf5','F:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-28 08:38:14','2021-11-28 08:48:04','',NULL),
    (1640,'kronk',NULL,'applicant','05b1c892be62dcb8cc5d603923ebcdbd','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-28 08:38:21','2021-11-28 08:53:00','',NULL),
    (1641,'TTFun',NULL,'applicant','3b94ccf9c12cf5cf58ce8697a3cd30c9','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-28 08:38:28','2022-02-10 08:09:58','',NULL),
    (1642,'Wardo1098',NULL,'applicant','fc64086ae8f8553e4c8fc41684b42588','D:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-28 08:38:42','2021-11-28 08:48:06','',NULL),
    (1643,'Falcon Charade',NULL,'applicant','1f87ba043aa01966e4c81d766d768cb6','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-11-28 08:50:56','2021-11-28 08:51:56','',NULL),
    (1645,'MrBrain',NULL,'applicant','dba039a18d1f691b3285dca25784e005','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-12-07 08:04:58','2021-12-07 08:09:47','',NULL),
    (1648,'banna_man',NULL,'applicant','71e6b408ad6bb8607b3d9b5fe452965e','D:\\steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-12-21 08:38:06','2021-12-21 08:47:52','',NULL),
    (1649,'grandcell2',NULL,'applicant','7b8fb302cdc1ba88af6b45364c88badb','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2021-12-21 08:38:20','2021-12-21 08:47:25','',NULL),
    (1650,'purple',NULL,'applicant','37fa21dcdbb226481664406e7532fb53','D:\\New folder\\New folder',NULL,2,NULL,'2021-12-21 08:38:29','2021-12-21 08:40:42','',NULL),
    (1652,'StellarChief',NULL,'member','d7458f1b42abd85abedc29d0005a4f5c','F:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-03 07:52:01','2022-01-03 07:54:08','',NULL),
    (1653,'Cthulioh',NULL,'applicant','196e3f41ada7579d7ccb0a0de3cd4219','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-09 08:56:44','2022-06-13 09:19:07','',NULL),
    (1654,'Grssade',NULL,'applicant','f3da8029dc8303e1bc3e569a6dfde8d4','D:\\AAF',NULL,2,NULL,'2022-01-09 08:57:07','2022-01-31 03:25:45','',NULL),
    (1655,'Shcho',NULL,'applicant','e65702a195105ef751a059d6ef24f7b3','C:\\Users\\Joshua Mierocha\\Documents\\Arma 3 - Other Profiles\\Shcho',NULL,2,NULL,'2022-01-09 08:57:16','2022-01-09 09:00:23','',NULL),
    (1656,'Skyscraper',NULL,'applicant','410189bbf9f87e2798cb49efb9563d2b','C:\\Users\\Lenovo\\Desktop\\AAF MODS',NULL,2,NULL,'2022-01-09 08:58:31','2022-01-09 09:01:29','',NULL),
    (1657,'WorstPres',NULL,'applicant','ab7656914bfeaa49f2ee0c9d5f673414','C:\\Users\\Kaleb\\OneDrive\\Documents\\AAF Mods\\@Mods_AAF',NULL,2,NULL,'2022-01-09 08:58:44','2022-03-13 02:18:48','',NULL),
    (1658,'AfricanApe',NULL,'applicant','c9ededc0cf142d373506a04006d519b8','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\Addons',NULL,2,NULL,'2022-01-09 10:20:31','2022-01-09 13:45:13','',NULL),
    (1659,'Zammyy01',NULL,'applicant','bb12df739b1c2b54a1ed31988e333bba','G:\\steam games\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-10 08:07:09','2022-01-10 08:11:07','',NULL),
    (1660,'Stendogz',NULL,'member','7b8e7b8c8cbda8c52c2281e8c244f42b','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\ModsAAF',NULL,2,NULL,'2022-01-23 00:21:27','2022-01-23 00:22:21','',NULL),
    (1663,'Beanie',NULL,'applicant','afcf43637d1bae9ac78f18f7f7ddbe10','X:\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-23 08:45:28','2022-01-23 08:49:06','',NULL),
    (1664,'GruntBuster7',NULL,'applicant','0babaa0339790c067679e23a5d962d98','G:\\Games\\SteamLibrary3\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-23 08:45:43','2022-01-23 23:24:49','',NULL),
    (1665,'Milkman',NULL,'applicant','b9cf1cef731cd0e8acfe6b4561f45869','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-23 08:45:51','2022-01-23 08:48:16','',NULL),
    (1666,'Sour Grain',NULL,'applicant','325ea78874f47d9d44e053f42924680c','D:\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-01-23 08:45:59','2022-01-23 08:48:12','',NULL),
    (1667,'jason0977',NULL,'applicant','490782afe6c9285221570a45c21eead3','D:\\',NULL,2,NULL,'2022-01-24 08:10:13','2022-01-24 08:18:47','',NULL),
    (1670,'Quinn',NULL,'member','3e1904a16daac1132d1022f757861be2','D:\\SteamLibrary\\steamapps\\common\\Arma 3\\!Workshop',NULL,2,NULL,'2022-02-16 06:12:13','2022-03-05 08:50:43','',NULL),
    (1672,'PXRA',NULL,'applicant','c92db2dc435689b24ed4bc9e7579d05d','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-02-19 07:04:55','2022-02-19 07:05:41','',NULL),
    (1673,'MaddieJ',NULL,'recruit','30d5202671ad1c4b43bd34dc5f911db2','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\Mods',NULL,2,NULL,'2022-02-19 12:02:01','2022-02-19 12:07:53','',NULL),
    (1674,'Blumenkranz',NULL,'applicant','9af7f667d0e12e240b10a25bfd0848da','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-02-20 08:48:04','2022-02-20 08:58:42','',NULL),
    (1675,'Delphy',NULL,'applicant','b4da503195775ef7c3dc2805547fd5da','C:\\Vidya\\ArmA 3 AAF Mods',NULL,2,NULL,'2022-02-20 08:48:11','2022-02-20 08:57:29','',NULL),
    (1676,'LukeP',NULL,'applicant','f5d7b40cc39f3c4b4f0f5e663a019337','I:\\AAF_Mods',NULL,2,NULL,'2022-02-20 08:48:18','2022-02-20 09:11:20','',NULL),
    (1677,'Quick',NULL,'applicant','e257de974a401e2feddd7f2d2e260c72','C:\\Games',NULL,2,NULL,'2022-02-20 08:48:25','2022-02-20 08:57:57','',NULL),
    (1679,'cactusjack',NULL,'applicant','cf2b32b8c8e15a876c316594dec6ba82','D:\\Files\\AAF_Mods',NULL,2,NULL,'2022-02-26 08:23:33','2022-03-16 07:36:03','',NULL),
    (1680,'Neko',NULL,'member','8726bd401d0bdf1e55a3f6f85a73e00e','D:\\Scarlet Mods',NULL,2,NULL,'2022-02-27 07:45:38','2022-02-27 07:47:18','',NULL),
    (1681,'AdmiralSnoopDogg',NULL,'applicant','4927c8139f94ba85de164de235b63a5c','C:\\Users\\bosto\\Documents\\arma mods',NULL,2,NULL,'2022-02-27 08:19:40','2022-02-27 08:41:45','',NULL),
    (1683,'Amatus',NULL,'member','5d6d24a7546ba736cdd6e96aebe65044','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-02-27 08:39:03','2022-02-27 08:54:11','',NULL),
    (1684,'jonsnow',NULL,'applicant','33041f01032ebfb5331bcc92b814d7ee','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-02 08:24:43','2022-03-02 09:00:13','',NULL),
    (1685,'thenb',NULL,'member','4b4a7d91107c5b178303187a75779627','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\!Workshop',NULL,2,NULL,'2022-03-02 08:25:59','2022-03-02 08:29:53','',NULL),
    (1686,'nicholas',NULL,'recruit','ba2c1190ce4592e218daff58be3b4e20','D:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-02 08:33:04','2022-04-02 05:03:31','',NULL),
    (1687,'Braydenf97',NULL,'applicant','df72ec9682b08ef3b5bafecec9145a3a','D:\\Games\\steamapps\\common',NULL,2,NULL,'2022-03-03 06:14:35','2022-03-03 06:16:21','',NULL),
    (1689,'Clem',NULL,'recruit','375899a56608c83f38a54e8cc15913c7','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-12 06:30:47','2022-03-12 06:31:56','',NULL),
    (1690,'turbo',NULL,'member','24ba52692f823460959760af82e568b5','D:\\SteamLibrary\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2022-03-13 12:13:35','2022-03-22 11:10:43','',NULL),
    (1691,'Logic',NULL,'recruit','4b21dd09f395871ffe912c1440702dc6','D:\\SteamLibrary\\steamapps\\common\\Arma 3\\@Mods_AAF',NULL,2,NULL,'2022-03-13 12:13:59','2022-03-14 10:14:05','',NULL),
    (1692,'Wraith',NULL,'member','4aeff0e246ebae78a9029c91b56122b5','G:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-19 03:04:31','2022-03-19 03:10:22','',NULL),
    (1693,'Lawson',NULL,'applicant','9245cf355de6ba4ba79e448e89016220','E:\\Documents',NULL,2,NULL,'2022-03-20 08:52:10','2022-03-20 08:56:21','',NULL),
    (1694,'Callum',NULL,'applicant','cb28a70b9c730af49d90b19afedf6add','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\Arma 3 AAF Download Folder',NULL,2,NULL,'2022-03-20 08:52:16','2022-03-20 08:58:54','',NULL),
    (1695,'Foxman',NULL,'applicant','f51af52f8c0bbe0d8c0237e23ae2ab2e','F:\\Games\\Arma3 AAF',NULL,2,NULL,'2022-03-20 08:52:24','2022-03-20 09:05:18','',NULL),
    (1696,'Ilukeyz',NULL,'applicant','4bd1106d291604d5bd80c3dff275c450','E:\\ARMA Mods',NULL,2,NULL,'2022-03-20 08:52:43','2022-03-20 08:59:51','',NULL),
    (1697,'Poksi',NULL,'applicant','599c35121f530687d958e2f55d28391c','B:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-20 08:53:00','2022-03-20 08:57:12','',NULL),
    (1698,'TacoLiker',NULL,'applicant','720dc2645d437c99472d3bb055f91632','E:\\',NULL,2,NULL,'2022-03-20 08:53:11','2022-03-20 08:55:45','',NULL),
    (1699,'Nomad',NULL,'applicant','7b94410d55dc92c87018d6c8b9cb992b','A:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-22 08:05:40','2022-06-19 10:07:03','',NULL),
    (1700,'Skit',NULL,'member','75dbc078dd35db9262fec0fd3843613e','D:\\Steam\\steamapps\\common\\Arma 3\\Mods',NULL,2,NULL,'2022-03-22 19:40:18','2022-03-23 00:22:57','',NULL),
    (1701,'hazza',NULL,'member','b4206fef37d9b731b5d49c1b8928ecf4','E:\\SteamLibrary D\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-30 01:34:10','2022-03-30 08:34:08','',NULL),
    (1702,'griffith',NULL,'recruit','cc7a42f07c02e9d2180e330ba0e259aa','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-03-30 02:16:26','2022-04-23 10:31:58','',NULL),
    (1703,'Vice',NULL,'member','30ecb30c4ff0b19211e83ade2aa29d1d','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-04-02 05:32:45','2022-04-02 08:24:55','',NULL),
    (1704,'Jason952',NULL,'applicant','d592b02204eb293dab7517586a31eb4b','D:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-04-03 04:39:51','2022-04-03 04:59:57','',NULL),
    (1705,'Venom',NULL,'recruit','00107415ccde45256b34c5bb2b2e5e73','E:\\Scarlet mods',NULL,2,NULL,'2022-04-04 11:07:11','2022-04-06 10:55:04','',NULL),
    (1706,'ikmuk',NULL,'applicant','2d702bb76e8fb64781fdb1a20f41e67e','E:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-04-07 20:44:53','2022-04-08 06:12:01','',NULL),
    (1708,'Malus',NULL,'applicant','c66658252ac76a4f08a12966ebdaab38','F:\\AAF Mods',NULL,2,NULL,'2022-04-09 09:20:09','2022-04-09 09:20:33','',NULL),
    (1709,'Skitz',NULL,'applicant','cfd473ccb07803e758355d66ebdbca2d','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-04-16 10:01:32','2022-04-16 10:02:16','',NULL),
    (1710,'Cat',NULL,'applicant','71e70082aee321c2848cafe63f61f6db','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-04-24 10:00:50','2022-04-25 09:41:27','',NULL),
    (1711,'GalahadtheJust',NULL,'applicant','c96bdb5873b10c1f2839fa101eadb1d3','C:\\Users\\jorda\\Desktop',NULL,2,NULL,'2022-04-24 10:01:12','2022-04-24 10:09:10','',NULL),
    (1712,'Griffo',NULL,'applicant','c53956694b95c248747357f13520906e','G:\\AFF Mods',NULL,2,NULL,'2022-04-24 10:01:24','2022-04-24 10:07:54','',NULL),
    (1713,'Mad_dropbear',NULL,'applicant','d33d17797223bfdc1e0dadb57567990e','E:\\',NULL,2,NULL,'2022-04-24 10:01:33','2022-04-24 10:06:25','',NULL),
    (1714,'Oysenberry',NULL,'applicant','b716142b0831c3fec90ea6b13ca5379f','A:\\Scarlet Arma 3 Mods',NULL,2,NULL,'2022-04-24 10:01:44','2022-04-24 10:07:04','',NULL),
    (1715,'Project',NULL,'applicant','5bc87c24882c65a73bc536189636763e','B:\\',NULL,2,NULL,'2022-04-24 10:01:52','2022-04-24 10:05:35','',NULL),
    (1716,'Sammykins',NULL,'applicant','2c18c709f712b6fd98e01be08e319705','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-04-24 10:02:16','2022-04-24 10:04:40','',NULL),
    (1717,'Kordash',NULL,'applicant','3225d80cfcc8d6d02b43089b82ba4f2e','D:\\AAF Arma 3 Mods',NULL,2,NULL,'2022-04-24 12:48:42','2022-04-24 12:51:45','',NULL),
    (1718,'Crucial',NULL,'member','8538c01e2ef88f60fd6081ca2fe421bd',NULL,NULL,2,NULL,'2022-04-30 06:48:15','2022-04-30 06:48:23','',NULL),
    (1719,'PunishingDead',NULL,'applicant','107e3ce3d4e76c8dfa103c95de3df57b','S:\\Games\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-05-01 09:36:10','2022-05-01 09:40:35','',NULL),
    (1720,'PenguinSwims',NULL,'applicant','4513703383ed86e5930f67d5a6bd69a5','E:\\Arma3Scarlet',NULL,2,NULL,'2022-05-01 09:48:01','2022-05-01 09:49:15','',NULL),
    (1721,'BlueMaxima',NULL,'applicant','4d88f2807f01782adcf9c80f200d6f77','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-05-17 08:20:13','2022-05-17 08:29:26','',NULL),
    (1722,'Wedge Antillies',NULL,'recruit','f10ba7450ea185d71fafd3c0f573363c','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-05-24 09:00:29','2022-05-24 09:08:50','',NULL),
    (1723,'kiwi_twitches',NULL,'recruit','9552766f3a1d759860a1a9089135b7b7','D:\\SteamLibrary\\steamapps\\common\\Arma 3\\Scarlet',NULL,2,NULL,'2022-05-29 11:26:32','2022-05-29 11:30:27','',NULL),
    (1724,'DollaDylan',NULL,'applicant','1ea7d36a837b20b9b0529faf6c99d098','E:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-06-04 03:54:12','2022-06-04 03:55:50','',NULL),
    (1725,'Kerbin',NULL,'recruit','6b2867f24f0fcb8a98122aed0aa55d72','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-06-05 00:32:46','2022-06-12 09:45:15','',NULL),
    (1726,'Kerspatt',NULL,'recruit','c9bc3b8de43c8492a85e3058a6e6f847',NULL,NULL,2,NULL,'2022-06-07 11:05:47','2022-06-07 11:05:50','',NULL),
    (1727,'Mute',NULL,'applicant','85e25aabe13198c5439a8b822a426a45','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-06-12 10:23:28','2022-06-12 10:27:30','',NULL),
    (1728,'Ezilo20',NULL,'applicant','268b60cdaa73d07872d642fe7e84da5a','E:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-06-12 10:23:39','2022-06-12 10:28:53','',NULL),
    (1729,'Unstablef1sh',NULL,'applicant','eea1de6235fab5c85545249a04be6a79','D:\\SteamLibrary\\steamapps\\common\\Arma 3',NULL,2,NULL,'2022-06-12 10:24:15','2022-06-12 10:28:57','',NULL),
    (1730,'mace_ssenkrad',NULL,'applicant','051f598cd1da734ed13405933cea92aa','E:\\SteamLibrary\\steamapps\\common\\Arma 3\\aaf',NULL,2,NULL,'2022-06-12 10:24:26','2022-06-12 11:01:57','',NULL),
    (1731,'imperialism',NULL,'applicant','efa60d6d7c3b0e7b580db02aa7ecf139','C:\\Program Files (x86)\\Steam\\steamapps\\common\\Arma 3\\Addons',NULL,2,NULL,'2022-06-13 09:10:06','2022-06-13 09:11:17','',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
