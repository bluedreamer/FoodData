-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for Linux (x86_64)
--
-- Host: eagle    Database: usda
-- ------------------------------------------------------
-- Server version	10.4.13-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `market_acquisition`
--

DROP TABLE IF EXISTS `market_acquisition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `market_acquisition` (
  `fdc_id` int(11) NOT NULL COMMENT 'ID of the food in the food table',
  `brand_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Brand name description of the food',
  `expiration_date` date DEFAULT NULL COMMENT 'Date the food will expire',
  `label_weight` int(11) DEFAULT NULL COMMENT 'The weight of the food per the product label',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The region in which the food was purchased, e.g. CA1',
  `acquisition_date` date DEFAULT NULL COMMENT 'Date the food was purchased',
  `sales_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The type of establishment in which the food was acquired (e.g. Retail Store,',
  `sample_lot_nbr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The lot number of the food',
  `sell_by_date` date DEFAULT NULL COMMENT 'Date the food should be sold by',
  `store_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The city where the food was acquired',
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The name of the store the food is purchased from',
  `store_state` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The state where the food was acquired',
  `upc_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'UPC code for the food. Only applicable for retail products.',
  PRIMARY KEY (`fdc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A food obtained for chemical analysis.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-16 12:04:17
