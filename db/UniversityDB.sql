-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: UniversityDB
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.16.04.2

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
-- Table structure for table `Book`
--

DROP TABLE IF EXISTS `Book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Book` (
  `Book_ID` varchar(25) NOT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Author` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`Book_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Book`
--

LOCK TABLES `Book` WRITE;
/*!40000 ALTER TABLE `Book` DISABLE KEYS */;
/*!40000 ALTER TABLE `Book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Complaint`
--

DROP TABLE IF EXISTS `Complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Complaint` (
  `Complaint_ID` varchar(15) DEFAULT NULL,
  `Lodged_By` varchar(25) DEFAULT NULL,
  `Lodger_designation` varchar(25) DEFAULT NULL,
  `Description` varchar(150) DEFAULT NULL,
  `Status` varchar(25) DEFAULT NULL,
  `Lodge_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `Handler` varchar(25) DEFAULT NULL,
  `Location` varchar(25) DEFAULT NULL,
  `Lodger_Contact` varchar(20) DEFAULT NULL,
  KEY `Handler` (`Handler`),
  CONSTRAINT `Complaint_ibfk_1` FOREIGN KEY (`Handler`) REFERENCES `Staff` (`Staff_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Complaint`
--

LOCK TABLES `Complaint` WRITE;
/*!40000 ALTER TABLE `Complaint` DISABLE KEYS */;
/*!40000 ALTER TABLE `Complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Course`
--

DROP TABLE IF EXISTS `Course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Course` (
  `Course_No` varchar(8) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Dept_ID` varchar(10) NOT NULL,
  `Credits` int(11) DEFAULT NULL,
  PRIMARY KEY (`Course_No`),
  KEY `Dept_ID` (`Dept_ID`),
  CONSTRAINT `Course_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `Department` (`Dept_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Course`
--

LOCK TABLES `Course` WRITE;
/*!40000 ALTER TABLE `Course` DISABLE KEYS */;
INSERT INTO `Course` VALUES ('CS315','DBMS','AE',9);
/*!40000 ALTER TABLE `Course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Course_Bucket`
--

DROP TABLE IF EXISTS `Course_Bucket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Course_Bucket` (
  `Student_ID` varchar(20) NOT NULL,
  `Offering_ID` int(11) NOT NULL,
  PRIMARY KEY (`Student_ID`,`Offering_ID`),
  KEY `Offering_ID` (`Offering_ID`),
  CONSTRAINT `Course_Bucket_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `Student` (`Roll_Number`),
  CONSTRAINT `Course_Bucket_ibfk_2` FOREIGN KEY (`Offering_ID`) REFERENCES `Offering` (`Offering_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Course_Bucket`
--

LOCK TABLES `Course_Bucket` WRITE;
/*!40000 ALTER TABLE `Course_Bucket` DISABLE KEYS */;
/*!40000 ALTER TABLE `Course_Bucket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Degree_Desc`
--

DROP TABLE IF EXISTS `Degree_Desc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Degree_Desc` (
  `Dept_ID` varchar(10) NOT NULL,
  `Prog_ID` varchar(10) NOT NULL,
  `IC_Credits` int(11) DEFAULT NULL,
  `DC_Credits` int(11) DEFAULT NULL,
  `DE_Credits` int(11) DEFAULT NULL,
  `OE_Credits` int(11) DEFAULT NULL,
  `ESO_Credits` text,
  `HSS1_Credits` int(11) DEFAULT NULL,
  `HSS2_Credits` int(11) DEFAULT NULL,
  `UGP_Credits` int(11) DEFAULT NULL,
  `Thesis_Credits` int(11) DEFAULT NULL,
  `Total_Credits_Req` int(11) DEFAULT NULL,
  PRIMARY KEY (`Dept_ID`,`Prog_ID`),
  KEY `Prog_ID` (`Prog_ID`),
  CONSTRAINT `Degree_Desc_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `Department` (`Dept_ID`),
  CONSTRAINT `Degree_Desc_ibfk_2` FOREIGN KEY (`Prog_ID`) REFERENCES `Program` (`Prog_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Degree_Desc`
--

LOCK TABLES `Degree_Desc` WRITE;
/*!40000 ALTER TABLE `Degree_Desc` DISABLE KEYS */;
/*!40000 ALTER TABLE `Degree_Desc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Department` (
  `Dept_ID` varchar(10) NOT NULL,
  `Dept_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Dept_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Department`
--

LOCK TABLES `Department` WRITE;
/*!40000 ALTER TABLE `Department` DISABLE KEYS */;
INSERT INTO `Department` VALUES ('AE','Aerospace Engineering');
/*!40000 ALTER TABLE `Department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Enrollment`
--

DROP TABLE IF EXISTS `Enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Enrollment` (
  `Roll_Number` varchar(25) NOT NULL,
  `Offering_ID` int(11) NOT NULL,
  `Grade` int(11) DEFAULT NULL,
  `Course_Type` varchar(10) NOT NULL,
  PRIMARY KEY (`Roll_Number`,`Offering_ID`),
  KEY `Offering_ID` (`Offering_ID`),
  CONSTRAINT `Enrollment_ibfk_1` FOREIGN KEY (`Roll_Number`) REFERENCES `Student` (`Roll_Number`),
  CONSTRAINT `Enrollment_ibfk_2` FOREIGN KEY (`Offering_ID`) REFERENCES `Offering` (`Offering_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Enrollment`
--

LOCK TABLES `Enrollment` WRITE;
/*!40000 ALTER TABLE `Enrollment` DISABLE KEYS */;
/*!40000 ALTER TABLE `Enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Faculty`
--

DROP TABLE IF EXISTS `Faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Faculty` (
  `Faculty_ID` varchar(25) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Dept_ID` varchar(10) NOT NULL,
  `Designation` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Faculty_ID`),
  KEY `Dept_ID` (`Dept_ID`),
  CONSTRAINT `Faculty_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `Department` (`Dept_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Faculty`
--

LOCK TABLES `Faculty` WRITE;
/*!40000 ALTER TABLE `Faculty` DISABLE KEYS */;
INSERT INTO `Faculty` VALUES ('11563','P Nambodiri','AE','Assistant Professor','$2y$10$QYR6LZzZ4A4m2dlOgfvCou3h6HEEtygx9vHohTPFY0gDGJ4al8Dme'),('12345','Arnub','AE',NULL,'$2y$10$e24ESKh39r5c1bQ0MtGcweyvlHXXJfdvqmsKgb7KOC4vVlfJeyray'),('15642','P Nambodiri','AE',NULL,'$2y$10$5wqaREr8touLtwAq/G8KAOWt7jaZ1oO2G1VavIIm8aWdGSs3Kkv.6');
/*!40000 ALTER TABLE `Faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hostel`
--

DROP TABLE IF EXISTS `Hostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hostel` (
  `Hall_Number` varchar(10) NOT NULL,
  `Warden_Incharge` varchar(25) NOT NULL,
  PRIMARY KEY (`Hall_Number`,`Warden_Incharge`),
  KEY `Warden_Incharge` (`Warden_Incharge`),
  CONSTRAINT `Hostel_ibfk_1` FOREIGN KEY (`Warden_Incharge`) REFERENCES `Faculty` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hostel`
--

LOCK TABLES `Hostel` WRITE;
/*!40000 ALTER TABLE `Hostel` DISABLE KEYS */;
/*!40000 ALTER TABLE `Hostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IssueBook`
--

DROP TABLE IF EXISTS `IssueBook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IssueBook` (
  `ID` int(11) NOT NULL,
  `Book_ID` varchar(25) DEFAULT NULL,
  `Issued_To` varchar(25) DEFAULT NULL,
  `Issuer_Identity` varchar(20) DEFAULT NULL,
  `Issue_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `Due_Date` datetime DEFAULT NULL,
  `Return_Date` datetime DEFAULT NULL,
  `Penalty` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Book_ID` (`Book_ID`),
  CONSTRAINT `IssueBook_ibfk_1` FOREIGN KEY (`Book_ID`) REFERENCES `Book` (`Book_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IssueBook`
--

LOCK TABLES `IssueBook` WRITE;
/*!40000 ALTER TABLE `IssueBook` DISABLE KEYS */;
/*!40000 ALTER TABLE `IssueBook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lost_N_Found`
--

DROP TABLE IF EXISTS `Lost_N_Found`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lost_N_Found` (
  `ID` int(11) NOT NULL,
  `Lost_Or_Found` varchar(20) DEFAULT NULL,
  `Person_Involved` varchar(30) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lost_N_Found`
--

LOCK TABLES `Lost_N_Found` WRITE;
/*!40000 ALTER TABLE `Lost_N_Found` DISABLE KEYS */;
/*!40000 ALTER TABLE `Lost_N_Found` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Offering`
--

DROP TABLE IF EXISTS `Offering`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Offering` (
  `Offering_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Course_ID` varchar(8) NOT NULL,
  `Faculty_ID` varchar(25) NOT NULL,
  `Modular` int(11) DEFAULT '0',
  `Sem_ID` int(11) DEFAULT NULL,
  `Slot` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Offering_ID`),
  KEY `Sem_ID` (`Sem_ID`),
  KEY `Course_ID` (`Course_ID`),
  KEY `Faculty_ID` (`Faculty_ID`),
  CONSTRAINT `Offering_ibfk_1` FOREIGN KEY (`Sem_ID`) REFERENCES `Semester` (`Sem_ID`),
  CONSTRAINT `Offering_ibfk_2` FOREIGN KEY (`Course_ID`) REFERENCES `Course` (`Course_No`),
  CONSTRAINT `Offering_ibfk_3` FOREIGN KEY (`Faculty_ID`) REFERENCES `Faculty` (`Faculty_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Offering`
--

LOCK TABLES `Offering` WRITE;
/*!40000 ALTER TABLE `Offering` DISABLE KEYS */;
INSERT INTO `Offering` VALUES (2,'CS315','12345',0,1,NULL);
/*!40000 ALTER TABLE `Offering` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pre_req`
--

DROP TABLE IF EXISTS `Pre_req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pre_req` (
  `Course_ID` varchar(8) NOT NULL,
  `Pre_req_ID` varchar(8) NOT NULL,
  PRIMARY KEY (`Course_ID`,`Pre_req_ID`),
  KEY `Pre_req_ID` (`Pre_req_ID`),
  CONSTRAINT `Pre_req_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `Course` (`Course_No`),
  CONSTRAINT `Pre_req_ibfk_2` FOREIGN KEY (`Pre_req_ID`) REFERENCES `Course` (`Course_No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pre_req`
--

LOCK TABLES `Pre_req` WRITE;
/*!40000 ALTER TABLE `Pre_req` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pre_req` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Program`
--

DROP TABLE IF EXISTS `Program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Program` (
  `Prog_ID` varchar(10) NOT NULL,
  `Prog_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Prog_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Program`
--

LOCK TABLES `Program` WRITE;
/*!40000 ALTER TABLE `Program` DISABLE KEYS */;
INSERT INTO `Program` VALUES ('B.Tech','Bachelor of Technology');
/*!40000 ALTER TABLE `Program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Registration`
--

DROP TABLE IF EXISTS `Registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Registration` (
  `Roll_Number` varchar(25) NOT NULL,
  `Sem_ID` int(11) NOT NULL,
  `Credits` int(11) DEFAULT NULL,
  `SPI` decimal(10,0) DEFAULT NULL,
  `Fee_Status` tinyint(1) DEFAULT NULL,
  `Comments` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`Roll_Number`,`Sem_ID`),
  KEY `Sem_ID` (`Sem_ID`),
  CONSTRAINT `Registration_ibfk_1` FOREIGN KEY (`Roll_Number`) REFERENCES `Student` (`Roll_Number`),
  CONSTRAINT `Registration_ibfk_2` FOREIGN KEY (`Sem_ID`) REFERENCES `Semester` (`Sem_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Registration`
--

LOCK TABLES `Registration` WRITE;
/*!40000 ALTER TABLE `Registration` DISABLE KEYS */;
/*!40000 ALTER TABLE `Registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Semester`
--

DROP TABLE IF EXISTS `Semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Semester` (
  `Sem_ID` int(11) NOT NULL,
  `Year` int(4) DEFAULT NULL,
  `Type` int(1) DEFAULT NULL,
  PRIMARY KEY (`Sem_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Semester`
--

LOCK TABLES `Semester` WRITE;
/*!40000 ALTER TABLE `Semester` DISABLE KEYS */;
INSERT INTO `Semester` VALUES (1,2019,2);
/*!40000 ALTER TABLE `Semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Staff`
--

DROP TABLE IF EXISTS `Staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Staff` (
  `Staff_ID` varchar(25) NOT NULL,
  `Name` varchar(35) DEFAULT NULL,
  `Designation` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Staff_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Staff`
--

LOCK TABLES `Staff` WRITE;
/*!40000 ALTER TABLE `Staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `Staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student`
--

DROP TABLE IF EXISTS `Student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student` (
  `Roll_Number` varchar(25) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Dept_ID` varchar(10) NOT NULL,
  `Prog_ID` varchar(10) NOT NULL,
  `CPI` decimal(10,0) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `Hall_Number` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Roll_Number`),
  KEY `Dept_ID` (`Dept_ID`),
  KEY `Prog_ID` (`Prog_ID`),
  CONSTRAINT `Student_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `Department` (`Dept_ID`),
  CONSTRAINT `Student_ibfk_2` FOREIGN KEY (`Prog_ID`) REFERENCES `Program` (`Prog_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student`
--

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;
INSERT INTO `Student` VALUES ('150321','Vinay Kumar','AE','B.Tech',NULL,NULL,'$2y$10$U3aBAZPpWKDW5uAeHb/breD3mfJuKYgUC5v9LqKRdHi358oQAe2TW',NULL),('150456','Bishal','AE','B.Tech',NULL,NULL,'$2y$10$P5pRMTk5PscYCRqaZEyzNuyKGk3PNY4uSdYHbO6MTfYxG.iaq5BH2',NULL),('150801','Vinay','AE','B.Tech',NULL,NULL,'$2y$10$KC973XfB4/5ROVcy/L9QSOi4vdKCBypMuyQVZ6sTA/M7xNbh1hLUq',NULL);
/*!40000 ALTER TABLE `Student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `System_Admin`
--

DROP TABLE IF EXISTS `System_Admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `System_Admin` (
  `username` varchar(25) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `System_Admin`
--

LOCK TABLES `System_Admin` WRITE;
/*!40000 ALTER TABLE `System_Admin` DISABLE KEYS */;
INSERT INTO `System_Admin` VALUES ('heck','Desig','$2y$10$VcBa5Yb9wA3DFIiScKWnruVFw3W2ZE2atW1Q1ts3nao91gXFkrGiu');
/*!40000 ALTER TABLE `System_Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TA_Ship`
--

DROP TABLE IF EXISTS `TA_Ship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TA_Ship` (
  `Offering_ID` int(11) NOT NULL,
  `Roll_Number` varchar(25) NOT NULL,
  PRIMARY KEY (`Offering_ID`,`Roll_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TA_Ship`
--

LOCK TABLES `TA_Ship` WRITE;
/*!40000 ALTER TABLE `TA_Ship` DISABLE KEYS */;
/*!40000 ALTER TABLE `TA_Ship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Thesis`
--

DROP TABLE IF EXISTS `Thesis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Thesis` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Thesis_Code` varchar(10) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Dept_ID` varchar(10) NOT NULL,
  `Undertaken_By` varchar(25) NOT NULL,
  `Advisor` varchar(50) NOT NULL,
  `Credits` int(11) NOT NULL,
  `Semester` varchar(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Dept_ID` (`Dept_ID`),
  KEY `Undertaken_By` (`Undertaken_By`),
  KEY `Advisor` (`Advisor`),
  CONSTRAINT `Thesis_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `Department` (`Dept_ID`),
  CONSTRAINT `Thesis_ibfk_2` FOREIGN KEY (`Undertaken_By`) REFERENCES `Student` (`Roll_Number`),
  CONSTRAINT `Thesis_ibfk_3` FOREIGN KEY (`Advisor`) REFERENCES `Faculty` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Thesis`
--

LOCK TABLES `Thesis` WRITE;
/*!40000 ALTER TABLE `Thesis` DISABLE KEYS */;
/*!40000 ALTER TABLE `Thesis` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-16 16:45:40
