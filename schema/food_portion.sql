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
-- Table structure for table `food_portion`
--

DROP TABLE IF EXISTS `food_portion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food_portion` (
  `id` int(11) NOT NULL,
  `fdc_id` int(11) NOT NULL COMMENT 'ID of the food this food portion pertains to',
  `seq_num` int(11) DEFAULT NULL COMMENT 'The order the measure will be displayed on the released food.',
  `amount` decimal(8,2) DEFAULT NULL COMMENT 'The number of measure units that comprise the measure (e.g. if measure is 3 tsp, the amount is 3). Not defined for survey (FNDDS) foods (amount is instead embedded in portion description).',
  `measure_unit_id` int(11) NOT NULL COMMENT 'The unit used for the measure (e.g. if measure is 3 tsp, the unit is tsp). For food types that do not use measure SR legacy foods and survey (FNDDS) foods), a value of ''9999'' is assigned to this field.',
  `portion_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Foundation foods: Comments that provide more specificity on the measure. For example, for a pizza measure the dissemination text might be 1 slice is 1/8th of a 14 inch pizza"." Survey (FNDDS) foods: The household description of the portion.',
  `modifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Foundation foods: Qualifier of the measure (e.g. related to food shape or form) (e.g. melted, crushed, diced). Survey (FNDDS) foods: The portion code. SR legacy foods: description of measures, including the unit of measure and the measure modifier (e.g. waffle round (4" dia)).',
  `gram_weight` decimal(10,4) DEFAULT NULL COMMENT 'The weight of the measure in grams',
  `data_points` int(11) DEFAULT NULL COMMENT 'The number of observations on which the measure is based',
  `footnote` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comments on any unusual aspects of the measure. These are released to the public. Examples might include caveats on the usage of a measure, or reasons why a measure gram weight is an unexpected value.',
  `min_year_acquired` int(11) DEFAULT NULL COMMENT 'Minimum purchase year of all acquisitions used to derive the measure value',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Discrete amount of food';
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
