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
-- Table structure for table `branded_food`
--

DROP TABLE IF EXISTS `branded_food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branded_food` (
  `fdc_id` int(11) NOT NULL COMMENT 'ID of the food in the food table',
  `brand_owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Brand owner for the food',
  `gtin_upc` bigint(20) DEFAULT NULL COMMENT 'GTIN or UPC code identifying the food. Duplicate codes signify an update to the product, use the publication_date found in the food table to distinguish when each update was published, e.g. the latest publication date will be the most recent update of the product.',
  `ingredients` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The list of ingredients (as it appears on the product label)',
  `serving_size` decimal(10,4) DEFAULT NULL COMMENT 'The amount of the serving size when expressed as gram or ml',
  `serving_size_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The unit used to express the serving size (gram or ml)',
  `household_serving_fulltext` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Amount and unit of serving size when expressed in household units',
  `branded_food_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The category of the branded food, assigned by GDSN or Label Insight',
  `data_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The source of the data for this food. GDSN (for GS1) or LI (for Label Insight).',
  `modified_date` date NOT NULL COMMENT 'This date reflects when the product data was last modified by the data provider,',
  `available_date` date DEFAULT NULL COMMENT 'This is the date when the product record was available for inclusion in the',
  `discontinued_date` date DEFAULT NULL COMMENT 'This is the date when the product was discontinued.',
  `market_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The primary country where the product is marketed.',
  PRIMARY KEY (`fdc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Foods whose nutrient values are typically obtained from food label data provided by food brand owners.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-16 18:13:44
