-- MySQL dump 10.13  Distrib 5.5.24, for Win32 (x86)
--
-- Host: localhost    Database: devrepublic_swount
-- ------------------------------------------------------
-- Server version	5.5.24-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `swount_admin`
--

DROP TABLE IF EXISTS `swount_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_admin`
--

LOCK TABLES `swount_admin` WRITE;
/*!40000 ALTER TABLE `swount_admin` DISABLE KEYS */;
INSERT INTO `swount_admin` VALUES (1,'edward@devrepublic.nl','237ee492a02ca073aa90abb0b566511e','Edward','Vernhout','A');
/*!40000 ALTER TABLE `swount_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_company`
--

DROP TABLE IF EXISTS `swount_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `cmp_name` varchar(100) NOT NULL,
  `cmp_streetname` varchar(100) NOT NULL,
  `cmp_housenumber` varchar(11) NOT NULL,
  `cmp_zipcode` varchar(10) NOT NULL,
  `cmp_towm` varchar(100) NOT NULL,
  `cmp_state` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `is_daily_email` enum('1','0') NOT NULL DEFAULT '0',
  `inv_invoice_reference` varchar(100) NOT NULL,
  `inv_payment_method` varchar(100) NOT NULL,
  `inv_streetname` varchar(100) NOT NULL,
  `inv_housenumber` varchar(11) NOT NULL,
  `inv_zipcode` varchar(11) NOT NULL,
  `inv_town` varchar(100) NOT NULL,
  `inv_state` varchar(100) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_connection` char(1) NOT NULL DEFAULT 'D',
  `status` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_company`
--

LOCK TABLES `swount_company` WRITE;
/*!40000 ALTER TABLE `swount_company` DISABLE KEYS */;
INSERT INTO `swount_company` VALUES (1,'Virtual Heaven','Praladnagar','1010-A','123456','Ahemedabad','Gujarat','Dinesh','','Goraniya','dinesh@devrepublic.nl','9638527410','1','INV','Cash','Praladnagar','1010-A','123456','Ahemedabad','Gujarat','Dinesh','237ee492a02ca073aa90abb0b566511e','D','A'),(2,'Devrepublic Wiki','Praladnagar','1010-A','123456','Ahemedabad','Gujarat','Soyab','','Rana','soyab@devrepublic.nl','9638527410','1','INV','Cash','Praladnagar','1010-A','123456','Ahemedabad','Gujarat','soyab','237ee492a02ca073aa90abb0b566511e','A','A');
/*!40000 ALTER TABLE `swount_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_company_db_configuration`
--

DROP TABLE IF EXISTS `swount_company_db_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_company_db_configuration` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `config_table_name` varchar(255) NOT NULL,
  `column_name` varchar(255) NOT NULL,
  `db_user_name` varchar(255) NOT NULL,
  `db_password` varchar(255) DEFAULT NULL,
  `database` varchar(255) NOT NULL,
  `database_link` varchar(500) NOT NULL,
  `budget_per_day` decimal(10,2) NOT NULL,
  `is_tested` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_company_db_configuration`
--

LOCK TABLES `swount_company_db_configuration` WRITE;
/*!40000 ALTER TABLE `swount_company_db_configuration` DISABLE KEYS */;
INSERT INTO `swount_company_db_configuration` VALUES (1,1,'user','email','drepublic_virhvn','virtualheaven','drepublic_virhvn','91.216.113.64',500.00,1),(2,2,'em_employees','business_mail_address','drepublic_drwiki','drwiki','drepublic_drwiki','91.216.113.64',500.00,0);
/*!40000 ALTER TABLE `swount_company_db_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_consumers`
--

DROP TABLE IF EXISTS `swount_consumers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_consumers` (
  `consumerid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL,
  `password` varchar(65) NOT NULL,
  `firstname` varchar(65) NOT NULL,
  `middlename` varchar(65) DEFAULT NULL,
  `lastname` varchar(65) NOT NULL,
  `email_address` varchar(65) NOT NULL,
  `phonenumber` varchar(15) DEFAULT NULL,
  `housenumber` varchar(10) DEFAULT NULL,
  `streetname` varchar(25) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `town` varchar(25) DEFAULT NULL,
  `status` enum('A','D') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`consumerid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_consumers`
--

LOCK TABLES `swount_consumers` WRITE;
/*!40000 ALTER TABLE `swount_consumers` DISABLE KEYS */;
INSERT INTO `swount_consumers` VALUES (1,'soyab','237ee492a02ca073aa90abb0b566511e','Soyab','Chandubhai','Rana','soyab@devrepublic.nl','9601516399','A/8','Gorwa','Gujarat','390016','Baroda','A');
/*!40000 ALTER TABLE `swount_consumers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_domain`
--

DROP TABLE IF EXISTS `swount_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_domain` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(25) NOT NULL,
  `domain_value` varchar(25) NOT NULL,
  `domain_description` varchar(50) NOT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_domain`
--

LOCK TABLES `swount_domain` WRITE;
/*!40000 ALTER TABLE `swount_domain` DISABLE KEYS */;
INSERT INTO `swount_domain` VALUES (1,'GENDER','M','Male'),(2,'GENDER','F','Female'),(3,'STATUS','A','Active'),(4,'STATUS','D','Deactive');
/*!40000 ALTER TABLE `swount_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_email`
--

DROP TABLE IF EXISTS `swount_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_email` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_type` varchar(200) CHARACTER SET utf8 NOT NULL,
  `email_subject` text CHARACTER SET utf8,
  `email_message` text CHARACTER SET utf8,
  `email_attachment` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `email_format_info` text CHARACTER SET utf8,
  `email_bcc_admin` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('A','D') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`email_id`),
  KEY `email_id` (`email_id`),
  KEY `email_id_2` (`email_id`),
  KEY `email_id_3` (`email_id`),
  KEY `email_id_4` (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_email`
--

LOCK TABLES `swount_email` WRITE;
/*!40000 ALTER TABLE `swount_email` DISABLE KEYS */;
INSERT INTO `swount_email` VALUES (1,'forgot_password','Forgot Password','<p>Hi &lt;username&gt;,</p>\r\n<p>You have requested for the new Passsword.</p>\r\n<p>Click the Below link to genrate a new password</p>\r\n<p>&lt;link&gt;</p>',NULL,'&lt;username&gt;, &lt;link&gt;',0,'A'),(2,'change_email','Change Email','<p>Hi &lt;username&gt;,</p>\r\n<p>Click the Below link to change the email address.</p>\r\n<p>&lt;link&gt;</p>',NULL,'&lt;username&gt;, &lt;link&gt;',0,'A');
/*!40000 ALTER TABLE `swount_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_email_change_request`
--

DROP TABLE IF EXISTS `swount_email_change_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_email_change_request` (
  `requestid` int(11) NOT NULL AUTO_INCREMENT,
  `consumerid` int(11) NOT NULL,
  `company_id` varchar(255) NOT NULL,
  `old_email` varchar(255) NOT NULL,
  `new_email` varchar(255) NOT NULL,
  `random_string` varchar(255) NOT NULL,
  `changes_done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`requestid`),
  UNIQUE KEY `random_string` (`random_string`),
  KEY `consumerid` (`consumerid`,`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_email_change_request`
--

LOCK TABLES `swount_email_change_request` WRITE;
/*!40000 ALTER TABLE `swount_email_change_request` DISABLE KEYS */;
INSERT INTO `swount_email_change_request` VALUES (1,1,'1','soyab@devrepublic.nl','rana@devrepublic.nl','LIjOdHsElEJAUXGXeDD5rerirXJmaW',1);
/*!40000 ALTER TABLE `swount_email_change_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_faq`
--

DROP TABLE IF EXISTS `swount_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_faq` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `faq_for` enum('company','consumer') NOT NULL DEFAULT 'company',
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_faq`
--

LOCK TABLES `swount_faq` WRITE;
/*!40000 ALTER TABLE `swount_faq` DISABLE KEYS */;
INSERT INTO `swount_faq` VALUES (1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere sed arcu sed fermentum. Vivamus faucibus, lorem in faucibus interdum, justo orci aliquam mauris, sed laoreet lectus felis a nibh. Proin sit amet nibh tempus turpis tristique luctus a eu tellus. Vivamus iaculis tortor placerat venenatis euismod. Maecenas in lorem et turpis tristique pharetra. Duis vitae dui nibh. Vestibulum varius condimentum odio, vel hendrerit nibh suscipit id. In hac habitasse platea dictumst. Integer dolor enim, dictum sit amet mauris sed, sagittis fermentum massa. Suspendisse potenti. Sed condimentum a augue eget faucibus.\r\n\r\nEtiam dapibus mi nulla, at viverra nibh sagittis nec. Pellentesque fringilla, risus quis aliquet dapibus, tortor neque porta tortor, eget pretium dui diam sed nibh. Ut auctor a sem quis ultricies. Praesent id pellentesque mauris, ac ultrices tortor. Nullam nisi risus, sagittis ut nisl eget, dignissim varius nulla. Fusce imperdiet orci et metus dictum tempus. Phasellus quis nibh vitae ipsum ullamcorper porttitor. Etiam vulputate, sem eget lacinia tincidunt, lectus felis posuere elit, a porta ipsum ante nec velit. Morbi id elementum mauris, eget consequat elit. Ut vel felis non magna lobortis laoreet. Maecenas vestibulum odio a erat sollicitudin tristique. Morbi placerat odio ac metus feugiat pharetra. Aliquam id nibh vitae est convallis sodales sed ut leo. Nunc nec condimentum elit. Aliquam congue elementum quam quis pharetra. Vivamus sit amet eros a nisi fringilla vulputate.','company'),(2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere sed arcu sed fermentum. Vivamus faucibus, lorem in faucibus interdum, justo orci aliquam mauris, sed laoreet lectus felis a nibh. Proin sit amet nibh tempus turpis tristique luctus a eu tellus. Vivamus iaculis tortor placerat venenatis euismod. Maecenas in lorem et turpis tristique pharetra. Duis vitae dui nibh. Vestibulum varius condimentum odio, vel hendrerit nibh suscipit id. In hac habitasse platea dictumst. Integer dolor enim, dictum sit amet mauris sed, sagittis fermentum massa. Suspendisse potenti. Sed condimentum a augue eget faucibus. Etiam dapibus mi nulla, at viverra nibh sagittis nec. Pellentesque fringilla, risus quis aliquet dapibus, tortor neque porta tortor, eget pretium dui diam sed nibh. Ut auctor a sem quis ultricies. Praesent id pellentesque mauris, ac ultrices tortor. Nullam nisi risus, sagittis ut nisl eget, dignissim varius nulla. Fusce imperdiet orci et metus dictum tempus. Phasellus quis nibh vitae ipsum ullamcorper porttitor. Etiam vulputate, sem eget lacinia tincidunt, lectus felis posuere elit, a porta ipsum ante nec velit. Morbi id elementum mauris, eget consequat elit. Ut vel felis non magna lobortis laoreet. Maecenas vestibulum odio a erat sollicitudin tristique. Morbi placerat odio ac metus feugiat pharetra. Aliquam id nibh vitae est convallis sodales sed ut leo. Nunc nec condimentum elit. Aliquam congue elementum quam quis pharetra. Vivamus sit amet eros a nisi fringilla vulputate.xcv</p>','company'),(3,'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere sed arcu sed fermentum. Vivamus faucibus, lorem in faucibus interdum, justo orci aliquam mauris, sed laoreet lectus felis a nibh. Proin sit amet nibh tempus turpis tristique luctus a eu tellus. Vivamus iaculis tortor placerat venenatis euismod. Maecenas in lorem et turpis tristique pharetra. Duis vitae dui nibh. Vestibulum varius condimentum odio, vel hendrerit nibh suscipit id. In hac habitasse platea dictumst. Integer dolor enim, dictum sit amet mauris sed, sagittis fermentum massa. Suspendisse potenti. Sed condimentum a augue eget faucibus.\r\n\r\nEtiam dapibus mi nulla, at viverra nibh sagittis nec. Pellentesque fringilla, risus quis aliquet dapibus, tortor neque porta tortor, eget pretium dui diam sed nibh. Ut auctor a sem quis ultricies. Praesent id pellentesque mauris, ac ultrices tortor. Nullam nisi risus, sagittis ut nisl eget, dignissim varius nulla. Fusce imperdiet orci et metus dictum tempus. Phasellus quis nibh vitae ipsum ullamcorper porttitor. Etiam vulputate, sem eget lacinia tincidunt, lectus felis posuere elit, a porta ipsum ante nec velit. Morbi id elementum mauris, eget consequat elit. Ut vel felis non magna lobortis laoreet. Maecenas vestibulum odio a erat sollicitudin tristique. Morbi placerat odio ac metus feugiat pharetra. Aliquam id nibh vitae est convallis sodales sed ut leo. Nunc nec condimentum elit. Aliquam congue elementum quam quis pharetra. Vivamus sit amet eros a nisi fringilla vulputate.','consumer'),(4,'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere sed arcu sed fermentum. Vivamus faucibus, lorem in faucibus interdum, justo orci aliquam mauris, sed laoreet lectus felis a nibh. Proin sit amet nibh tempus turpis tristique luctus a eu tellus. Vivamus iaculis tortor placerat venenatis euismod. Maecenas in lorem et turpis tristique pharetra. Duis vitae dui nibh. Vestibulum varius condimentum odio, vel hendrerit nibh suscipit id. In hac habitasse platea dictumst. Integer dolor enim, dictum sit amet mauris sed, sagittis fermentum massa. Suspendisse potenti. Sed condimentum a augue eget faucibus. Etiam dapibus mi nulla, at viverra nibh sagittis nec. Pellentesque fringilla, risus quis aliquet dapibus, tortor neque porta tortor, eget pretium dui diam sed nibh. Ut auctor a sem quis ultricies. Praesent id pellentesque mauris, ac ultrices tortor. Nullam nisi risus, sagittis ut nisl eget, dignissim varius nulla. Fusce imperdiet orci et metus dictum tempus. Phasellus quis nibh vitae ipsum ullamcorper porttitor. Etiam vulputate, sem eget lacinia tincidunt, lectus felis posuere elit, a porta ipsum ante nec velit. Morbi id elementum mauris, eget consequat elit. Ut vel felis non magna lobortis laoreet. Maecenas vestibulum odio a erat sollicitudin tristique. Morbi placerat odio ac metus feugiat pharetra. Aliquam id nibh vitae est convallis sodales sed ut leo. Nunc nec condimentum elit. Aliquam congue elementum quam quis pharetra. Vivamus sit amet eros a nisi fringilla vulputate.xcv</p>','consumer');
/*!40000 ALTER TABLE `swount_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_price_list`
--

DROP TABLE IF EXISTS `swount_price_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_price_list` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `price_name` varchar(255) NOT NULL,
  `price_value` decimal(5,2) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_price_list`
--

LOCK TABLES `swount_price_list` WRITE;
/*!40000 ALTER TABLE `swount_price_list` DISABLE KEYS */;
INSERT INTO `swount_price_list` VALUES (1,'100-200',25.00),(2,'200-500',0.23),(3,'500-1000',0.22);
/*!40000 ALTER TABLE `swount_price_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swount_texts`
--

DROP TABLE IF EXISTS `swount_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `swount_texts` (
  `text_id` int(11) NOT NULL AUTO_INCREMENT,
  `text_title` varchar(65) NOT NULL,
  `text_content` text NOT NULL,
  `text_for` enum('company','consumer') NOT NULL DEFAULT 'company',
  PRIMARY KEY (`text_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swount_texts`
--

LOCK TABLES `swount_texts` WRITE;
/*!40000 ALTER TABLE `swount_texts` DISABLE KEYS */;
INSERT INTO `swount_texts` VALUES (1,'About Us','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere sed arcu sed fermentum. Vivamus faucibus, lorem in faucibus interdum, justo orci aliquam mauris, sed laoreet lectus felis a nibh. Proin sit amet nibh tempus turpis tristique luctus a eu tellus. Vivamus iaculis tortor placerat venenatis euismod. Maecenas in lorem et turpis tristique pharetra. Duis vitae dui nibh. Vestibulum varius condimentum odio, vel hendrerit nibh suscipit id. In hac habitasse platea dictumst. Integer dolor enim, dictum sit amet mauris sed, sagittis fermentum massa. Suspendisse potenti. Sed condimentum a augue eget faucibus.</p>\r\n<p>Etiam dapibus mi nulla, at viverra nibh sagittis nec. Pellentesque fringilla, risus quis aliquet dapibus, tortor neque porta tortor, eget pretium dui diam sed nibh. Ut auctor a sem quis ultricies. Praesent id pellentesque mauris, ac ultrices tortor. Nullam nisi risus, sagittis ut nisl eget, dignissim varius nulla. Fusce imperdiet orci et metus dictum tempus. Phasellus quis nibh vitae ipsum ullamcorper porttitor. Etiam vulputate, sem eget lacinia tincidunt, lectus felis posuere elit, a porta ipsum ante nec velit. Morbi id elementum mauris, eget consequat elit. Ut vel felis non magna lobortis laoreet. Maecenas vestibulum odio a erat sollicitudin tristique. Morbi placerat odio ac metus feugiat pharetra. Aliquam id nibh vitae est convallis sodales sed ut leo. Nunc nec condimentum elit. Aliquam congue elementum quam quis pharetra. Vivamus sit amet eros a nisi fringilla vulputate.</p>\r\n<p>Vivamus mi urna, viverra vel felis tincidunt, molestie pretium felis. Mauris at fringilla erat. Maecenas vehicula eros at iaculis scelerisque. Suspendisse potenti. Nullam id blandit libero, in ornare lorem. Phasellus a eleifend lacus. Morbi luctus nec arcu et euismod. Mauris fringilla at quam sed ultrices. Duis aliquet dui et placerat laoreet. Nam vitae odio consectetur, malesuada nunc id, posuere quam. Maecenas varius enim in venenatis auctor. Nam id ipsum consectetur, luctus velit volutpat, vulputate purus. Nunc nisi arcu, iaculis sed ante sit amet, semper rutrum massa.</p>\r\n<p>Suspendisse potenti. Integer vitae sodales leo, eu pretium arcu. Sed pharetra erat eros, eu condimentum quam egestas sit amet. Duis vehicula placerat purus, ac commodo diam tempor a. Donec ut malesuada orci. Fusce vel fringilla turpis. Maecenas semper, diam vitae semper suscipit, erat leo feugiat metus, sed varius erat nibh in velit. Mauris vel erat sit amet massa dignissim euismod. Phasellus consectetur accumsan velit a aliquet. Suspendisse potenti. Sed luctus nulla id elit viverra, malesuada eleifend quam sollicitudin. Aliquam non justo tortor. Sed eget rhoncus odio, sit amet blandit ligula.</p>\r\n<p>Pellentesque faucibus facilisis eros, at sollicitudin leo. Nam egestas ligula sed nisl volutpat bibendum. Cras eros nibh, molestie eu vestibulum in, facilisis sit amet elit. Morbi tincidunt augue id metus mollis, vel vehicula quam consectetur. Praesent vulputate iaculis ligula in egestas. Morbi sit amet placerat leo. Ut sollicitudin sapien non euismod consectetur. In hac habitasse platea dictumst. Donec aliquam pharetra nibh luctus adipiscing. Suspendisse auctor sodales molestie. Ut non posuere massa, aliquam euismod orci.</p>','company'),(2,'Contact Us','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut elit metus. Curabitur vehicula odio magna, nec fermentum sem commodo vel. Mauris porta est sit amet nulla ultrices, vel tempus tortor auctor. Sed et mattis massa, vel condimentum enim. Quisque volutpat vitae velit in eleifend. Donec vehicula purus nisl, non commodo nunc congue quis. Phasellus a urna quis ante viverra tempor. Nulla egestas porttitor dolor, ut tristique dui porttitor at. Curabitur gravida ullamcorper dignissim. Aliquam aliquam massa vitae vestibulum iaculis. Nunc dignissim ultrices consectetur.\r\n\r\nMauris ut diam ultricies sapien ultricies laoreet vehicula in ipsum. Praesent vitae purus non lacus mollis suscipit eget luctus nulla. Sed risus erat, porttitor congue lacus ut, cursus porttitor ante. Aliquam condimentum lacus at placerat viverra. Nunc condimentum molestie nibh eu imperdiet. Etiam diam justo, porttitor ut risus ac, mollis elementum magna. Phasellus ut ante nisl. Maecenas id nibh eu neque facilisis varius. Phasellus euismod suscipit elit ut volutpat. Morbi velit tortor, commodo sed lectus vel, sodales interdum elit.\r\n\r\nFusce diam risus, fermentum in aliquam in, placerat in ipsum. Nam convallis ac ante non pharetra. Curabitur in egestas nulla. Quisque nec accumsan nunc. Aenean dolor nisi, blandit a quam nec, interdum viverra mauris. Praesent felis ipsum, tempus sit amet lobortis et, mollis sed libero. Etiam tempus ipsum non tincidunt luctus. Praesent sed ante vehicula, condimentum nulla eu, fermentum neque.\r\n\r\nPhasellus suscipit ut massa quis faucibus. Cras posuere nulla eget faucibus bibendum. Nullam egestas est sem, quis facilisis ante pulvinar vel. Nullam non velit vitae nulla rhoncus congue. Maecenas nunc tellus, auctor quis turpis non, ullamcorper aliquam sapien. Vestibulum ultricies tellus ac orci pulvinar facilisis. Maecenas rhoncus orci sed arcu fringilla placerat. Sed facilisis turpis fermentum dapibus semper. Ut adipiscing sollicitudin ante, at auctor justo cursus in. Vivamus nec mattis augue, eu sodales mauris. Morbi mollis, purus a hendrerit commodo, lectus libero ornare enim, vel imperdiet dui nisl in mauris. Phasellus velit neque, bibendum ac placerat et, gravida vel massa.','company'),(3,'Emial Closing Text','<p>After chnaging the emial address a conformation e-mail is send to your old email address.Please ckeck on the link in the email to activate the email change.Within 30 minutes after activation of the activation link,your email address will be changed.</p>','company'),(4,'Watch Demo','<p>\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p>','company'),(5,'About Us','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere sed arcu sed fermentum. Vivamus faucibus, lorem in faucibus interdum, justo orci aliquam mauris, sed laoreet lectus felis a nibh. Proin sit amet nibh tempus turpis tristique luctus a eu tellus. Vivamus iaculis tortor placerat venenatis euismod. Maecenas in lorem et turpis tristique pharetra. Duis vitae dui nibh. Vestibulum varius condimentum odio, vel hendrerit nibh suscipit id. In hac habitasse platea dictumst. Integer dolor enim, dictum sit amet mauris sed, sagittis fermentum massa. Suspendisse potenti. Sed condimentum a augue eget faucibus.</p>\n<p>Etiam dapibus mi nulla, at viverra nibh sagittis nec. Pellentesque fringilla, risus quis aliquet dapibus, tortor neque porta tortor, eget pretium dui diam sed nibh. Ut auctor a sem quis ultricies. Praesent id pellentesque mauris, ac ultrices tortor. Nullam nisi risus, sagittis ut nisl eget, dignissim varius nulla. Fusce imperdiet orci et metus dictum tempus. Phasellus quis nibh vitae ipsum ullamcorper porttitor. Etiam vulputate, sem eget lacinia tincidunt, lectus felis posuere elit, a porta ipsum ante nec velit. Morbi id elementum mauris, eget consequat elit. Ut vel felis non magna lobortis laoreet. Maecenas vestibulum odio a erat sollicitudin tristique. Morbi placerat odio ac metus feugiat pharetra. Aliquam id nibh vitae est convallis sodales sed ut leo. Nunc nec condimentum elit. Aliquam congue elementum quam quis pharetra. Vivamus sit amet eros a nisi fringilla vulputate.</p>\n<p>Vivamus mi urna, viverra vel felis tincidunt, molestie pretium felis. Mauris at fringilla erat. Maecenas vehicula eros at iaculis scelerisque. Suspendisse potenti. Nullam id blandit libero, in ornare lorem. Phasellus a eleifend lacus. Morbi luctus nec arcu et euismod. Mauris fringilla at quam sed ultrices. Duis aliquet dui et placerat laoreet. Nam vitae odio consectetur, malesuada nunc id, posuere quam. Maecenas varius enim in venenatis auctor. Nam id ipsum consectetur, luctus velit volutpat, vulputate purus. Nunc nisi arcu, iaculis sed ante sit amet, semper rutrum massa.</p>\n<p>Suspendisse potenti. Integer vitae sodales leo, eu pretium arcu. Sed pharetra erat eros, eu condimentum quam egestas sit amet. Duis vehicula placerat purus, ac commodo diam tempor a. Donec ut malesuada orci. Fusce vel fringilla turpis. Maecenas semper, diam vitae semper suscipit, erat leo feugiat metus, sed varius erat nibh in velit. Mauris vel erat sit amet massa dignissim euismod. Phasellus consectetur accumsan velit a aliquet. Suspendisse potenti. Sed luctus nulla id elit viverra, malesuada eleifend quam sollicitudin. Aliquam non justo tortor. Sed eget rhoncus odio, sit amet blandit ligula.</p>\n<p>Pellentesque faucibus facilisis eros, at sollicitudin leo. Nam egestas ligula sed nisl volutpat bibendum. Cras eros nibh, molestie eu vestibulum in, facilisis sit amet elit. Morbi tincidunt augue id metus mollis, vel vehicula quam consectetur. Praesent vulputate iaculis ligula in egestas. Morbi sit amet placerat leo. Ut sollicitudin sapien non euismod consectetur. In hac habitasse platea dictumst. Donec aliquam pharetra nibh luctus adipiscing. Suspendisse auctor sodales molestie. Ut non posuere massa, aliquam euismod orci.</p>','consumer'),(6,'Contact Us','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut elit metus. Curabitur vehicula odio magna, nec fermentum sem commodo vel. Mauris porta est sit amet nulla ultrices, vel tempus tortor auctor. Sed et mattis massa, vel condimentum enim. Quisque volutpat vitae velit in eleifend. Donec vehicula purus nisl, non commodo nunc congue quis. Phasellus a urna quis ante viverra tempor. Nulla egestas porttitor dolor, ut tristique dui porttitor at. Curabitur gravida ullamcorper dignissim. Aliquam aliquam massa vitae vestibulum iaculis. Nunc dignissim ultrices consectetur.\r\n\r\nMauris ut diam ultricies sapien ultricies laoreet vehicula in ipsum. Praesent vitae purus non lacus mollis suscipit eget luctus nulla. Sed risus erat, porttitor congue lacus ut, cursus porttitor ante. Aliquam condimentum lacus at placerat viverra. Nunc condimentum molestie nibh eu imperdiet. Etiam diam justo, porttitor ut risus ac, mollis elementum magna. Phasellus ut ante nisl. Maecenas id nibh eu neque facilisis varius. Phasellus euismod suscipit elit ut volutpat. Morbi velit tortor, commodo sed lectus vel, sodales interdum elit.\r\n\r\nFusce diam risus, fermentum in aliquam in, placerat in ipsum. Nam convallis ac ante non pharetra. Curabitur in egestas nulla. Quisque nec accumsan nunc. Aenean dolor nisi, blandit a quam nec, interdum viverra mauris. Praesent felis ipsum, tempus sit amet lobortis et, mollis sed libero. Etiam tempus ipsum non tincidunt luctus. Praesent sed ante vehicula, condimentum nulla eu, fermentum neque.\r\n\r\nPhasellus suscipit ut massa quis faucibus. Cras posuere nulla eget faucibus bibendum. Nullam egestas est sem, quis facilisis ante pulvinar vel. Nullam non velit vitae nulla rhoncus congue. Maecenas nunc tellus, auctor quis turpis non, ullamcorper aliquam sapien. Vestibulum ultricies tellus ac orci pulvinar facilisis. Maecenas rhoncus orci sed arcu fringilla placerat. Sed facilisis turpis fermentum dapibus semper. Ut adipiscing sollicitudin ante, at auctor justo cursus in. Vivamus nec mattis augue, eu sodales mauris. Morbi mollis, purus a hendrerit commodo, lectus libero ornare enim, vel imperdiet dui nisl in mauris. Phasellus velit neque, bibendum ac placerat et, gravida vel massa.','consumer'),(7,'Emial Closing Text','<p>After chnaging the emial address a conformation e-mail is send to your old email address.Please ckeck on the link in the email to activate the email change.Within 30 minutes after activation of the activation link,your email address will be changed.</p>','consumer'),(8,'Watch Demo','<p>\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"</p>','consumer');
/*!40000 ALTER TABLE `swount_texts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-21 15:55:35
