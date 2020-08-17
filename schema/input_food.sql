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
-- Table structure for table `input_food`
--

DROP TABLE IF EXISTS `input_food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `input_food` (
  `id` int(11) NOT NULL,
  `fdc_id` int(11) NOT NULL COMMENT 'fdc_id of the food that contains the input food',
  `fdc_id_of_input_food` int(11) DEFAULT NULL COMMENT 'fdc_id of the food that is the input food',
  `seq_num` int(11) DEFAULT NULL COMMENT 'The order in which to display the input food',
  `amount` decimal(8,2) DEFAULT NULL COMMENT 'The amount of the input food included within this food given in terms of unit',
  `sr_code` int(11) DEFAULT NULL COMMENT 'The SR (aka NDB) code of the SR food that is the ingredient food (used for Survey (FNDDS) foods only)',
  `sr_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The description of the SR food that is the ingredient food (used for Survey (FNDDS) foods only)',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The unit of measure for the amount of the input food that is included within this food (used for Survey (FNDDS) foods only)',
  `portion_code` int(11) DEFAULT NULL COMMENT 'Code that identifies the portion description used to measure the amount of the ingredient (used for Survey (FNDDS) foods only)',
  `portion_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The description of the portion used to measure the amount of the ingredient (used for Survey (FNDDS) foods only)',
  `gram_weight` decimal(10,4) DEFAULT NULL COMMENT 'The weight in grams of the input food',
  `retention_code` int(11) DEFAULT NULL COMMENT 'A numeric code identifying processing on the input food that may have impacted food nutrient content (used for Survey (FNDDS) foods only)',
  `survey_flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '2 = SR description does not match SR code, other values = internal processing codes for FSRG use only',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A food that is an ingredient (for survey (FNDDS) foods) or a source food (for foundation foods or their source foods) to another food.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-16 18:13:45
