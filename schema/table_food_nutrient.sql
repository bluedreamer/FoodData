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
-- Table structure for table `food_nutrient`
--

DROP TABLE IF EXISTS `food_nutrient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food_nutrient` (
  `id` int(11) NOT NULL,
  `fdc_id` int(11) NOT NULL COMMENT 'ID of the food this food nutrient pertains to',
  `nutrient_id` int(11) NOT NULL COMMENT 'ID of the nutrient to which the food nutrient pertains',
  `amount` decimal(15,4) DEFAULT NULL COMMENT 'Amount of the nutrient per 100g of food. Specified in unit defined in the nutrient',
  `data_points` int(11) DEFAULT NULL COMMENT 'Number of observations on which the value is based',
  `derivation_id` int(11) DEFAULT NULL COMMENT 'ID of the food nutrient derivation technique used to derive the value',
  `min` decimal(10,4) DEFAULT NULL COMMENT 'The minimum amount',
  `max` decimal(10,4) DEFAULT NULL COMMENT 'The maximum amount',
  `median` decimal(10,4) DEFAULT NULL COMMENT 'The median amount',
  `footnote` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comments on any unusual aspects of the food nutrient. Examples might include',
  `min_year_acquired` int(11) DEFAULT NULL COMMENT 'Minimum purchase year of all acquisitions used to derive the nutrient value',
  PRIMARY KEY (`id`),
  KEY `IDX_food_nutrient_fdc_id` (`fdc_id`),
  KEY `IDX_food_nutrient_nutrient_id` (`nutrient_id`),
  KEY `IDX_food_nutrient_derivation_id` (`derivation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A nutrient value for a food';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
